<?php

namespace Qyweixin\Manager\ExternalContact;

use Qyweixin\Client;

/**
 * 企业的全部群发记录
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class GroupMsg
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
	 * 获取群发记录列表
	 * 企业和第三方应用可通过此接口获取企业与成员的群发记录。
	 *
	 * 请求方式：POST(HTTPS)
	 * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/externalcontact/get_groupmsg_list?access_token=ACCESS_TOKEN
	 *
	 * 请求示例：
	 *
	 * {
	 * "chat_type":"single",
	 * "start_time":1605171726,
	 * "end_time":1605172726,
	 * "creator":"zhangshan",
	 * "filter_type":1,
	 * "limit":50,
	 * "cursor":"CURSOR"
	 * }
	 * 参数说明：
	 *
	 * 参数 必须 说明
	 * access_token 是 调用接口凭证
	 * chat_type 是 群发任务的类型，默认为single，表示发送给客户，group表示发送给客户群
	 * start_time 是 群发任务记录开始时间
	 * end_time 是 群发任务记录结束时间
	 * creator 否 群发任务创建人企业账号id
	 * filter_type 否 创建人类型。0：企业发表 1：个人发表 2：所有，包括个人创建以及企业创建，默认情况下为所有类型
	 * limit 否 返回的最大记录数，整型，最大值100，默认值50，超过最大值时取默认值
	 * cursor 否 用于分页查询的游标，字符串类型，由上一次调用返回，首次调用可不填
	 * 补充说明:
	 *
	 * 群发任务记录的起止时间间隔不能超过1个月
	 *
	 * 权限说明：
	 *
	 * 企业需要使用“客户联系”secret或配置到“可调用应用”列表中的自建应用secret所获取的accesstoken来调用（accesstoken如何获取？）。
	 * 自建应用调用，只会返回应用可见范围内用户的发送情况。
	 * 第三方应用调用需要企业授权客户联系下群发消息给客户和客户群的权限
	 * 返回结果：
	 *
	 * {
	 * "errcode":0,
	 * "errmsg":"ok",
	 * "next_cursor":"CURSOR",
	 * "group_msg_list":[
	 * {
	 * "msgid":"msgGCAAAXtWyujaWJHDDGi0mAAAA",
	 * "creator":"xxxx",
	 * "create_time":"xxxx",
	 * "create_type":1,
	 * "text": {
	 * "content":"文本消息内容"
	 * },
	 * "image": {
	 * "media_id":"WWCISP_XXXXXXX"
	 * },
	 * "link": {
	 * "title": "消息标题",
	 * "picurl": "https://example.pic.com/path",
	 * "desc": "消息描述",
	 * "url": "https://example.link.com/path"
	 * },
	 * "miniprogram": {
	 * "title": "消息标题",
	 * "appid": "wx8bd80126147dfAAA",
	 * "page": "/path/index.html"
	 * },
	 * "video":{
	 * "media_id":"WWCISP_XXXXXXX"
	 * }
	 * }
	 * ]
	 * }
	 * 参数说明：
	 *
	 * 参数 说明
	 * errcode 返回码
	 * errmsg 对返回码的文本描述内容
	 * next_cursor 分页游标，再下次请求时填写以获取之后分页的记录，如果已经没有更多的数据则返回空
	 * group_msg_list 群发记录列表
	 * group_msg_list.msgid 企业群发消息的id，可用于获取企业群发成员执行结果
	 * group_msg_list.creator 群发消息创建者userid，API接口创建的群发消息不吐出该字段
	 * group_msg_list.create_time 创建时间
	 * group_msg_list.create_type 群发消息创建来源。0：企业 1：个人
	 * group_msg_list.text.content 消息文本内容，最多4000个字节
	 * group_msg_list.image.media_id 图片的media_id，可以通过获取临时素材下载资源
	 * group_msg_list.image.pic_url 图片的url，与图片的media_id不能共存优先吐出media_id
	 * group_msg_list.link.title 图文消息标题
	 * group_msg_list.link.picurl 图文消息封面的url
	 * group_msg_list.link.desc 图文消息的描述，最多512个字节
	 * group_msg_list.link.url 图文消息的链接
	 * group_msg_list.miniprogram.title 小程序消息标题，最多64个字节
	 * group_msg_list.miniprogram.appid 小程序appid，必须是关联到企业的小程序应用
	 * group_msg_list.miniprogram.page 小程序page路径
	 * group_msg_list.video.media_id 视频的media_id，可以通过获取临时素材下载资源
	 */
	public function getGroupmsgList($chat_type, $start_time, $end_time, $creator = "", $filter_type = 2, $limit = 100, $cursor = "")
	{
		$params = array();
		$params['chat_type'] = $chat_type;
		$params['start_time'] = $start_time;
		$params['end_time'] = $end_time;
		if (!empty($creator)) {
			$params['creator'] = $creator;
		}
		$params['filter_type'] = $filter_type;
		$params['limit'] = $limit;
		if (!empty($cursor)) {
			$params['cursor'] = $cursor;
		}
		$rst = $this->_request->post($this->_url . 'get_groupmsg_list', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 获取群发记录列表
	 * 企业和第三方应用可通过此接口获取企业与成员的群发记录。
	 *
	 * 请求方式：POST(HTTPS)
	 * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/externalcontact/get_groupmsg_list_v2?access_token=ACCESS_TOKEN
	 *
	 * 请求示例：
	 *
	 * {
	 * "chat_type":"single",
	 * "start_time":1605171726,
	 * "end_time":1605172726,
	 * "creator":"zhangshan",
	 * "filter_type":1,
	 * "limit":50,
	 * "cursor":"CURSOR"
	 * }
	 * 参数说明：
	 *
	 * 参数 必须 说明
	 * access_token 是 调用接口凭证
	 * chat_type 是 群发任务的类型，默认为single，表示发送给客户，group表示发送给客户群
	 * start_time 是 群发任务记录开始时间
	 * end_time 是 群发任务记录结束时间
	 * creator 否 群发任务创建人企业账号id
	 * filter_type 否 创建人类型。0：企业发表 1：个人发表 2：所有，包括个人创建以及企业创建，默认情况下为所有类型
	 * limit 否 返回的最大记录数，整型，最大值100，默认值50，超过最大值时取默认值
	 * cursor 否 用于分页查询的游标，字符串类型，由上一次调用返回，首次调用可不填
	 * 补充说明:
	 *
	 * 群发任务记录的起止时间间隔不能超过1个月
	 * 3.1.6版本之前不支持多附件，请参考获取群发记录列表接口获取群发记录列表
	 * 权限说明：
	 *
	 * 企业需要使用“客户联系”secret或配置到“可调用应用”列表中的自建应用secret所获取的accesstoken来调用（accesstoken如何获取？）。
	 * 自建应用调用，只会返回应用可见范围内用户的发送情况。
	 * 第三方应用调用需要企业授权客户联系下群发消息给客户和客户群的权限
	 * 返回结果：
	 *
	 * {
	 * "errcode":0,
	 * "errmsg":"ok",
	 * "next_cursor":"CURSOR",
	 * "group_msg_list":[
	 * {
	 * "msgid":"msgGCAAAXtWyujaWJHDDGi0mAAAA",
	 * "creator":"xxxx",
	 * "create_time":"xxxx",
	 * "create_type":1,
	 * "text": {
	 * "content":"文本消息内容"
	 * },
	 * "attachments": [
	 * {
	 * "msgtype": "image",
	 * "image": {
	 * "media_id": "MEDIA_ID",
	 * "pic_url": "http://p.qpic.cn/pic_wework/3474110808/7a6344sdadfwehe42060/0"
	 * }
	 * },
	 * {
	 * "msgtype": "link",
	 * "link": {
	 * "title": "消息标题",
	 * "picurl": "https://example.pic.com/path",
	 * "desc": "消息描述",
	 * "url": "https://example.link.com/path"
	 * }
	 * },
	 * {
	 * "msgtype": "miniprogram",
	 * "miniprogram": {
	 * "title": "消息标题",
	 * "pic_media_id": "MEDIA_ID",
	 * "appid": "wx8bd80126147dfAAA",
	 * "page": "/path/index.html"
	 * }
	 * },
	 * {
	 * "msgtype": "video",
	 * "video": {
	 * "media_id": "MEDIA_ID"
	 * }
	 * },
	 * {
	 * "msgtype": "file",
	 * "file": {
	 * "media_id": "MEDIA_ID"
	 * }
	 * }
	 * ]
	 * }
	 * ]
	 * }
	 * 参数说明：
	 *
	 * 参数 说明
	 * errcode 返回码
	 * errmsg 对返回码的文本描述内容
	 * next_cursor 分页游标，再下次请求时填写以获取之后分页的记录，如果已经没有更多的数据则返回空
	 * group_msg_list 群发记录列表
	 * group_msg_list.msgid 企业群发消息的id，可用于获取企业群发成员执行结果
	 * group_msg_list.creator 群发消息创建者userid，API接口创建的群发消息不返回该字段
	 * group_msg_list.create_time 创建时间
	 * group_msg_list.create_type 群发消息创建来源。0：企业 1：个人
	 * group_msg_list.text.content 消息文本内容，最多4000个字节
	 * group_msg_list.attachments.msgtype 值必须是image
	 * group_msg_list.attachments.image.media_id 图片的media_id，可以通过获取临时素材下载资源
	 * group_msg_list.attachments.image.pic_url 图片的url，与图片的media_id不能共存优先吐出media_id
	 * group_msg_list.attachments.msgtype 值必须是link
	 * group_msg_list.attachments.link.title 图文消息标题
	 * group_msg_list.attachments.link.picurl 图文消息封面的url
	 * group_msg_list.attachments.link.desc 图文消息的描述，最多512个字节
	 * group_msg_list.attachments.link.url 图文消息的链接
	 * group_msg_list.attachments.msgtype 值必须是miniprogram
	 * group_msg_list.attachments.miniprogram.title 小程序消息标题，最多64个字节
	 * group_msg_list.attachments.miniprogram.appid 小程序appid，必须是关联到企业的小程序应用
	 * group_msg_list.attachments.miniprogram.page 小程序page路径
	 * group_msg_list.attachments.msgtype 值必须是video
	 * group_msg_list.attachments.video.media_id 视频的media_id，可以通过获取临时素材下载资源
	 * group_msg_list.attachments.msgtype 值必须是file
	 * group_msg_list.attachments.file.media_id 文件的media_id，可以通过获取临时素材下载资源
	 */
	public function getGroupmsgListV2($chat_type, $start_time, $end_time, $creator = "", $filter_type = 2, $limit = 100, $cursor = "")
	{
		$params = array();
		$params['chat_type'] = $chat_type;
		$params['start_time'] = $start_time;
		$params['end_time'] = $end_time;
		if (!empty($creator)) {
			$params['creator'] = $creator;
		}
		$params['filter_type'] = $filter_type;
		$params['limit'] = $limit;
		if (!empty($cursor)) {
			$params['cursor'] = $cursor;
		}
		$rst = $this->_request->post($this->_url . 'get_groupmsg_list_v2', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 获取群发成员发送任务列表
	 * 请求方式:POST(HTTPS)
	 * 请求地址:https://qyapi.weixin.qq.com/cgi-bin/externalcontact/get_groupmsg_task?access_token=ACCESS_TOKEN
	 *
	 * 请求示例
	 *
	 * {
	 * "msgid": "msgGCAAAXtWyujaWJHDDGi0mACAAAA",
	 * "limit":50,
	 * "cursor":"CURSOR "
	 * }
	 * 参数说明:
	 *
	 * 参数 必须 说明
	 * access_token 是 调用接口凭证
	 * msgid 是 群发消息的id，通过获取群发记录列表接口返回
	 * limit 否 返回的最大记录数，整型，最大值1000，默认值500，超过最大值时取默认值
	 * cursor 否 用于分页查询的游标，字符串类型，由上一次调用返回，首次调用可不填
	 * 权限说明:
	 *
	 * 企业需要使用“客户联系”secret或配置到“可调用应用”列表中的自建应用secret所获取的accesstoken来调用（accesstoken如何获取？）。
	 * 自建应用调用，只会返回应用可见范围内用户的发送情况。
	 * 第三方应用调用需要企业授权客户联系下群发消息给客户和客户群的权限
	 * 返回结果:
	 *
	 * {
	 * "errcode": 0,
	 * "errmsg": "ok",
	 * "next_cursor":"CURSOR",
	 * "task_list": [
	 * {
	 * "userid": "zhangsan",
	 * "status": 1,
	 * "send_time": 1552536375
	 * }
	 * ]
	 * }
	 * 参数说明:
	 *
	 * 参数 说明
	 * errcode 返回码
	 * errmsg 对返回码的文本描述内容
	 * next_cursor 分页游标，再下次请求时填写以获取之后分页的记录，如果已经没有更多的数据则返回空
	 * task_list 群发成员发送任务列表
	 * task_list.userid 企业服务人员的userid
	 * task_list.status 发送状态 0-未发送 1-已确认 2-已发送
	 * task_list.send_time 发送时间，未发送时不返回
	 * 2020-11-17日之前创建的消息无发送任务列表，请通过获取企业群发成员执行结果接口获取群发结果
	 */
	public function getGroupmsgTask($msgid, $limit = 1000, $cursor = "")
	{
		$params = array();
		$params['msgid'] = $msgid;
		$params['limit'] = $limit;
		if (!empty($cursor)) {
			$params['cursor'] = $cursor;
		}
		$rst = $this->_request->post($this->_url . 'get_groupmsg_task', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 获取企业群发成员执行结果
	 * 请求方式:POST(HTTPS)
	 *
	 * 请求地址:https://qyapi.weixin.qq.com/cgi-bin/externalcontact/get_groupmsg_send_result?access_token=ACCESS_TOKEN
	 *
	 * 请求示例
	 *
	 * {
	 * "msgid": "msgGCAAAXtWyujaWJHDDGi0mACAAAA",
	 * "userid":"zhangsan ",
	 * "limit":50,
	 * "cursor":"CURSOR "
	 * }
	 * 参数说明:
	 *
	 * 参数 必须 说明
	 * access_token 是 调用接口凭证
	 * msgid 是 群发消息的id，通过获取群发记录列表接口返回
	 * userid 是 发送成员userid，通过获取群发成员发送任务列表接口返回
	 * limit 否 返回的最大记录数，整型，最大值1000，默认值500，超过最大值时取默认值
	 * cursor 否 用于分页查询的游标，字符串类型，由上一次调用返回，首次调用可不填
	 * 权限说明:
	 *
	 * 企业需要使用“客户联系”secret或配置到“可调用应用”列表中的自建应用secret所获取的accesstoken来调用（accesstoken如何获取？）。
	 * 自建应用调用，只会返回应用可见范围内用户的发送情况。
	 * 第三方应用调用需要企业授权客户联系下群发消息给客户和客户群的权限
	 * 返回结果:
	 *
	 * {
	 * "errcode": 0,
	 * "errmsg": "ok",
	 * "next_cursor":"CURSOR",
	 * "send_list": [
	 * {
	 * "external_userid": "wmqfasd1e19278asdasAAAA",
	 * "chat_id":"wrOgQhDgAAMYQiS5ol9G7gK9JVAAAA",
	 * "userid": "zhangsan",
	 * "status": 1,
	 * "send_time": 1552536375
	 * }
	 * ]
	 * }
	 * 参数说明:
	 *
	 * 参数 说明
	 * errcode 返回码
	 * errmsg 对返回码的文本描述内容
	 * next_cursor 分页游标，再下次请求时填写以获取之后分页的记录，如果已经没有更多的数据则返回空
	 * send_list 群成员发送结果列表
	 * send_list.external_userid 外部联系人userid，群发消息到企业的客户群不吐出该字段
	 * send_list.chat_id 外部客户群id，群发消息到客户不吐出该字段
	 * send_list.userid 企业服务人员的userid
	 * send_list.status 发送状态 0-未发送 1-已发送 2-因客户不是好友导致发送失败 3-因客户已经收到其他群发消息导致发送失败
	 * send_list.send_time 发送时间，发送状态为1时返回
	 * 若为客户群群发，由于用户还未选择群，所以不返回未发送记录，只返回已发送记录
	 * 2020-11-17日之前创建的消息请通过获取企业群发成员执行结果接口获取群发结果
	 */
	public function getGroupmsgSendResult($msgid, $userid, $limit = 1000, $cursor = "")
	{
		$params = array();
		$params['msgid'] = $msgid;
		$params['userid'] = $userid;
		$params['limit'] = $limit;
		if (!empty($cursor)) {
			$params['cursor'] = $cursor;
		}
		$rst = $this->_request->post($this->_url . 'get_groupmsg_send_result', $params);
		return $this->_client->rst($rst);
	}
}
