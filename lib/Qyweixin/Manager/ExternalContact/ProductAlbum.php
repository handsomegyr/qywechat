<?php

namespace Qyweixin\Manager\ExternalContact;

use Qyweixin\Client;

/**
 * 管理商品图册
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class ProductAlbum
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
	 * 获取商品图册列表
	 * 企业和第三方应用可以通过此接口导出商品
	 * 请求方式：POST(HTTPS)
	 * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/externalcontact/get_product_album_list?access_token=ACCESS_TOKEN
	 *
	 * 请求示例：
	 *
	 * {
	 * "limit":50,
	 * "cursor":"CURSOR"
	 * }
	 * 参数说明：
	 *
	 * 参数 必须 说明
	 * access_token 是 调用接口凭证
	 * limit 否 返回的最大记录数，整型，最大值100，默认值50，超过最大值时取默认值
	 * cursor 否 用于分页查询的游标，字符串类型，由上一次调用返回，首次调用可不填
	 * 权限说明:
	 *
	 * 企业需要使用“客户联系”secret或配置到“可调用应用”列表中的自建应用secret所获取的accesstoken来调用（accesstoken如何获取？）。
	 * 自建应用调用，只会返回应用可见范围内用户的情况。
	 * 第三方应用或代开发自建应用调用需要企业授权客户联系下管理商品图册的权限
	 * 返回结果:
	 *
	 * {
	 * "errcode":0,
	 * "errmsg":"ok",
	 * "next_cursor":"CURSOR",
	 * "product_list":[
	 * {
	 * "product_id" : "xxxxxxxxxx",
	 * "description":"世界上最好的商品",
	 * "price":30000,
	 * "product_sn":"xxxxxxxx",
	 * "attachments":[
	 * {
	 * "type": "image",
	 * "image": {
	 * "media_id": "MEDIA_ID"
	 * }
	 * }
	 * ]
	 * }
	 * ]
	 * }
	 * 参数说明:
	 *
	 * 参数 说明
	 * errcode 返回码
	 * errmsg 对返回码的文本描述内容
	 * next_cursor 用于分页查询的游标，字符串类型，用于下一次调用
	 * product_list 商品列表
	 * product_list.product_id 商品id
	 * product_list.product_sn 商品编码
	 * product_list.description 商品的名称、特色等
	 * product_list.price 商品的价格，单位为分
	 * product_list.attachments 附件类型
	 * product_list.attachments.type 附件类型，目前仅支持image
	 * product_list.image.media_id 图片的media_id，可以通过获取临时素材下载资源
	 */
	public function getList($cursor = "", $limit = 100)
	{
		$params = array();
		$params['cursor'] = $cursor;
		$params['limit'] = $limit;
		$rst = $this->_request->post($this->_url . 'get_product_album_list', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 创建商品图册
	 * 企业和第三方应用可以通过此接口增加商品
	 * 请求方式：POST(HTTPS)
	 * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/externalcontact/add_product_album?access_token=ACCESS_TOKEN
	 *
	 * 请求示例：
	 *
	 * {
	 * "description":"世界上最好的商品",
	 * "price":30000,
	 * "product_sn":"xxxxxxxx",
	 * "attachments":[
	 * {
	 * "type": "image",
	 * "image": {
	 * "media_id": "MEDIA_ID"
	 * }
	 * }
	 * ]
	 * }
	 * 参数说明：
	 *
	 * 参数 必须 说明
	 * access_token 是 调用接口凭证
	 * description 是 商品的名称、特色等;不超过300个字
	 * price 是 商品的价格，单位为分；最大不超过5万元
	 * product_sn 否 商品编码；不超过128个字节；只能输入数字和字母
	 * attachments 是 附件类型，仅支持image，最多不超过9个附件
	 * image.media_id 否 图片的media_id，仅支持通过上传附件资源接口获得的资源
	 * 权限说明:
	 *
	 * 企业需要使用“客户联系”secret或配置到“可调用应用”列表中的自建应用secret所获取的accesstoken来调用（accesstoken如何获取？）。
	 * 第三方应用或代开发自建应用调用需要企业授权客户联系下管理商品图册的权限
	 * 返回结果:
	 *
	 * {
	 * "errcode":0,
	 * "errmsg":"ok",
	 * "product_id" : "xxxxxxxxxx"
	 * }
	 * 参数说明:
	 *
	 * 参数 说明
	 * errcode 返回码
	 * errmsg 对返回码的文本描述内容
	 * product_id 商品id
	 */
	public function add(\Qyweixin\Model\ExternalContact\ProductAlbum $productAlbum)
	{
		$params = $productAlbum->getParams();
		$rst = $this->_request->post($this->_url . 'add_product_album', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 获取商品图册
	 * 企业和第三方应用可以通过此接口获取商品信息
	 * 请求方式：POST(HTTPS)
	 * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/externalcontact/get_product_album?access_token=ACCESS_TOKEN
	 *
	 * 请求示例：
	 *
	 * {
	 * "product_id" : "xxxxxxxxxx"
	 * }
	 * 参数说明：
	 *
	 * 参数 必须 说明
	 * access_token 是 调用接口凭证
	 * 权限说明:
	 *
	 * 企业需要使用“客户联系”secret或配置到“可调用应用”列表中的自建应用secret所获取的accesstoken来调用（accesstoken如何获取？）。
	 * 第三方应用或代开发自建应用调用需要企业授权客户联系下管理商品图册的权限
	 * 可获取企业内所有企业级的商品图册
	 * 返回结果:
	 *
	 * {
	 * "errcode":0,
	 * "errmsg":"ok",
	 * "product": {
	 * "product_id" : "xxxxxxxxxx",
	 * "description":"世界上最好的商品",
	 * "price":30000,
	 * "create_time":1600000000,
	 * "product_sn":"xxxxxxxx",
	 * "attachments":[
	 * {
	 * "type": "image",
	 * "image": {
	 * "media_id": "MEDIA_ID"
	 * }
	 * }
	 * ]
	 * }
	 * }
	 * 参数说明:
	 *
	 * 参数 说明
	 * errcode 返回码
	 * errmsg 对返回码的文本描述内容
	 * product 商品详情
	 * product_id 商品id
	 * product_sn 商品编码
	 * description 商品的名称、特色等
	 * price 商品的价格，单位为分
	 * create_time 商品图册创建时间
	 * attachments 附件类型
	 * attachments.type 附件类型，目前仅支持image
	 * image.media_id 图片的media_id，可以通过获取临时素材下载资源
	 */
	public function get($product_id)
	{
		$params = array();
		$params['product_id'] = $product_id;
		$rst = $this->_request->post($this->_url . 'get_product_album', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 编辑商品图册
	 * 企业和第三方应用可以通过此接口修改商品信息
	 * 请求方式：POST(HTTPS)
	 * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/externalcontact/update_product_album?access_token=ACCESS_TOKEN
	 *
	 * 请求示例：
	 *
	 * {
	 * "product_id" : "xxxxxxxxxx",
	 * "description":"世界上最好的商品",
	 * "price":30000,
	 * "product_sn":"xxxxxx",
	 * "attachments":[
	 * {
	 * "type": "image",
	 * "image": {
	 * "media_id": "MEDIA_ID"
	 * }
	 * }
	 * ]
	 * }
	 * 参数说明：
	 *
	 * 参数 必须 说明
	 * access_token 是 调用接口凭证
	 * product_id 是 商品id
	 * description 是 商品的名称、特色等;不超过300个字
	 * price 是 商品的价格，单位为分；最大不超过5万元
	 * product_sn 否 商品编码；不超过128个字节；只能输入数字和字母
	 * attachments 否 附件类型，仅支持image
	 * attachments.type 附件类型，目前仅支持image
	 * image.media_id 否 图片的media_id，仅支持通过上传附件资源接口的资源
	 * 注：除product_id外，需要更新的字段才填，不需更新的字段可不填。
	 * 权限说明:
	 *
	 * 企业需要使用“客户联系”secret或配置到“可调用应用”列表中的自建应用secret所获取的accesstoken来调用（accesstoken如何获取？）。
	 * 第三方应用或代开发自建应用调用需要企业授权客户联系下管理商品图册的权限
	 * 应用只修改应用自己创建的商品图册；客户联系系统应用可修改所有商品图册
	 * 返回结果:
	 *
	 * {
	 * "errcode":0,
	 * "errmsg":"ok"
	 * }
	 * 参数说明:
	 *
	 * 参数 说明
	 * errcode 返回码
	 * errmsg 对返回码的文本描述内容
	 */
	public function update(\Qyweixin\Model\ExternalContact\ProductAlbum $productAlbum)
	{
		$params = $productAlbum->getParams();
		$rst = $this->_request->post($this->_url . 'update_product_album', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 删除商品图册
	 * 企业和第三方应用可以通过此接口删除商品信息
	 * 请求方式：POST(HTTPS)
	 * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/externalcontact/delete_product_album?access_token=ACCESS_TOKEN
	 *
	 * 请求示例：
	 *
	 * {
	 * "product_id" : "xxxxxxxxxx"
	 * }
	 * 参数说明：
	 *
	 * 参数 必须 说明
	 * access_token 是 调用接口凭证
	 * 权限说明:
	 *
	 * 企业需要使用“客户联系”secret或配置到“可调用应用”列表中的自建应用secret所获取的accesstoken来调用（accesstoken如何获取？）。
	 * 第三方应用或代开发自建应用调用需要企业授权客户联系下管理商品图册的权限
	 * 应用只可删除应用自己创建的商品图册；客户联系系统应用可删除所有商品图册
	 * 返回结果:
	 *
	 * {
	 * "errcode":0,
	 * "errmsg":"ok"
	 * }
	 * 参数说明:
	 *
	 * 参数 说明
	 * errcode 返回码
	 * errmsg 对返回码的文本描述内容
	 */
	public function delete($product_id)
	{
		$params = array();
		$params['product_id'] = $product_id;
		$rst = $this->_request->post($this->_url . 'delete_product_album', $params);
		return $this->_client->rst($rst);
	}
}
