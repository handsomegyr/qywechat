<?php

namespace Qyweixin\Manager\ExternalContact;

use Qyweixin\Client;

/**
 * 获客助手
 * https://developer.work.weixin.qq.com/document/path/97297
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class CustomerAcquisition
{

	// 接口地址
	private $_url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/customer_acquisition/';
	private $_client;
	private $_request;
	public function __construct(Client $client)
	{
		$this->_client = $client;
		$this->_request = $client->getRequest();
	}

	/**
	 * 获客链接管理
	 * 最后更新：2023/03/28
	 * 获取获客链接列表
	 * 企业可通过此接口获取当前仍然有效的获客链接。
	 *
	 * 请求方式: POST(HTTP)
	 *
	 * 请求地址:https://qyapi.weixin.qq.com/cgi-bin/externalcontact/customer_acquisition/list_link?access_token=ACCESS_TOKEN
	 *
	 * 请求示例
	 *
	 * {
	 * "limit":100,
	 * "cursor":"CURSOR"
	 * }
	 * 参数说明:
	 *
	 * 参数 必须 说明
	 * access_token 是 调用接口凭证
	 * limit 否 返回的最大记录数，整型，最大值100
	 * cursor 否 用于分页查询的游标，字符串类型，由上一次调用返回，首次调用可不填
	 *
	 *
	 * 权限说明:
	 *
	 * 企业需要使用配置到“可调用应用”列表中的自建应用secret所获取的accesstoken来调用（accesstoken如何获取？）。
	 * 第三方应用需具有“企业客户权限->获客助手”权限
	 * 不支持客户联系系统应用调用
	 *
	 *
	 * 返回结果:
	 *
	 * {
	 * "errcode": 0,
	 * "errmsg": "ok",
	 * "link_id_list":
	 * [
	 * "LINK_ID_AAA",
	 * "LINK_ID_BBB",
	 * "LINK_ID_CCC"
	 * ],
	 * "next_cursor":"CURSOR"
	 * }
	 * 参数说明:
	 *
	 * 参数 说明
	 * errcode 返回码
	 * errmsg 对返回码的文本描述内容
	 * link_id_list link_id列表
	 * next_cursor 分页游标，在下次请求时填写以获取之后分页的记录
	 */
	public function listLink($cursor = "", $limit = 100)
	{
		$params = array();
		$params['cursor'] = $cursor;
		$params['limit'] = $limit;
		$rst = $this->_request->post($this->_url . 'list_link', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 获取获客链接详情
	 * 企业可通过此接口根据获客链接id获取链接配置详情。
	 *
	 * 请求方式: POST(HTTP)
	 *
	 * 请求地址:https://qyapi.weixin.qq.com/cgi-bin/externalcontact/customer_acquisition/get?access_token=ACCESS_TOKEN
	 *
	 * 请求示例
	 *
	 * {
	 * "link_id":"LINK_ID_AAA"
	 * }
	 * 参数说明:
	 *
	 * 参数 必须 说明
	 * access_token 是 调用接口凭证
	 * link_id 是 获客链接id
	 *
	 *
	 * 权限说明:
	 *
	 * 企业需要使用配置到“可调用应用”列表中的自建应用secret所获取的accesstoken来调用（accesstoken如何获取？）。
	 * 第三方应用需具有“企业客户权限->获客助手”权限
	 * 不支持客户联系系统应用调用
	 *
	 *
	 * 返回结果:
	 *
	 * {
	 * "errcode": 0,
	 * "errmsg": "ok",
	 * "link":
	 * {
	 * "link_id":"LINK_ID_AAA",
	 * "link_name":"LINK_NAME",
	 * "url":"work.weixin.qq.com/ca/xxxxxx",
	 * "create_time":1672502400
	 * },
	 * "range":
	 * {
	 * "user_list":["rocky","sam"],
	 * "department_list":[1]
	 * }
	 *
	 * }
	 * 参数说明:
	 *
	 * 参数 说明
	 * errcode 返回码
	 * errmsg 对返回码的文本描述内容
	 * link.link_id 获客链接的id
	 * link.link_name 获客链接的名称
	 * link.url 获客链接实际的url
	 * link.create_time 创建时间
	 * range.user_list 该获客链接使用范围成员列表
	 * range.department_list 该获客链接使用范围的部门列表
	 */
	public function getInfo($link_id)
	{
		$params = array();
		$params['link_id'] = $link_id;
		$rst = $this->_request->post($this->_url . 'get', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 创建获客链接
	 * 企业可通过此接口创建新的获客链接。
	 *
	 * 请求方式: POST(HTTP)
	 *
	 * 请求地址:https://qyapi.weixin.qq.com/cgi-bin/externalcontact/customer_acquisition/create_link?access_token=ACCESS_TOKEN
	 *
	 * 请求示例
	 *
	 * {
	 * "link_name":"获客链接1号",
	 * "range":
	 * {
	 * "user_list":["zhangsan","lisi"],
	 * "department_list":[2,3]
	 * }
	 * }
	 * 参数说明:
	 *
	 * 参数 必须 说明
	 * access_token 是 调用接口凭证
	 * link_name 是 链接名称
	 * range.user_list 否 此获客链接关联的userid列表，最多可关联100个
	 * range.department_list 否 此获客链接关联的部门id列表，部门覆盖总人数最多100个
	 * range.user_list和range.department_list不可同时为空
	 *
	 *
	 * 权限说明:
	 *
	 * 企业需要使用配置到“可调用应用”列表中的自建应用secret所获取的accesstoken来调用（accesstoken如何获取？）。
	 * 第三方应用需具有“企业客户权限->获客助手”权限
	 * 不支持客户联系系统应用调用
	 *
	 *
	 * 返回结果:
	 *
	 * {
	 * "errcode": 0,
	 * "errmsg": "ok",
	 * "link":{
	 * "link_id":"LINK_ID",
	 * "link_name":"获客链接1号",
	 * "url":"URL",
	 * "create_time":1667232000
	 * }
	 * }
	 * 参数说明:
	 *
	 * 参数 说明
	 * errcode 返回码
	 * errmsg 对返回码的文本描述内容
	 * link.link_id 获客链接的id
	 * link.link_name 获客链接名称
	 * link.url 获客链接
	 * create_time 获客链接创建时间
	 */
	public function createLink(\Qyweixin\Model\ExternalContact\CustomerAcquisitionLink $customerAcquisitionLink)
	{
		$params = $customerAcquisitionLink->getParams();
		$rst = $this->_request->post($this->_url . 'create_link', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 编辑获客链接
	 * 企业可通过此接口编辑获客链接，修改获客链接的关联范围或修改获客链接的名称。
	 *
	 * 请求方式: POST(HTTP)
	 *
	 * 请求地址:https://qyapi.weixin.qq.com/cgi-bin/externalcontact/customer_acquisition/update_link?access_token=ACCESS_TOKEN
	 *
	 * 请求示例
	 *
	 * {
	 * "link_id":"LINK_ID",
	 * "link_name":"获客链接1号",
	 * "range":
	 * {
	 * "user_list":["zhangsan","lisi"],
	 * "department_list":[2,3]
	 * }
	 * }
	 * 参数说明:
	 *
	 * 参数 必须 说明
	 * access_token 是 调用接口凭证
	 * link_id 是 获客链接的id
	 * link_name 否 更新的链接名称
	 * range.user_list 否 此获客链接关联的userid列表，最多可关联100个
	 * range.department_list 否 此获客链接关联的部门id列表，部门覆盖总人数最多100个
	 * range为覆盖更新。
	 *
	 *
	 * 权限说明:
	 *
	 * 企业需要使用配置到“可调用应用”列表中的自建应用secret所获取的accesstoken来调用（accesstoken如何获取？）。
	 * 第三方应用需具有“企业客户权限->获客助手”权限
	 * 不支持客户联系系统应用调用
	 *
	 *
	 * 返回结果:
	 *
	 * {
	 * "errcode": 0,
	 * "errmsg": "ok"
	 * }
	 * 参数说明:
	 *
	 * 参数 说明
	 * errcode 返回码
	 * errmsg 对返回码的文本描述内容
	 */
	public function updateLink(\Qyweixin\Model\ExternalContact\CustomerAcquisitionLink $customerAcquisitionLink)
	{
		$params = $customerAcquisitionLink->getParams();
		$rst = $this->_request->post($this->_url . 'update_link', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 删除获客链接
	 * 企业可通过此接口删除获客链接，删除后的获客链接将无法继续使用。
	 *
	 * 请求方式: POST(HTTP)
	 *
	 * 请求地址:https://qyapi.weixin.qq.com/cgi-bin/externalcontact/customer_acquisition/delete_link?access_token=ACCESS_TOKEN
	 *
	 * 请求示例
	 *
	 * {
	 * "link_id":"LINK_ID"
	 * }
	 * 参数说明:
	 *
	 * 参数 必须 说明
	 * access_token 是 调用接口凭证
	 * link_id 是 获客链接的id
	 *
	 *
	 * 权限说明:
	 *
	 * 企业需要使用配置到“可调用应用”列表中的自建应用secret所获取的accesstoken来调用（accesstoken如何获取？）。
	 * 第三方应用需具有“企业客户权限->获客助手”权限
	 * 不支持客户联系系统应用调用
	 *
	 *
	 * 返回结果:
	 *
	 * {
	 * "errcode": 0,
	 * "errmsg": "ok"
	 * }
	 * 参数说明:
	 *
	 * 参数 说明
	 * errcode 返回码
	 * errmsg 对返回码的文本描述内容
	 */
	public function deleteLink($link_id)
	{
		$params = array();
		$params['link_id'] = $link_id;
		$rst = $this->_request->post($this->_url . 'delete_link', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 获取由获客链接添加的客户信息
	 * 最后更新：2023/03/28
	 * 获取获客客户列表
	 * 企业可通过此接口获取到由指定的获客链接添加的客户列表。
	 *
	 * 请求方式: POST(HTTP)
	 *
	 * 请求地址:https://qyapi.weixin.qq.com/cgi-bin/externalcontact/customer_acquisition/customer?access_token=ACCESS_TOKEN
	 *
	 * 请求示例
	 *
	 * {
	 * "link_id":"LINK_ID",
	 * "limit":1000,
	 * "cursor":"CURSOR"
	 * }
	 * 参数说明:
	 *
	 * 参数 必须 说明
	 * access_token 是 调用接口凭证
	 * link_id 是 获客链接id
	 * limit 否 返回的最大记录数，整型，最大值1000
	 * cursor 否 用于分页查询的游标，字符串类型，由上一次调用返回，首次调用可不填
	 *
	 *
	 * 权限说明:
	 *
	 * 企业需要使用配置到“可调用应用”列表中的自建应用secret所获取的accesstoken来调用（accesstoken如何获取？）。
	 * 第三方应用需具有“企业客户权限->获客助手”权限
	 * 不支持客户联系系统应用调用
	 *
	 *
	 * 返回结果:
	 *
	 * {
	 * "errcode": 0,
	 * "errmsg": "ok",
	 * "customer_list":
	 * [
	 * {
	 * "external_userid":"woAJ2GCAAAXtWyujaWJHDDGi0mACAAA",
	 * "userid":"zhangsan",
	 * "chat_status":0,
	 * "state":"CHANNEL_A"
	 * },
	 * {
	 * "external_userid":"woAJ2GCAAAXtWyujaWJHDDGi0mACAAA",
	 * "userid":"lisi",
	 * "chat_status":0,
	 * "state":"CHANNEL_B"
	 * },
	 * {
	 * "external_userid":"woAJ2GCAAAXtWyujaWJHDDGi0mBCBBB",
	 * "userid":"rocky",
	 * "chat_status":1,
	 * "state":"CHANNEL_A"
	 * }
	 * ],
	 * "next_cursor":"CURSOR"
	 * }
	 * 参数说明:
	 *
	 * 参数 说明
	 * errcode 返回码
	 * errmsg 对返回码的文本描述内容
	 * customer_list.external_userid 客户external_userid
	 * customer_list.userid 通过获客链接添加此客户的跟进人userid
	 * customer_list.chat_status 会话状态，0-客户未发消息 1-客户已发送消息
	 * customer_list.state 用于区分客户具体是通过哪个获客链接进行添加，用户可在获客链接后拼接customer_channel=自定义字符串，字符串不超过64字节，超过会被截断。通过点击带有customer_channel参数的链接获取到的客户，调用获客信息接口或获取客户详情接口时，返回的state参数即为链接后拼接自定义字符串
	 * next_cursor 分页游标，再下次请求时填写以获取之后分页的记录，如果已经没有更多的数据则返回空
	 */
	public function customer($link_id, $cursor = "", $limit = 1000)
	{
		$params = array();
		$params['link_id'] = $link_id;
		$params['cursor'] = $cursor;
		$params['limit'] = $limit;
		$rst = $this->_request->post($this->_url . 'customer', $params);
		return $this->_client->rst($rst);
	}
	/**
	 * 查询剩余使用量
	 * 最后更新：2023/03/24
	 * 查询剩余使用量
	 * 企业可通过此接口查询当前剩余的使用量。
	 *
	 * 请求方式：GET（HTTPS）
	 * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/externalcontact/customer_acquisition_quota?access_token=ACCESS_TOKEN
	 *
	 * 参数说明：
	 *
	 * 参数 必须 说明
	 * access_token 是 调用接口凭证
	 *
	 *
	 * 权限说明：
	 *
	 * 企业需要使用配置到“可调用应用”列表中的自建应用secret所获取的accesstoken来调用（accesstoken如何获取？）；
	 * 第三方应用需具有“企业客户权限->获客助手”权限
	 * 不支持客户联系系统应用调用
	 *
	 *
	 * 返回结果：
	 *
	 * {
	 * "errcode": 0,
	 * "errmsg": "ok",
	 * "total":1000,
	 * "balance":500
	 * }
	 * 参数说明：
	 *
	 * 参数 说明
	 * errcode 返回码
	 * errmsg 对返回码的文本描述内容
	 * total 历史累计使用量
	 * balance 剩余使用量
	 */
	public function quota()
	{
		$params = array();
		$rst = $this->_request->post('https://qyapi.weixin.qq.com/cgi-bin/externalcontact/customer_acquisition_quota', $params);
		return $this->_client->rst($rst);
	}
}
