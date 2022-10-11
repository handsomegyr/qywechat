<?php

namespace Qyweixin\Manager;

use Qyweixin\Client;

/**
 * 成员管理
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class Corp
{

	// 接口地址
	private $_url = 'https://qyapi.weixin.qq.com/cgi-bin/corp/';
	private $_client;
	private $_request;
	public function __construct(Client $client)
	{
		$this->_client = $client;
		$this->_request = $client->getRequest();
	}

	/**
	 * 获取加入企业二维码
	 * 调试工具
	 * 支持企业用户获取实时成员加入二维码。
	 *
	 * 请求方式：GET（HTTPS）
	 * 请求地址： https://qyapi.weixin.qq.com/cgi-bin/corp/get_join_qrcode?access_token=ACCESS_TOKEN&size_type=SIZE_TYPE
	 *
	 * 参数说明：
	 *
	 * 参数 必须 说明
	 * access_token 是 调用接口凭证
	 * size_type 否 qrcode尺寸类型，1: 171 x 171; 2: 399 x 399; 3: 741 x 741; 4: 2052 x 2052
	 * 权限说明：
	 * 须拥有通讯录的管理权限，使用通讯录同步的Secret。
	 *
	 * 返回结果 ：
	 *
	 * {
	 * "errcode": 0,
	 * "errmsg": "ok",
	 * "join_qrcode": "https://work.weixin.qq.com/wework_admin/genqrcode?action=join&vcode=3db1fab03118ae2aa1544cb9abe84&r=hb_share_api_mjoin&qr_size=3"
	 * }
	 * 参数说明 ：
	 *
	 * 参数 说明
	 * errcode 返回码
	 * errmsg 对返回码的文本描述内容
	 * join_qrcode 二维码链接，有效期7天
	 */
	public function getJoinQrcode($size_type)
	{
		$params = array();
		$params['size_type'] = $size_type;
		$rst = $this->_request->get($this->_url . 'get_join_qrcode', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 获取接口大批量调用凭据
	 * 最后更新：2022/09/28
	 * 企业授权安装了代开发或第三方应用之后，服务商往往需要为企业进行较大规模的数据初始化，而企业微信的ID转换等接口会有较为严格的业务频率限制，服务商短时间内难以完成初始化。
	 *
	 * 因此，企业微信允许服务商在企业授权后3个月内申请一个高频调用凭据，调用相关接口时传入该凭据，可以不受业务频率限制（但依然受到基础频率限制）。
	 *
	 * 目前仅以下接口支持高频调用凭据：
	 *
	 * unionid转换为第三方external_userid
	 *
	 *
	 *
	 * 获取接口高频调用凭据
	 * 请求方式：GET（HTTPS）
	 * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/corp/apply_mass_call_ticket?access_token=ACCESS_TOKEN
	 *
	 * 请求参数：
	 * 无
	 *
	 * 参数说明：
	 *
	 * 参数 必须 说明
	 * access_token 是 调用接口凭证 ，第三方应用access_token或代开发应用access_token
	 *
	 *
	 * 权限说明：
	 *
	 * 仅限授权三个月内的企业获取，且每个企业最多仅能获取一次
	 * 该凭据获取成功后，有效期为7天，请在7天内完成企业的初始化操作
	 * 使用该凭据可以不受业务频率限制，但是依然受到基础频率限制
	 * 返回结果：
	 *
	 * ｛
	 * "errcode":0,
	 * "errmsg":"ok",
	 * "mass_call_ticket":"AAAAAA"
	 * ｝
	 * 参数说明：
	 *
	 * 参数 说明
	 * errcode 返回码
	 * errmsg 对返回码的文本描述内容
	 * mass_call_ticket 大批量调用凭据
	 * 凭据使用示例
	 * 以unionid转换为第三方external_userid为例，在请求中加入mass_call_ticket字段即可：
	 *
	 * 请求方式：POST（HTTPS）
	 * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/idconvert/unionid_to_external_userid?access_token=ACCESS_TOKEN
	 *
	 * 请求参数：
	 *
	 * {
	 * "unionid":"oAAAAAAA",
	 * "openid":"oBBBB",
	 * "subject_type":1,
	 * "mass_call_ticket":"TICKET"
	 * }
	 * 参数说明：
	 *
	 * 参数 必须 说明
	 * access_token 是 调用接口凭证 ，第三方应用access_token或代开发应用access_token
	 * unionid 是 微信客户的unionid
	 * openid 是 微信客户的openid
	 * subject_type 否 小程序或公众号的主体类型：
	 * 0表示主体名称是企业的，
	 * 1表示主体名称是服务商的
	 * mass_call_ticket 否 大批量调用凭据
	 */
	public function applyMassCallTicket()
	{
		$params = array();
		$rst = $this->_request->get($this->_url . 'apply_mass_call_ticket', $params);
		return $this->_client->rst($rst);
	}
}
