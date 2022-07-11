<?php

namespace Qyweixin\Manager\ExternalContact\GroupChat;

use Qyweixin\Client;

/**
 * 客户群「加入群聊」管理
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class JoinWay
{

	// 接口地址
	private $_url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/groupchat/';
	private $_client;
	private $_request;
	public function __construct(Client $client)
	{
		$this->_client = $client;
		$this->_request = $client->getRequest();
	}

	/**
	 * 配置客户群进群方式
	 * 企业可以在管理后台-客户联系中配置「加入群聊」的二维码或者小程序按钮，客户通过扫描二维码或点击小程序上的按钮，即可加入特定的客户群。
	 * 企业可通过此接口为具有客户联系功能的成员生成专属的二维码或者小程序按钮。
	 * 如果配置的是小程序按钮，需要开发者的小程序接入小程序插件。
	 * 注意:
	 * 通过API添加的配置不会在管理端进行展示，每个企业可通过API最多配置50万个「加入群聊」(与「联系我」共用50万的额度)。
	 *
	 * 请求方式：POST（HTTPS）
	 * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/externalcontact/groupchat/add_join_way?access_token=ACCESS_TOKEN
	 *
	 * 请求示例：
	 *
	 * {
	 * "scene": 2,
	 * "remark": "aa_remark",
	 * "auto_create_room": 1,
	 * "room_base_name" : "销售客服群",
	 * "room_base_id" : 10,
	 * "chat_id_list": [
	 * "wrOgQhDgAAH2Yy-CTZ6POca8mlBEdaaa",
	 * "wrOgQhDgAALPUthpRAKvl7mgiQRwAAA"
	 * ],
	 * "state" : "klsdup3kj3s1"
	 * }
	 * 参数说明：
	 *
	 * 参数 必须 说明
	 * access_token 是 调用接口凭证
	 * scene 是 场景。
	 * 1 - 群的小程序插件
	 * 2 - 群的二维码插件
	 * remark 否 联系方式的备注信息，用于助记，超过30个字符将被截断
	 * auto_create_room 否 当群满了后，是否自动新建群。0-否；1-是。 默认为1
	 * room_base_name 否 自动建群的群名前缀，当auto_create_room为1时有效。最长40个utf8字符
	 * room_base_id 否 自动建群的群起始序号，当auto_create_room为1时有效
	 * chat_id_list 是 使用该配置的客户群ID列表，支持5个。见客户群ID获取方法
	 * state 否 企业自定义的state参数，用于区分不同的入群渠道。不超过30个UTF-8字符
	 * 如果有设置此参数，在调用获取客户群详情接口时会返回每个群成员对应的该参数值，详见文末附录2
	 * room_base_name 和 room_base_id 两个参数配合，用于指定自动新建群的群名
	 * 例如，假如 room_base_name = "销售客服群", room_base_id = 10
	 * 那么，自动创建的第一个群，群名为“销售客服群10”；自动创建的第二个群，群名为“销售客服群11”，依次类推
	 * 返回结果：
	 *
	 * {
	 * "errcode": 0,
	 * "errmsg": "ok",
	 * "config_id": "9ad7fa5cdaa6511298498f979c472aaa"
	 * }
	 * 参数说明：
	 *
	 * 参数 说明
	 * errcode 返回码
	 * errmsg 对返回码的文本描述内容
	 * config_id 配置id
	 */
	public function add(\Qyweixin\Model\ExternalContact\GroupChat\JoinWay $joinWay)
	{
		$params = $joinWay->getParams();
		$rst = $this->_request->post($this->_url . 'add_join_way', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 获取客户群进群方式配置
	 * 获取企业配置的群二维码或小程序按钮。
	 * 请求方式：POST（HTTPS）
	 * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/externalcontact/groupchat/get_join_way?access_token=ACCESS_TOKEN
	 *
	 * 请求示例：
	 *
	 * {
	 * "config_id":"9ad7fa5cdaa6511298498f979c472aaa"
	 * }
	 * 参数说明：
	 *
	 * 参数 必须 说明
	 * access_token 是 调用接口凭证
	 * config_id 是 联系方式的配置id
	 *
	 *
	 * 返回结果：
	 *
	 * {
	 * "errcode": 0,
	 * "errmsg": "ok",
	 * "join_way": {
	 * "config_id": "9ad7fa5cdaa6511298498f979c472aaa",
	 * "scene": 2,
	 * "remark": "aa_remark",
	 * "auto_create_room": 1,
	 * "room_base_name" : "销售客服群",
	 * "room_base_id" : 10,
	 * "chat_id_list": ["wrOgQhDgAAH2Yy-CTZ6POca8mlBEdaaa", "wrOgQhDgAALPUthpRAKvl7mgiQRw_aaa"],
	 * "qr_code": "http://p.qpic.cn/wwhead/nMl9ssowtibVGyrmvBiaibzDtp703nXuzpibnKtbSDBRJTLwS3ic4ECrf3ibLVtIFb0N6wWwy5LVuyvMQ22/0",
	 * "state" : "klsdup3kj3s1"
	 * }
	 * }
	 * 参数说明：
	 *
	 * 参数 说明
	 * errcode 返回码
	 * errmsg 对返回码的文本描述内容
	 * join_way 配置详情
	 * config_id 新增联系方式的配置id
	 * scene 场景。
	 * 1 - 群的小程序插件
	 * 2 - 群的二维码插件
	 * remark 联系方式的备注信息，用于助记，超过30个字符将被截断
	 * auto_create_room 当群满了后，是否自动新建群。0-否；1-是。 默认为1
	 * room_base_name 自动建群的群名前缀，当auto_create_room为1时有效。最长40个utf8字符
	 * room_base_id 自动建群的群起始序号，当auto_create_room为1时有效
	 * chat_id_list 使用该配置的客户群ID列表。见客户群ID获取方法
	 * qr_code 联系二维码的URL，仅在配置为群二维码时返回
	 * state 企业自定义的state参数，用于区分不同的入群渠道。不超过30个UTF-8字符
	 * 如果有设置此参数，在调用获取客户群详情接口时会返回每个群成员对应的该参数值，详见文末附录2
	 */
	public function get($config_id)
	{
		$params = array();
		$params['config_id'] = $config_id;
		$rst = $this->_request->post($this->_url . 'get_join_way', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 更新客户群进群方式配置
	 * 更新进群方式配置信息。注意：使用覆盖的方式更新。
	 *
	 * 请求方式：POST（HTTPS）
	 * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/externalcontact/groupchat/update_join_way?access_token=ACCESS_TOKEN
	 *
	 * 请求示例：
	 *
	 * {
	 * "config_id": "9ad7fa5cdaa6511298498f979c4722de",
	 * "scene": 2,
	 * "remark": "bb_remark",
	 * "auto_create_room": 1,
	 * "room_base_name" : "销售客服群",
	 * "room_base_id" : 10,
	 * "chat_id_list": ["wrOgQhDgAAH2Yy-CTZ6POca8mlBEdaaa", "wrOgQhDgAALPUthpRAKvl7mgiQRw_aaa"],
	 * "state" : "klsdup3kj3s1"
	 * }
	 * 参数说明：
	 *
	 * 参数 必须 说明
	 * access_token 是 调用接口凭证
	 * config_id 是 企业联系方式的配置id
	 * scene 是 场景。
	 * 1 - 群的小程序插件
	 * 2 - 群的二维码插件
	 * remark 否 联系方式的备注信息，用于助记，超过30个字符将被截断
	 * auto_create_room 否 当群满了后，是否自动新建群。0-否；1-是。 默认为1
	 * room_base_name 否 自动建群的群名前缀，当auto_create_room为1时有效。最长40个utf8字符
	 * room_base_id 否 自动建群的群起始序号，当auto_create_room为1时有效
	 * chat_id_list 是 使用该配置的客户群ID列表，支持5个。见客户群ID获取方法
	 * state 否 企业自定义的state参数，用于区分不同的入群渠道。不超过30个UTF-8字符
	 * 如果有设置此参数，在调用获取客户群详情接口时会返回每个群成员对应的该参数值，详见文末附录2
	 *
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
	public function update(\Qyweixin\Model\ExternalContact\GroupChat\JoinWay $joinWay)
	{
		$params = $joinWay->getParams();
		$rst = $this->_request->post($this->_url . 'update_join_way', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 删除客户群进群方式配置
	 * 删除一个进群方式配置。
	 *
	 * 请求方式：POST（HTTPS）
	 * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/externalcontact/groupchat/del_join_way?access_token=ACCESS_TOKEN
	 *
	 * 请求示例：
	 *
	 * {
	 * "config_id":"42b34949e138eb6e027c123cba77faaa"
	 * }
	 * 参数说明：
	 *
	 * 参数 必须 说明
	 * access_token 是 调用接口凭证
	 * config_id 是 企业联系方式的配置id
	 *
	 *
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
		$rst = $this->_request->post($this->_url . 'del_join_way', $params);
		return $this->_client->rst($rst);
	}
}
