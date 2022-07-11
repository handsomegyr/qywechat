<?php

namespace Qyweixin\Manager\ExternalContact;

use Qyweixin\Client;

/**
 * 客户联系「联系我」管理
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class ContactWay
{

	// 接口地址
	private $_url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/';
	private $_client;
	private $_request;
	public function __construct(Client $client)
	{
		$this->_client = $client;
		$this->_request = $client->getRequest();
	}
	/**
	 * 获取企业已配置的「联系我」列表
	 * 获取企业配置的「联系我」二维码和「联系我」小程序插件列表。不包含临时会话。
	 * 注意，该接口仅可获取2021年7月10日以后创建的「联系我」
	 * 请求方式：POST（HTTPS）
	 * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/externalcontact/list_contact_way?access_token=ACCESS_TOKEN
	 *
	 * 请求示例：
	 *
	 * {
	 * "start_time":1622476800,
	 * "end_time":1625068800,
	 * "cursor":"CURSOR",
	 * "limit":1000
	 * }
	 * 参数说明：
	 *
	 * 参数 必须 说明
	 * access_token 是 调用接口凭证
	 * start_time 否 「联系我」创建起始时间戳, 默认为90天前
	 * end_time 否 「联系我」创建结束时间戳, 默认为当前时间
	 * cursor 否 分页查询使用的游标，为上次请求返回的 next_cursor
	 * limit 否 每次查询的分页大小，默认为100条，最多支持1000条
	 *
	 *
	 * 返回结果：
	 *
	 * {
	 * "errcode": 0,
	 * "errmsg": "ok",
	 * "contact_way":
	 * [
	 * {
	 * "config_id":"534b63270045c9ABiKEE814ef56d91c62f"
	 * }，
	 * {
	 * "config_id":"87bBiKEE811c62f63270041c62f5c9A4ef"
	 * }
	 * ],
	 * "next_cursor":"NEXT_CURSOR"
	 * }
	 * 参数说明：
	 *
	 * 参数 说明
	 * errcode 返回码
	 * errmsg 对返回码的文本描述内容
	 * contact_way.config_id 联系方式的配置id
	 * next_cursor 分页参数，用于查询下一个分页的数据，为空时表示没有更多的分页
	 */
	public function getList($start_time = 0, $end_time = 0, $cursor, $limit = 1000)
	{
		$params = array();
		if ($start_time) {
			$params['start_time'] = $start_time;
		}
		if ($end_time) {
			$params['end_time'] = $end_time;
		}
		$params['cursor'] = $cursor;
		$params['limit'] = $limit;
		$rst = $this->_request->post($this->_url . 'list_contact_way', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 配置客户联系「联系我」方式
	 * 企业可以在管理后台-客户联系中配置成员的「联系我」的二维码或者小程序按钮，客户通过扫描二维码或点击小程序上的按钮，即可获取成员联系方式，主动联系到成员。
	 * 企业可通过此接口为具有客户联系功能的成员生成专属的「联系我」二维码或者「联系我」按钮。
	 * 如果配置的是「联系我」按钮，需要开发者的小程序接入小程序插件。
	 *
	 * 注意:
	 * 通过API添加的「联系我」不会在管理端进行展示，每个企业可通过API最多配置50万个「联系我」。
	 * 用户需要妥善存储返回的config_id，config_id丢失可能导致用户无法编辑或删除「联系我」。
	 * 临时会话模式不占用「联系我」数量，但每日最多添加10万个，并且仅支持单人。
	 * 临时会话模式的二维码，添加好友完成后该二维码即刻失效。
	 *
	 * 请求方式：POST（HTTPS）
	 * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/externalcontact/add_contact_way?access_token=ACCESS_TOKEN
	 *
	 * 请求示例：
	 *
	 * {
	 * "type" :1,
	 * "scene":1,
	 * "style":1,
	 * "remark":"渠道客户",
	 * "skip_verify":true,
	 * "state":"teststate",
	 * "user" : ["UserID1", "UserID2", "UserID3"],
	 * "party" : [PartyID1, PartyID2],
	 * "is_temp":true,
	 * "expires_in":86400,
	 * "chat_expires_in":86400,
	 * "unionid":"oxTWIuGaIt6gTKsQRLau2M0AAAA",
	 * "conclusions":
	 * {
	 * "text":
	 * {
	 * "content":"文本消息内容"
	 * },
	 * "image":
	 * {
	 * "media_id": "MEDIA_ID"
	 * },
	 * "link":
	 * {
	 * "title": "消息标题",
	 * "picurl": "https://example.pic.com/path",
	 * "desc": "消息描述",
	 * "url": "https://example.link.com/path"
	 * },
	 * "miniprogram":
	 * {
	 * "title": "消息标题",
	 * "pic_media_id": "MEDIA_ID",
	 * "appid": "wx8bd80126147dfAAA",
	 * "page": "/path/index"
	 * }
	 * }
	 * }
	 * 参数说明：
	 *
	 * 参数 必须 说明
	 * access_token 是 调用接口凭证
	 * type 是 联系方式类型,1-单人, 2-多人
	 * scene 是 场景，1-在小程序中联系，2-通过二维码联系
	 * style 否 在小程序中联系时使用的控件样式，详见附表
	 * remark 否 联系方式的备注信息，用于助记，不超过30个字符
	 * skip_verify 否 外部客户添加时是否无需验证，默认为true
	 * state 否 企业自定义的state参数，用于区分不同的添加渠道，在调用“获取外部联系人详情”时会返回该参数值，不超过30个字符
	 * user 否 使用该联系方式的用户userID列表，在type为1时为必填，且只能有一个
	 * party 否 使用该联系方式的部门id列表，只在type为2时有效
	 * is_temp 否 是否临时会话模式，true表示使用临时会话模式，默认为false
	 * expires_in 否 临时会话二维码有效期，以秒为单位。该参数仅在is_temp为true时有效，默认7天
	 * chat_expires_in 否 临时会话有效期，以秒为单位。该参数仅在is_temp为true时有效，默认为添加好友后24小时
	 * unionid 否 可进行临时会话的客户unionid，该参数仅在is_temp为true时有效，如不指定则不进行限制
	 * conclusions 否 结束语，会话结束时自动发送给客户，可参考“结束语定义”，仅在is_temp为true时有效
	 * 注意，每个联系方式最多配置100个使用成员（包含部门展开后的成员）
	 * 当设置为临时会话模式时（即is_temp为true），联系人仅支持配置为单人，暂不支持多人
	 * 使用unionid需要调用方（企业或服务商）的企业微信“客户联系”中已绑定微信开发者账户
	 *
	 * 返回结果：
	 *
	 * {
	 * "errcode": 0,
	 * "errmsg": "ok",
	 * "config_id":"42b34949e138eb6e027c123cba77fAAA"　　
	 * }
	 * 参数说明：
	 *
	 * 参数 说明
	 * errcode 返回码
	 * errmsg 对返回码的文本描述内容
	 * config_id 新增联系方式的配置id
	 */
	public function add(\Qyweixin\Model\ExternalContact\ContactWay $contactWay)
	{
		$params = $contactWay->getParams();
		$rst = $this->_request->post($this->_url . 'add_contact_way', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 获取企业已配置的「联系我」方式
	 * 批量获取企业配置的「联系我」二维码和「联系我」小程序按钮。
	 * 请求方式：POST（HTTPS）
	 * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/externalcontact/get_contact_way?access_token=ACCESS_TOKEN
	 *
	 * 请求示例：
	 *
	 * {
	 * "config_id":"42b34949e138eb6e027c123cba77fad7"
	 * }
	 * 参数说明：
	 *
	 * 参数 必须 说明
	 * access_token 是 调用接口凭证
	 * config_id 是 联系方式的配置id
	 * 返回结果：
	 *
	 * {
	 * "errcode": 0,
	 * "errmsg": "ok",
	 * "contact_way":
	 * {
	 * "config_id":"42b34949e138eb6e027c123cba77fAAA",
	 * "type":1,
	 * "scene":1,
	 * "style":2,
	 * "remark":"test remark",
	 * "skip_verify":true,
	 * "state":"teststate",
	 * "qr_code":"http://p.qpic.cn/wwhead/duc2TvpEgSdicZ9RrdUtBkv2UiaA/0",
	 * "user" : ["UserID1", "UserID2", "UserID3"],
	 * "party" : [PartyID1, PartyID2]，
	 * "is_temp":true,
	 * "expires_in":86400,
	 * "chat_expires_in":86400,
	 * "unionid":"oxTWIuGaIt6gTKsQRLau2M0AAAA",
	 * "conclusions":
	 * {
	 * "text":
	 * {
	 * "content":"文本消息内容"
	 * },
	 * "image":
	 * {
	 * "pic_url": "http://p.qpic.cn/pic_wework/XXXXX"
	 * },
	 * "link":
	 * {
	 * "title": "消息标题",
	 * "picurl": "https://example.pic.com/path",
	 * "desc": "消息描述",
	 * "url": "https://example.link.com/path"
	 * },
	 * "miniprogram":
	 * {
	 * "title": "消息标题",
	 * "pic_media_id": "MEDIA_ID",
	 * "appid": "wx8bd80126147dfAAA",
	 * "page": "/path/index"
	 * }
	 * }
	 * }
	 * }
	 * 参数说明：
	 *
	 * 参数 说明
	 * errcode 返回码
	 * errmsg 对返回码的文本描述内容
	 * config_id 新增联系方式的配置id
	 * type 联系方式类型，1-单人，2-多人
	 * scene 场景，1-在小程序中联系，2-通过二维码联系
	 * is_temp 是否临时会话模式，默认为false，true表示使用临时会话模式
	 * remark 联系方式的备注信息，用于助记
	 * skip_verify 外部客户添加时是否无需验证
	 * state 企业自定义的state参数，用于区分不同的添加渠道，在调用“获取外部联系人详情”时会返回该参数值
	 * style 小程序中联系按钮的样式，仅在scene为1时返回，详见附录
	 * qr_code 联系二维码的URL，仅在scene为2时返回
	 * user 使用该联系方式的用户userID列表
	 * party 使用该联系方式的部门id列表
	 * expires_in 临时会话二维码有效期，以秒为单位
	 * chat_expires_in 临时会话有效期，以秒为单位
	 * unionid 可进行临时会话的客户unionid
	 * conclusions 结束语，可参考“结束语定义”
	 */
	public function get($config_id)
	{
		$params = array();
		$params['config_id'] = $config_id;
		$rst = $this->_request->post($this->_url . 'get_contact_way', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 更新企业已配置的「联系我」方式
	 * 更新企业配置的「联系我」二维码和「联系我」小程序按钮中的信息，如使用人员和备注等。
	 *
	 * 请求方式：POST（HTTPS）
	 * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/externalcontact/update_contact_way?access_token=ACCESS_TOKEN
	 *
	 * 请求示例：
	 *
	 * {
	 * "config_id":"42b34949e138eb6e027c123cba77fAAA",
	 * "remark":"渠道客户",
	 * "skip_verify":true,
	 * "style":1,
	 * "state":"teststate",
	 * "user" : ["UserID1", "UserID2", "UserID3"],
	 * "party" : [PartyID1, PartyID2],
	 * "expires_in":86400,
	 * "chat_expires_in":86400，
	 * "unionid":"oxTWIuGaIt6gTKsQRLau2M0AAAA",
	 * "conclusions":
	 * {
	 * "text":
	 * {
	 * "content":"文本消息内容"
	 * },
	 * "image":
	 * {
	 * "media_id": "MEDIA_ID"
	 * },
	 * "link":
	 * {
	 * "title": "消息标题",
	 * "picurl": "https://example.pic.com/path",
	 * "desc": "消息描述",
	 * "url": "https://example.link.com/path"
	 * },
	 * "miniprogram":
	 * {
	 * "title": "消息标题",
	 * "pic_media_id": "MEDIA_ID",
	 * "appid": "wx8bd80126147dfAAA",
	 * "page": "/path/index"
	 * }
	 * }
	 * }
	 * 参数说明：
	 *
	 * 参数 必须 说明
	 * access_token 是 调用接口凭证
	 * config_id 是 企业联系方式的配置id
	 * remark 否 联系方式的备注信息，不超过30个字符，将覆盖之前的备注
	 * skip_verify 否 外部客户添加时是否无需验证
	 * style 否 样式，只针对“在小程序中联系”的配置生效
	 * state 否 企业自定义的state参数，用于区分不同的添加渠道，在调用“获取外部联系人详情”时会返回该参数值
	 * user 否 使用该联系方式的用户列表，将覆盖原有用户列表
	 * party 否 使用该联系方式的部门列表，将覆盖原有部门列表，只在配置的type为2时有效
	 * expires_in 否 临时会话二维码有效期，以秒为单位，该参数仅在临时会话模式下有效
	 * chat_expires_in 否 临时会话有效期，以秒为单位，该参数仅在临时会话模式下有效
	 * unionid 否 可进行临时会话的客户unionid，该参数仅在临时会话模式有效，如不指定则不进行限制
	 * conclusions 否 结束语，会话结束时自动发送给客户，可参考“结束语定义”，仅临时会话模式（is_temp为true）可设置
	 * 注意：已失效的临时会话联系方式无法进行编辑
	 * 当临时会话模式时（即is_temp为true），联系人仅支持配置为单人，暂不支持多人
	 *
	 * 返回结果：
	 *
	 * {
	 * "errcode": 0,
	 * "errmsg": "ok"
	 * }
	 * 参数说明：
	 *
	 * 参数 说明
	 * errcode 返回码
	 * errmsg 对返回码的文本描述内容
	 */
	public function update(\Qyweixin\Model\ExternalContact\ContactWay $contactWay)
	{
		$params = $contactWay->getParams();
		$rst = $this->_request->post($this->_url . 'update_contact_way', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 删除企业已配置的「联系我」方式
	 * 删除一个已配置的「联系我」二维码或者「联系我」小程序按钮。
	 * 请求方式：POST（HTTPS）
	 * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/externalcontact/del_contact_way?access_token=ACCESS_TOKEN
	 *
	 * 请求示例：
	 *
	 * {
	 * "config_id":"42b34949e138eb6e027c123cba77fAAA"
	 * }
	 * 参数说明：
	 *
	 * 参数 必须 说明
	 * access_token 是 调用接口凭证
	 * config_id 是 企业联系方式的配置id
	 * 返回结果：
	 *
	 * {
	 * "errcode": 0,
	 * "errmsg": "ok",
	 * }
	 * 参数说明：
	 *
	 * 参数 说明
	 * errcode 返回码
	 * errmsg 对返回码的文本描述内容
	 */
	public function del($config_id)
	{
		$params = array();
		$params['config_id'] = $config_id;
		$rst = $this->_request->post($this->_url . 'del_contact_way', $params);
		return $this->_client->rst($rst);
	}
}
