<?php

namespace Qyweixin\Manager\Kf;

use Qyweixin\Client;

/**
 * 会话状态管理
 * https://developer.work.weixin.qq.com/document/path/94698
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class ServiceState
{

    // 接口地址
    private $_url = 'https://qyapi.weixin.qq.com/cgi-bin/kf/service_state/';
    private $_client;
    private $_request;
    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 获取会话状态
     * 请求方式: POST(HTTPS)
     *
     * 请求地址: https://qyapi.weixin.qq.com/cgi-bin/kf/service_state/get?access_token=ACCESS_TOKEN
     *
     * 请求实例:
     *
     * {
     * "open_kfid": "wkxxxxxxxxxxxxxxxxxx",
     * "external_userid": "wmxxxxxxxxxxxxxxxxxx"
     * }
     * 参数说明：
     *
     * 参数 是否必须 说明
     * access_token 是 调用接口凭证
     * open_kfid 是 客服帐号ID
     * external_userid 是 微信客户的external_userid
     *
     * 权限说明:
     *
     * 企业需要使用“微信客服”secret所获取的accesstoken来调用（accesstoken如何获取？），同时开启“会话消息管理”开关
     * 第三方应用需具有“微信客服权限->管理帐号、分配会话和收发消息”权限
     * 代开发自建应用需具有“微信客服->管理帐号、分配会话和收发消息”权限
     *
     *
     * 返回结果:
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "service_state": 3,
     * "servicer_userid": "zhangsan"
     * }
     * 参数说明:
     *
     * 参数 类型 说明
     * errcode int 返回码
     * errmsg string 错误码描述
     * service_state int 当前的会话状态，状态定义参考概述中的表格
     * servicer_userid string 接待人员的userid。第三方应用为密文userid，即open_userid。仅当state=3时有效
     */
    public function get($open_kfid, $external_userid)
    {
        $params = array();
        $params['open_kfid'] = $open_kfid;
        $params['external_userid'] = $external_userid;
        $rst = $this->_request->post($this->_url . 'get', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 变更会话状态
     * 请求方式: POST(HTTPS)
     *
     * 请求地址: https://qyapi.weixin.qq.com/cgi-bin/kf/service_state/trans?access_token=ACCESS_TOKEN
     *
     * 请求实例:
     *
     * {
     * "open_kfid": "wkxxxxxxxxxxxxxxxxxx",
     * "external_userid": "wmxxxxxxxxxxxxxxxxxx",
     * "service_state": 3,
     * "servicer_userid": "zhangsan"
     * }
     * 参数说明：
     *
     * 参数 是否必须 说明
     * access_token 是 调用接口凭证
     * open_kfid 是 客服帐号ID
     * external_userid 是 微信客户的external_userid
     * service_state 是 变更的目标状态，状态定义和所允许的变更可参考概述中的流程图和表格
     * servicer_userid 否 接待人员的userid。第三方应用填密文userid，即open_userid。当state=3时要求必填，接待人员须处于“正在接待”中。
     *
     * 权限说明:
     *
     * 企业需要使用“微信客服”secret所获取的accesstoken来调用（accesstoken如何获取？），同时开启“会话消息管理”开关
     * 第三方应用需具有“微信客服权限->管理帐号、分配会话和收发消息”权限
     * 代开发自建应用需具有“微信客服->管理帐号、分配会话和收发消息”权限
     *
     *
     * 返回结果:
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "msg_code": "MSG_CODE"
     * }
     * 参数说明:
     *
     * 参数 类型 说明
     * errcode int 返回码
     * errmsg string 错误码描述
     * msg_code string 用于发送响应事件消息的code，将会话初次变更为service_state为2和3时，返回回复语code，service_state为4时，返回结束语code。
     * 可用该code调用发送事件响应消息接口给客户发送事件响应消息
     */
    public function trans($open_kfid, $external_userid, $service_state, $servicer_userid)
    {
        $params = array();
        $params['open_kfid'] = $open_kfid;
        $params['external_userid'] = $external_userid;
        $params['service_state'] = $service_state;
        $params['servicer_userid'] = $servicer_userid;
        $rst = $this->_request->post($this->_url . 'trans', $params);
        return $this->_client->rst($rst);
    }
}
