<?php

namespace Qyweixin\Manager\ExternalContact;

use Qyweixin\Client;
use Qyweixin\Manager\ExternalContact\GroupChat\JoinWay;

/**
 * 客户群列消息发送
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class GroupChat
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
	 * 获取客户群「加入群聊」管理对象
	 *
	 * @return \Qyweixin\Manager\ExternalContact\GroupChat\JoinWay
	 */
	public function getJoinWayManager()
	{
		return new JoinWay($this->_client);
	}

	/**
	 * 获取客户群列表
	 * 该接口用于获取配置过客户群管理的客户群列表。
	 *
	 * 请求方式：POST（HTTPS）
	 * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/externalcontact/groupchat/list?access_token=ACCESS_TOKEN
	 *
	 * {
	 * "status_filter": 0,
	 * "owner_filter": {
	 * "userid_list": ["abel"]
	 * },
	 * "cursor" : "r9FqSqsI8fgNbHLHE5QoCP50UIg2cFQbfma3l2QsmwI",
	 * "limit" : 10
	 * }
	 * 参数说明：
	 *
	 * 参数 必须 说明
	 * access_token 是 调用接口凭证
	 * status_filter 否 客户群跟进状态过滤。
	 * 0 - 所有列表(即不过滤)
	 * 1 - 离职待继承
	 * 2 - 离职继承中
	 * 3 - 离职继承完成
	 *
	 * 默认为0
	 * owner_filter 否 群主过滤。
	 * 如果不填，表示获取应用可见范围内全部群主的数据（但是不建议这么用，如果可见范围人数超过1000人，为了防止数据包过大，会报错 81017）
	 * owner_filter.userid_list 否 用户ID列表。最多100个
	 * cursor 否 用于分页查询的游标，字符串类型，由上一次调用返回，首次调用不填
	 * limit 是 分页，预期请求的数据量，取值范围 1 ~ 1000
	 * 如果不指定 owner_filter，会拉取应用可见范围内的所有群主的数据，但是不建议这样使用。如果可见范围内人数超过1000人，为了防止数据包过大，会报错 81017。此时，调用方需通过指定 owner_filter 来缩小拉取范围
	 * 旧版接口以offset+limit分页，要求offset+limit不能超过50000，该方案将废弃，请改用cursor+limit分页
	 * 权限说明:
	 *
	 * 企业需要使用“客户联系”secret或配置到“可调用应用”列表中的自建应用secret所获取的accesstoken来调用（accesstoken如何获取？）。
	 * 第三方应用需具有“企业客户权限->客户基础信息”权限
	 * 对于第三方/自建应用，群主必须在应用的可见范围。
	 *
	 *
	 * 返回结果：
	 *
	 * {
	 * "errcode": 0,
	 * "errmsg": "ok",
	 * "group_chat_list": [{
	 * "chat_id": "wrOgQhDgAAMYQiS5ol9G7gK9JVAAAA",
	 * "status": 0
	 * }, {
	 * "chat_id": "wrOgQhDgAAcwMTB7YmDkbeBsAAAA",
	 * "status": 0
	 * }],
	 * "next_cursor":"tJzlB9tdqfh-g7i_J-ehOz_TWcd7dSKa39_AqCIeMFw"
	 * }
	 * 参数说明：
	 *
	 * 参数 说明
	 * errcode 返回码
	 * errmsg 对返回码的文本描述内容
	 * group_chat_list 客户群列表
	 * group_chat_list.chat_id 客户群ID
	 * group_chat_list.status 客户群跟进状态。
	 * 0 - 跟进人正常
	 * 1 - 跟进人离职
	 * 2 - 离职继承中
	 * 3 - 离职继承完成
	 * next_cursor 分页游标，下次请求时填写以获取之后分页的记录。如果该字段返回空则表示已没有更多数据
	 */
	public function getGroupchatList($status_filter = 0, $owner_filter = array(), $cursor = "", $limit = 1000)
	{
		$params = array();
		$params['status_filter'] = $status_filter;
		if (!empty($owner_filter)) {
			$params['owner_filter'] = $owner_filter;
		}
		$params['cursor'] = $cursor;
		$params['limit'] = $limit;
		$rst = $this->_request->post($this->_url . 'list', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 获取客户群详情
	 * 通过客户群ID，获取详情。包括群名、群成员列表、群成员入群时间、入群方式。（客户群是由具有客户群使用权限的成员创建的外部群）
	 *
	 * 需注意的是，如果发生群信息变动，会立即收到群变更事件，但是部分信息是异步处理，可能需要等一段时间调此接口才能得到最新结果
	 *
	 * 请求方式：POST（HTTPS）
	 * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/externalcontact/groupchat/get?access_token=ACCESS_TOKEN
	 *
	 * 参数说明：
	 *
	 * {
	 * "chat_id":"wrOgQhDgAAMYQiS5ol9G7gK9JVAAAA",
	 * "need_name" : 1
	 * }
	 * 参数 必须 说明
	 * access_token 是 调用接口凭证
	 * chat_id 是 客户群ID
	 * need_name 否 是否需要返回群成员的名字group_chat.member_list.name。0-不返回；1-返回。默认不返回
	 *
	 *
	 * 权限说明:
	 *
	 * 企业需要使用“客户联系”secret或配置到“可调用应用”列表中的自建应用secret所获取的accesstoken来调用（accesstoken如何获取？）
	 * 第三方应用需具有“企业客户权限->客户基础信息”权限
	 * 对于第三方/自建应用，群主必须在应用的可见范围。
	 *
	 *
	 * 返回结果：
	 *
	 * {
	 * "errcode": 0,
	 * "errmsg": "ok",
	 * "group_chat": {
	 * "chat_id": "wrOgQhDgAAMYQiS5ol9G7gK9JVAAAA",
	 * "name": "销售客服群",
	 * "owner": "ZhuShengBen",
	 * "create_time": 1572505490,
	 * "notice": "文明沟通，拒绝脏话",
	 * "member_list": [{
	 * "userid": "abel",
	 * "type": 1,
	 * "join_time": 1572505491,
	 * "join_scene": 1,
	 * "invitor": {
	 * "userid": "jack"
	 * },
	 * "group_nickname" : "客服小张",
	 * "name" : "张三丰"
	 * }, {
	 * "userid": "wmOgQhDgAAuXFJGwbve4g4iXknfOAAAA",
	 * "type": 2,
	 * "unionid": "ozynqsulJFCZ2z1aYeS8h-nuasdAAA",
	 * "join_time": 1572505491,
	 * "join_scene": 1,
	 * "group_nickname" : "顾客老王",
	 * "name" : "王语嫣"
	 * }],
	 * "admin_list": [{
	 * "userid": "sam"
	 * }, {
	 * "userid": "pony"
	 * }]
	 * }
	 * }
	 * 参数说明：
	 *
	 * 参数 说明
	 * errcode 返回码
	 * errmsg 对返回码的文本描述内容
	 * group_chat 客户群详情
	 * group_chat.chat_id 客户群ID
	 * group_chat.name 群名
	 * group_chat.owner 群主ID
	 * group_chat.create_time 群的创建时间
	 * group_chat.notice 群公告
	 * group_chat.member_list 群成员列表
	 * group_chat.member_list.userid 群成员id
	 * group_chat.member_list.type 成员类型。
	 * 1 - 企业成员
	 * 2 - 外部联系人
	 * group_chat.member_list.unionid 外部联系人在微信开放平台的唯一身份标识（微信unionid），通过此字段企业可将外部联系人与公众号/小程序用户关联起来。仅当群成员类型是微信用户（包括企业成员未添加好友），且企业绑定了微信开发者ID有此字段（查看绑定方法）。第三方不可获取，上游企业不可获取下游企业客户的unionid字段
	 * group_chat.member_list.join_time 入群时间
	 * group_chat.member_list.join_scene 入群方式。
	 * 1 - 由群成员邀请入群（直接邀请入群）
	 * 2 - 由群成员邀请入群（通过邀请链接入群）
	 * 3 - 通过扫描群二维码入群
	 * group_chat.member_list.invitor 邀请者。目前仅当是由本企业内部成员邀请入群时会返回该值
	 * group_chat.member_list.invitor.userid 邀请者的userid
	 * group_chat.member_list.group_nickname 在群里的昵称
	 * group_chat.member_list.name 名字。仅当 need_name = 1 时返回
	 * 如果是微信用户，则返回其在微信中设置的名字
	 * 如果是企业微信联系人，则返回其设置对外展示的别名或实名
	 * group_chat.admin_list 群管理员列表
	 * group_chat.admin_list.userid 群管理员userid
	 */
	public function get($chat_id, $need_name = 0)
	{
		$params = array();
		$params['chat_id'] = $chat_id;
		$params['need_name'] = $need_name;
		$rst = $this->_request->post($this->_url . 'get', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 客户群opengid转换
	 * 用户在微信里的客户群里打开小程序时，某些场景下可以获取到群的opengid，如果该群是企业微信的客户群，则企业或第三方可以调用此接口将一个opengid转换为客户群chat_id
	 * 请求方式：POST（HTTPS）
	 * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/externalcontact/opengid_to_chatid?access_token=ACCESS_TOKEN
	 *
	 * 请求参数：
	 *
	 * {
	 * "opengid":"oAAAAAAA"
	 * }
	 * 参数说明：
	 *
	 * 参数 必须 说明
	 * access_token 是 调用接口凭证
	 * opengid 是 小程序在微信获取到的群ID，参见wx.getGroupEnterInfo
	 * 权限说明：
	 *
	 * 企业需要使用“客户联系”secret或配置到“可调用应用”列表中的自建应用secret所获取的accesstoken来调用（accesstoken如何获取？）
	 * 第三方应用需具有“企业客户权限->客户基础信息”权限
	 * 对于第三方/自建应用，群主必须在应用的可见范围
	 * 仅支持企业服务人员创建的客户群
	 * 仅可转换出自己企业下的客户群chat_id
	 * 返回结果：
	 *
	 * ｛
	 * "errcode":0,
	 * "errmsg":"ok",
	 * "chat_id":"ooAAAAAAAAAAA"
	 * ｝
	 * 参数说明：
	 *
	 * 参数 说明
	 * errcode 返回码
	 * errmsg 对返回码的文本描述内容
	 * chat_id 客户群ID，可以用来调用获取客户群详情
	 */
	public function opengidToChatid($opengid = 0)
	{
		$params = array();
		$params['opengid'] = $opengid;
		$rst = $this->_request->post('https://qyapi.weixin.qq.com/cgi-bin/externalcontact/opengid_to_chatid', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 调试工具
	 * 企业可通过此接口，将已离职成员为群主的群，分配给另一个客服成员。
	 *
	 * 请求方式：POST（HTTPS）
	 * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/externalcontact/groupchat/transfer?access_token=ACCESS_TOKEN
	 *
	 * {
	 * "chat_id_list" : ["wrOgQhDgAAcwMTB7YmDkbeBsgT_AAAA", "wrOgQhDgAAMYQiS5ol9G7gK9JVQUAAAA"],
	 * "new_owner" : "zhangsan"
	 * }
	 * 参数说明：
	 *
	 * 参数 必须 说明
	 * access_token 是 调用接口凭证
	 * chat_id_list 是 需要转群主的客户群ID列表。取值范围： 1 ~ 100
	 * new_owner 是 新群主ID
	 * 注意：：
	 *
	 * 群主离职了的客户群，才可继承
	 * 继承给的新群主，必须是配置了客户联系功能的成员
	 * 继承给的新群主，必须有设置实名
	 * 继承给的新群主，必须有激活企业微信
	 * 权限说明:
	 *
	 * 企业需要使用“客户联系”secret或配置到“可调用应用”列表中的自建应用secret所获取的accesstoken来调用（accesstoken如何获取？）。
	 * 暂不支持第三方调用。
	 * 返回结果：
	 *
	 * {
	 * "errcode": 0,
	 * "errmsg": "ok",
	 * "failed_chat_list": [
	 * {
	 * "chat_id": "wrOgQhDgAAcwMTB7YmDkbeBsgT_KAAAA",
	 * "errcode": 90500,
	 * "errmsg": "the owner of this chat is not resigned"
	 * }
	 * ]
	 * }
	 * 参数说明：
	 *
	 * 参数 说明
	 * errcode 返回码
	 * errmsg 对返回码的文本描述内容
	 * failed_chat_list 没能成功继承的群
	 * failed_chat_list.chat_id 没能成功继承的群ID
	 * failed_chat_list.errcode 没能成功继承的群，错误码
	 * failed_chat_list.errmsg 没能成功继承的群，错误描述
	 */
	public function transfer($chat_id_list, $new_owner)
	{
		$params = array();
		$params['chat_id_list'] = $chat_id_list;
		$params['new_owner'] = $new_owner;
		$rst = $this->_request->post($this->_url . 'transfer', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 分配在职成员的客户群
	 * 企业可通过此接口，将在职成员为群主的群，分配给另一个客服成员。
	 *
	 * 请求方式：POST（HTTPS）
	 * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/externalcontact/groupchat/onjob_transfer?access_token=ACCESS_TOKEN
	 *
	 * {
	 * "chat_id_list" : ["wrOgQhDgAAcwMTB7YmDkbeBsgT_AAAA", "wrOgQhDgAAMYQiS5ol9G7gK9JVQUAAAA"],
	 * "new_owner" : "zhangsan"
	 * }
	 * 参数说明：
	 *
	 * 参数 必须 说明
	 * access_token 是 调用接口凭证
	 * chat_id_list 是 需要转群主的客户群ID列表。取值范围： 1 ~ 100
	 * new_owner 是 新群主ID
	 * 注意：
	 *
	 * 继承给的新群主，必须是配置了客户联系功能的成员
	 * 继承给的新群主，必须有设置实名
	 * 继承给的新群主，必须有激活企业微信
	 * 同一个人的群，限制每天最多分配300个给新群主
	 * 为保障客户服务体验，90个自然日内，在职成员的每个客户群仅可被转接2次。
	 * 权限说明:
	 *
	 * 企业需要使用“客户联系”secret或配置到“可调用应用”列表中的自建应用secret所获取的accesstoken来调用（accesstoken如何获取？）。
	 * 第三方应用需拥有“企业客户权限->客户联系->分配在职成员的客户群”权限
	 * 对于第三方/自建应用，群主必须在应用的可见范围。
	 *
	 *
	 * 返回结果：
	 *
	 * {
	 * "errcode": 0,
	 * "errmsg": "ok",
	 * "failed_chat_list": [
	 * {
	 * "chat_id": "wrOgQhDgAAcwMTB7YmDkbeBsgT_KAAAA",
	 * "errcode": 90501,
	 * "errmsg": "chat is not external group chat"
	 * }
	 * ]
	 * }
	 * 参数说明：
	 *
	 * 参数 说明
	 * errcode 返回码
	 * errmsg 对返回码的文本描述内容
	 * failed_chat_list 没能成功继承的群
	 * failed_chat_list.chat_id 没能成功继承的群ID
	 * failed_chat_list.errcode 没能成功继承的群，错误码
	 * failed_chat_list.errmsg 没能成功继承的群，错误描述
	 */
	public function onjobTransfer($chat_id_list, $new_owner)
	{
		$params = array();
		$params['chat_id_list'] = $chat_id_list;
		$params['new_owner'] = $new_owner;
		$rst = $this->_request->post($this->_url . 'onjob_transfer', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 调试工具
	 * 获取指定日期全天的统计数据。注意，企业微信仅存储60天的数据。
	 *
	 * 请求方式：POST（HTTPS）
	 * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/externalcontact/groupchat/statistic?access_token=ACCESS_TOKEN
	 *
	 * {
	 * "day_begin_time": 1572505490,
	 * "owner_filter": {
	 * "userid_list": ["zhangsan"]
	 * },
	 * "order_by": 2,
	 * "order_asc": 0,
	 * "offset" : 0,
	 * "limit" : 1000
	 * }
	 * 参数说明：
	 *
	 * 参数 必须 说明
	 * access_token 是 调用接口凭证
	 * day_begin_time 是 开始时间，填当天开始的0分0秒（否则系统自动处理为当天的0分0秒）。取值范围：昨天至前60天
	 * day_end_time 否 结束日期的时间戳，填当天的0时0分0秒（否则系统自动处理为当天的0分0秒）。取值范围：昨天至前180天。如果不填，默认同 day_begin_time（即默认取一天的数据）
	 * owner_filter 是 群主过滤。如果不填，表示获取应用可见范围内全部群主的数据（但是不建议这么用，如果可见范围人数超过1000人，为了防止数据包过大，会报错 81017）
	 * owner_filter.userid_list 是 群主ID列表。最多100个
	 * order_by 否 排序方式。
	 * 1 - 新增群的数量
	 * 2 - 群总数
	 * 3 - 新增群人数
	 * 4 - 群总人数
	 *
	 * 默认为1
	 * order_asc 否 是否升序。0-否；1-是。默认降序
	 * offset 否 分页，偏移量, 默认为0
	 * limit 否 分页，预期请求的数据量，默认为500，取值范围 1 ~ 1000
	 * 权限说明:
	 *
	 * 企业需要使用“客户联系”secret或配置到“可调用应用”列表中的自建应用secret所获取的accesstoken来调用（accesstoken如何获取？）。
	 * 暂不支持第三方调用。
	 * 返回结果：
	 *
	 * {
	 * "errcode": 0,
	 * "errmsg": "ok",
	 * "total": 1,
	 * "next_offset": 1,
	 * "items": [{
	 * "owner": "zhangsan",
	 * "data": {
	 * "new_chat_cnt": 2,
	 * "chat_total": 2,
	 * "chat_has_msg": 0,
	 * "new_member_cnt": 0,
	 * "member_total": 6,
	 * "member_has_msg": 0,
	 * "msg_total": 0
	 * }
	 * }]
	 * }
	 * 参数说明：
	 *
	 * 参数 说明
	 * errcode 返回码
	 * errmsg 对返回码的文本描述内容
	 * total 命中过滤条件的记录总个数
	 * next_offset 当前分页的下一个offset。当next_offset和total相等时，说明已经取完所有
	 * items 记录列表。表示某个群主所拥有的客户群的统计数据
	 * owner 群主ID
	 * data 详情
	 * new_chat_cnt 新增客户群数量
	 * chat_total 截至当天客户群总数量
	 * chat_has_msg 截至当天有发过消息的客户群数量
	 * new_member_cnt 客户群新增群人数。
	 * member_total 截至当天客户群总人数
	 * member_has_msg 截至当天有发过消息的群成员数
	 * msg_total 截至当天客户群消息总数
	 */
	public function statistic($day_begin_time, $day_end_time, $owner_filter, $order_by, $order_asc = 0, $offset = 0, $limit = 1000)
	{
		$params = array();
		$params['day_begin_time'] = $day_begin_time;
		$params['day_end_time'] = $day_end_time;
		$params['owner_filter'] = $owner_filter;
		$params['order_by'] = $order_by;
		$params['order_asc'] = $order_asc;
		$params['offset'] = $offset;
		$params['limit'] = $limit;
		$rst = $this->_request->post($this->_url . 'statistic', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 按自然日聚合的方式
	 *
	 * 请求方式：POST（HTTPS）
	 * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/externalcontact/groupchat/statistic_group_by_day?access_token=ACCESS_TOKEN
	 *
	 * {
	 * "day_begin_time": 1600272000,
	 * "day_end_time": 1600358400,
	 * "owner_filter": {
	 * "userid_list": ["zhangsan"]
	 * }
	 * }
	 *
	 * 参数说明：
	 * 参数 必须 说明
	 * access_token 是 调用接口凭证
	 * day_begin_time 是 起始日期的时间戳，填当天的0时0分0秒（否则系统自动处理为当天的0分0秒）。取值范围：昨天至前180天。
	 * day_end_time 否 结束日期的时间戳，填当天的0时0分0秒（否则系统自动处理为当天的0分0秒）。取值范围：昨天至前180天。
	 * 如果不填，默认同 day_begin_time（即默认取一天的数据）
	 * owner_filter 是 群主过滤。
	 * 如果不填，表示获取应用可见范围内全部群主的数据（但是不建议这么用，如果可见范围人数超过1000人，为了防止数据包过大，会报错 81017）
	 * owner_filter.userid_list 是 群主ID列表。最多100个
	 *
	 * 此接口查询的时间范围为 [day_begin_time, day_end_time]，前后均为闭区间（即包含day_end_time当天的数据），支持的最大查询跨度为30天；
	 * 用户最多可获取最近180天内的数据（超过180天企业微信将不再存储）；
	 * 当传入的时间不为0点时，会向下取整，如传入1554296400(Wed Apr 3 21:00:00 CST 2019)会被自动转换为1554220800（Wed Apr 3 00:00:00 CST 2019）;
	 *
	 * 权限说明:
	 *
	 * 企业需要使用“客户联系”secret或配置到“可调用应用”列表中的自建应用secret所获取的accesstoken来调用（accesstoken如何获取？）。
	 * 第三方应用使用，需具有“企业客户权限->客户群->获取客户群的数据统计”权限。
	 * 对于第三方/自建应用，群主必须在应用的可见范围。
	 *
	 *
	 *
	 * 返回结果：
	 *
	 * {
	 * "errcode": 0,
	 * "errmsg": "ok",
	 * "items": [{
	 * "stat_time": 1600272000,
	 * "data": {
	 * "new_chat_cnt": 2,
	 * "chat_total": 2,
	 * "chat_has_msg": 0,
	 * "new_member_cnt": 0,
	 * "member_total": 6,
	 * "member_has_msg": 0,
	 * "msg_total": 0,
	 * "migrate_trainee_chat_cnt": 3
	 * }
	 * },
	 * {
	 * "stat_time": 1600358400,
	 * "data": {
	 * "new_chat_cnt": 2,
	 * "chat_total": 2,
	 * "chat_has_msg": 0,
	 * "new_member_cnt": 0,
	 * "member_total": 6,
	 * "member_has_msg": 0,
	 * "msg_total": 0,
	 * "migrate_trainee_chat_cnt": 3
	 * }
	 * }
	 * ]
	 * }
	 *
	 * 参数说明：
	 * 参数 说明
	 * errcode 返回码
	 * errmsg 对返回码的文本描述内容
	 * items 记录列表。表示某个自然日客户群的统计数据
	 * items.stat_time 数据日期，为当日0点的时间戳
	 * items.data 详情
	 * items.data.new_chat_cnt 新增客户群数量
	 * items.data.chat_total 截至当天客户群总数量
	 * items.data.chat_has_msg 截至当天有发过消息的客户群数量
	 * items.data.new_member_cnt 客户群新增群人数。
	 * items.data.member_total 截至当天客户群总人数
	 * items.data.member_has_msg 截至当天有发过消息的群成员数
	 * items.data.msg_total 截至当天客户群消息总数
	 * items.data.migrate_trainee_chat_cnt 截至当天新增迁移群数(仅教培行业返回)
	 */
	public function statisticGroupByDay($day_begin_time, $day_end_time, $owner_filter)
	{
		$params = array();
		$params['day_begin_time'] = $day_begin_time;
		$params['day_end_time'] = $day_end_time;
		$params['owner_filter'] = $owner_filter;
		$rst = $this->_request->post($this->_url . 'statistic_group_by_day', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 转换客户群成员external_userid
	 * 转换客户external_userid接口不支持客户群的场景，如果需要转换客户群中无好友关系的群成员external_userid，需要调用本接口，调用时需要传入客户群的chat_id。
	 *
	 * 请求方式：POST（HTTPS）
	 * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/externalcontact/groupchat/get_new_external_userid?access_token=ACCESS_TOKEN
	 *
	 * 请求参数：
	 *
	 * {
	 * "chat_id":"wrOgQhDgAAMYQiS5ol9G7gK9JVAAAA",
	 * "external_userid_list":["xxxxx","yyyyyy"]
	 * }
	 * 参数说明：
	 *
	 * 参数 必须 说明
	 * access_token 是 代开发自建应用或第三方应用的接口凭证，服务商可通过“获取企业access_token”获得此调用凭证
	 * chat_id 是 客户群ID
	 * external_userid_list 是 企业主体下的external_userid列表，建议200个，最多不超过1000个
	 * 权限说明：
	 *
	 * 仅代开发自建应用或第三方应用可调用
	 * 客户群的群主需要在应用可见范围内
	 * 返回结果：
	 *
	 * ｛
	 * "errcode":0,
	 * "errmsg":"ok",
	 * "items":[
	 * {
	 * "external_userid":"xxxxx",
	 * "new_external_userid":"AAAA"
	 * },
	 * {
	 * "external_userid":"yyyyy",
	 * "new_external_userid":"BBBB"
	 * }
	 * ]
	 * ｝
	 * 如果传入了新的external_userid，则原样返回。
	 * 参数说明：
	 *
	 * 参数 说明
	 * errcode 返回码
	 * errmsg 对返回码的文本描述内容
	 * new_external_userid 服务商主体下的external_userid
	 */
	public function getNewExternalUserid($chat_id, $external_userid_list)
	{
		$params = array();
		$params['chat_id'] = $chat_id;
		$params['external_userid_list'] = $external_userid_list;
		$rst = $this->_request->post($this->_url . 'get_new_external_userid', $params);
		return $this->_client->rst($rst);
	}
}
