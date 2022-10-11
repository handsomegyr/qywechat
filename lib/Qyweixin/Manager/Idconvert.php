<?php

namespace Qyweixin\Manager;

use Qyweixin\Client;

/**
 * ID转换接口
 * https://developer.work.weixin.qq.com/document/path/97108
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class Idconvert
{

    // 接口地址
    private $_url = 'https://qyapi.weixin.qq.com/cgi-bin/idconvert/';
    private $_client;
    private $_request;
    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * unionid转换为第三方external_userid
     * 当微信用户进入服务商的小程序或公众号时，服务商可通过此接口，将微信客户的unionid转为第三方主体的external_userid，若该微信用户尚未成为企业的客户，则返回pending_id。
     * 小程序或公众号的主体名称可以是企业的，也可以是服务商的。
     * 该接口有调用频率限制，按企业作如下的限制：10万次/小时、48万次/天、750万次/月
     *
     *
     *
     * 请求方式：POST（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/idconvert/unionid_to_external_userid?access_token=ACCESS_TOKEN
     *
     * 请求参数：
     *
     * {
     * "unionid":"oAAAAAAA",
     * "openid":"oBBBB",
     * "subject_type":1
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
     * 权限说明：
     *
     * 当前授权企业必须已认证或已验证
     * unionid（即微信开放平台账号主体）与openid（即小程序或服务号账号主体）需要认证，且主体名称需与当前授权企业的主体名称一致（查看由服务商代注册的开放平台帐号认证流程），或者主体名称需与服务商的主体名称一致。
     * openid与unionid必须是在同一个小程序获取到的
     * 返回结果：
     *
     * ｛
     * "errcode":0,
     * "errmsg":"ok",
     * "external_userid":"ooAAAAAAAAAAA",
     * "pending_id":"ooBBBBBB"
     * ｝
     * 参数说明：
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     * external_userid 该授权企业的外部联系人ID
     * pending_id 该微信帐号尚未成为企业客户时，返回的临时外部联系人ID，该ID有效期为90天，当该用户在90天内成为企业客户时，可以通过external_userid查询pending_id关联
     * 注：
     * 1. pending_id仅用于关联unionid与external_userid，并无法当成external_userid调用接口。
     * 2. 当微信客户的跟进人或所在客户群的群主不在应用可见范围，也不返回external_userid，而是返回pending_id。
     */
    public function unionidToExternalUserid($unionid, $openid, $subject_type = 0, $mass_call_ticket = "")
    {
        $params = array();
        $params['unionid'] = $unionid;
        $params['openid'] = $openid;
        $params['subject_type'] = $subject_type;
        if (!empty($mass_call_ticket)) {
            $params['mass_call_ticket'] = $mass_call_ticket;
        }
        $rst = $this->_request->post($this->_url . 'unionid_to_external_userid', $params);
        return $this->_client->rst($rst);
    }

    /**
     * external_userid查询pending_id
     * 该接口可用于当一个微信用户成为企业客户前已经使用过服务商服务（服务商侧曾经调用过unionid转换为第三方external_userid）的场景。本接口获取到的pending_id可以维持unionid和external_userid的关联关系。pending_id有效期为90天，超过有效期之后，将无法通过该接口将external_userid换取对应的pending_id。
     *
     *
     *
     * 请求方式：POST（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/idconvert/batch/external_userid_to_pending_id?access_token=ACCESS_TOKEN
     *
     * 请求参数：
     *
     * {
     * "chat_id":"xxxxxx",
     * "external_userid":["oAAAAAAA", "oBBBBB"]
     * }
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证 ，第三方应用access_token或代开发应用access_token
     * external_userid 是 该企业的外部联系人ID
     * chat_id 否 群id，如果有传入该参数，则只检查群主是否在可见范围，同时会忽略在该群以外的external_userid。如果不传入该参数，则只检查客户跟进人是否在可见范围内。
     * 权限说明：
     *
     * 仅认证企业可调用
     * 该客户的跟进人或其所在客户群群主必须在应用的可见范围之内
     * 返回结果：
     *
     * ｛
     * "errcode":0,
     * "errmsg":"ok",
     * "result":[
     * {
     * "external_userid":"oAAAAAAA",
     * "pending_id":"pAAAAA"
     * },
     * {
     * "external_userid":"oBBBBB",
     * "pending_id":"pBBBBB"
     * }
     * ]
     * ｝
     * 参数说明：
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     * result 转换结果
     * external_userid 该企业的外部联系人ID
     * pending_id 该微信账号还未成为企业客户时，返回的临时外部联系人ID
     */
    public function batchExternalUseridToPendingId($external_userid, $chat_id = "")
    {
        $params = array();
        $params['external_userid'] = $external_userid;
        if (!empty($chat_id)) {
            $params['chat_id'] = $chat_id;
        }
        $rst = $this->_request->post($this->_url . 'batch/external_userid_to_pending_id', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 客户标签ID的转换
     * 最后更新：2022/09/21
     * 将企业主体下的客户标签ID转换成服务商主体下的客户标签ID。
     *
     * 请求方式：POST（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/idconvert/external_tagid?access_token=ACCESS_TOKEN
     * 请求参数：
     *
     * {
     * "external_tagid_list":["TAG_ID1","TAG_ID2","TAG_ID3","TAG_ID4"]
     * }
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证 ，第三方应用access_token或代开发应用access_token
     * external_tagid_list 是 企业主体下的客户标签ID列表，最多不超过1000个
     * 权限说明：
     *
     * 应用需具有“企业客户权限->客户基础信息”权限
     * 返回结果：
     *
     * ｛
     * "errcode":0,
     * "errmsg":"ok",
     * "items":[
     * {
     * "external_tagid":"TAG_ID1",
     * "open_external_tagid":"OPEN_TAG_ID1"
     * },
     * {
     * "external_tagid":"TAG_ID2",
     * "open_external_tagid":"OPEN_TAG_ID2"
     * },
     * "invalid_external_tagid_list":["TAG_ID3","TAG_ID4"]
     * ｝
     * 参数说明：
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     * items 客户标签转换结果
     * items.external_tagid 企业主体下的客户标签ID
     * items.open_external_tagid 服务商主体下的客户标签ID，如果传入的external_tagid已经是服务商主体下的ID，则open_external_tagid与external_tagid相同。
     * invalid_external_tagid_list 无法转换的客户标签ID列表
     */
    public function externalTagid($external_tagid_list)
    {
        $params = array();
        $params['external_tagid_list'] = $external_tagid_list;
        $rst = $this->_request->post($this->_url . 'external_tagid', $params);
        return $this->_client->rst($rst);
    }
    /**
     * 微信客服ID的转换
     * 最后更新：2022/09/21
     * 将企业主体下的微信客服ID转换成服务商主体下的微信客服ID。
     *
     * 请求方式：POST（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/idconvert/open_kfid?access_token=ACCESS_TOKEN
     * 请求参数：
     *
     * {
     * "open_kfid_list":["KFID1","KFID2","KFID3","KFID4"]
     * }
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证 ，第三方应用access_token或代开发应用access_token
     * open_kfid_list 是 微信客服ID列表，最多不超过1000个
     * 权限说明：
     *
     * 应用需具有“微信客服->管理帐号、分配会话和收发消息”权限
     * 返回结果：
     *
     * ｛
     * "errcode":0,
     * "errmsg":"ok",
     * "items":[
     * {
     * "open_kfid":"KFID1",
     * "new_open_kfid":"NEW_KFID1"
     * },
     * {
     * "open_kfid":"KFID2",
     * "new_open_kfid":"NEW_KFID2"
     * },
     * "invalid_open_kfid_list":["KFID3","KFID4"]
     * ｝
     * 参数说明：
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     * items 微信客服ID转换结果
     * items.open_kfid 企业主体下的微信客服ID
     * items.new_open_kfid 服务商主体下的微信客服ID，如果传入的open_kfid已经是服务商主体下的ID，则new_open_kfid与open_kfid相同。
     * invalid_open_kfid_list 无法转换的微信客服ID列表
     */
    public function openKfid($external_tagid_list)
    {
        $params = array();
        $params['external_tagid_list'] = $external_tagid_list;
        $rst = $this->_request->post($this->_url . 'external_tagid', $params);
        return $this->_client->rst($rst);
    }
}
