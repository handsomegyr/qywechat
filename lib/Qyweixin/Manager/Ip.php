<?php

namespace Qyweixin\Manager;

use Qyweixin\Client;

/**
 * 获取企业微信API域名IP段
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class Ip
{

    // 接口地址
    private $_url = 'https://qyapi.weixin.qq.com/cgi-bin/';

    private $_client;

    private $_request;

    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 获取企业微信API域名IP段
     * 调试工具
     * API域名IP即qyapi.weixin.qq.com的解析地址，由开发者调用企业微信侧的接入IP。如果企业需要做防火墙配置，那么可以通过这个接口获取到所有相关的IP段。IP段有变更可能，当IP段变更时，新旧IP段会同时保留一段时间。建议企业每天定时拉取IP段，更新防火墙设置，避免因IP段变更导致网络不通。
     *
     * 请求方式：GET（HTTPS）
     * 请求地址： https://qyapi.weixin.qq.com/cgi-bin/get_api_domain_ip?access_token=ACCESS_TOKEN （获取ACCESS_TOKEN）
     *
     * 请求参数说明：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * 权限说明：
     *
     * 无限定。
     *
     * 返回结果：
     *
     * {
     * "ip_list":[
     * "182.254.11.176",
     * "182.254.78.66"
     * ],
     * "errcode":0,
     * "errmsg":"ok"
     * }
     * 返回参数说明：
     *
     * 参数 类型 说明
     * ip_list StringArray 企业微信服务器IP段
     * errcode int 错误码，0表示成功，非0表示调用失败
     * errmsg string 错误信息，调用失败会有相关的错误信息返回
     * 根据errcode值非0，判断调用失败。以下是access_token过期的返回示例：
     *
     * {
     * "ip_list":[],
     * "errcode":42001,
     * "errmsg":"access_token expired, hint: [1576065934_28_e0fae07666aa64636023c1fa7e8f49a4], from ip: 9.30.0.138, more info at https://open.work.weixin.qq.com/devtool/query?e=42001"
     * }
     */
    public function getApiDomainIp()
    {
        $rst = $this->_request->get($this->_url . 'get_api_domain_ip');
        return $this->_client->rst($rst);
    }
}
