<?php

namespace Qyweixin;

use Qyweixin\Helpers;
use Qyweixin\Http\Request;
use Qyweixin\Model\Config;

/**
 * 企业微信JSSDK https://work.weixin.qq.com/api/doc/90000/90136/90506
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class Jssdk
{
    // 接口地址
    private $_url = 'https://qyapi.weixin.qq.com/cgi-bin/';

    private $_config = null;
    private $_client = null;

    public function __construct(Config $conf = null)
    {
        $this->_config = $conf;
        $this->_client = new Client(\uniqid(), \uniqid(), $this->_config);
    }
    /**
     * 获取企业的jsapi_ticket
     * 生成签名之前必须先了解一下jsapi_ticket，jsapi_ticket是H5应用调用企业微信JS接口的临时票据。正常情况下，jsapi_ticket的有效期为7200秒，通过access_token来获取。由于获取jsapi_ticket的api调用次数非常有限（一小时内，一个企业最多可获取400次，且单个应用不能超过100次），频繁刷新jsapi_ticket会导致api调用受限，影响自身业务，开发者必须在自己的服务全局缓存jsapi_ticket。
     *
     * 请求方式：GET（HTTPS）
     * 请求URL：https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token=ACCESS_TOKEN
     *
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证，
     * 企业内部开发，获取方式参考“获取access_token”
     * 第三方应用开发，获取方式参考“获取企业凭证”
     * 返回结果：
     *
     * {
     * "errcode":0,
     * "errmsg":"ok",
     * "ticket":"bxLdikRXVbTPdHSM05e5u5sUoXNKd8-41ZO3MhKoyN5OfkWITDGgnr2fwJ0m9E8NYzWKVZvdVtaUgWvsdshFKA",
     * "expires_in":7200
     * }
     * 参数 说明
     * ticket 生成签名所需的jsapi_ticket，最长为512字节
     * expires_in 凭证的有效时间（秒）
     * 该jsapi_ticket只能用于wx.config接口计算签名，如果要计算wx.agentConfig接口签名，请使用“获取应用的jsapi_ticket”接口来获取jsapi_ticket
     *
     * @return array
     */
    public function getJsApiTicket($access_token)
    {
        $params = array();
        $_request = new Request($access_token);
        $_request->setClient($this->_client);
        $rst = $_request->get($this->_url . 'get_jsapi_ticket', $params);
        if (!empty($rst['errcode'])) {
            // 如果有异常，会在errcode 和errmsg 描述出来。
            throw new \Exception($rst['errmsg'], $rst['errcode']);
        } else {
            return $rst;
        }
    }

    /**
     * 获取应用的jsapi_ticket
     * 应用的jsapi_ticket用于计算agentConfig（参见“通过agentConfig注入应用的权限”）的签名，签名计算方法与上述介绍的config的签名算法完全相同，但需要注意以下区别：
     *
     * 签名的jsapi_ticket必须使用以下接口获取。且必须用wx.agentConfig中的agentid对应的应用secret去获取access_token。
     * 签名用的noncestr和timestamp必须与wx.agentConfig中的nonceStr和timestamp相同。
     * 请求方式：GET（HTTPS）
     * 请求URL：https://qyapi.weixin.qq.com/cgi-bin/ticket/get?access_token=ACCESS_TOKEN&type=agent_config
     *
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 应用的调用凭证，获取方式参考“获取access_token”
     * 返回结果：
     *
     * {
     * "errcode":0,
     * "errmsg":"ok",
     * "ticket":"bxLdikRXVbTPdHSM05e5u5sUoXNKd8-41ZO3MhKoyN5OfkWITDGgnr2fwJ0m9E8NYzWKVZvdVtaUgWvsdshFKA",
     * "expires_in":7200
     * }
     * 参数 说明
     * ticket 生成签名所需的jsapi_ticket，最长为512字节
     * expires_in 凭证的有效时间（秒）
     *
     * @return array
     */
    public function getJsApiTicket4Agent($access_token)
    {
        $params = array(
            'type' => 'agent_config'
        );
        $_request = new Request($access_token);
        $_request->setClient($this->_client);
        $rst = $_request->get($this->_url . 'ticket/get', $params);
        if (!empty($rst['errcode'])) {
            // 如果有异常，会在errcode 和errmsg 描述出来。
            throw new \Exception($rst['errmsg'], $rst['errcode']);
        } else {
            return $rst;
        }
    }

    /**
     * JS-SDK使用权限签名算法
     * 签名算法
     * 签名生成规则如下：
     * 参与签名的参数有四个: noncestr（随机字符串）, jsapi_ticket(如何获取参考“获取企业jsapi_ticket”以及“获取应用的jsapi_ticket接口”), timestamp（时间戳）, url（当前网页的URL， 不包含#及其后面部分）
     *
     * 将这些参数使用URL键值对的格式 （即 key1=value1&key2=value2…）拼接成字符串string1。
     * 有两个注意点：1. 字段值采用原始值，不要进行URL转义；2. 必须严格按照如下格式拼接，不可变动字段顺序。
     *
     * jsapi_ticket=JSAPITICKET&noncestr=NONCESTR&timestamp=TIMESTAMP&url=URL
     * 然后对string1作sha1加密即可。
     * 示例 :
     *
     * 假如有如下参数：
     *
     * noncestr=Wm3WZYTPz0wzccnW
     * jsapi_ticket=sM4AOVdWfPE4DxkXGEs8VMCPGGVi4C3VM0P37wVUCFvkVAy_90u5h9nbSlYy3-Sl-HhTdfl2fzFy1AOcHKP7qg
     * timestamp=1414587457
     * url=http://mp.weixin.qq.com?params=value
     * 步骤1. 将这些参数拼接成字符串string1：
     *
     * jsapi_ticket=sM4AOVdWfPE4DxkXGEs8VMCPGGVi4C3VM0P37wVUCFvkVAy_90u5h9nbSlYy3-Sl-HhTdfl2fzFy1AOcHKP7qg&noncestr=Wm3WZYTPz0wzccnW&timestamp=1414587457&url=http://mp.weixin.qq.com?params=value
     * 步骤2. 对string1进行sha1签名，得到signature：
     *
     * 0f9de62fce790f9a083d5c99e95740ceb90c27ed
     * 注意事项
     *
     * 签名用的noncestr和timestamp必须与wx.config中的nonceStr和timestamp相同。
     * 签名用的url必须是调用JS接口页面的完整URL。
     * 出于安全考虑，开发者必须在服务器端实现签名的逻辑。
     * 如出现invalid signature 等错误详见附录4常见错误及解决办法。
     *
     * @return array
     */
    public function getSignPackage($url, $jsapi_ticket)
    {
        // $url = "{$http}://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
        $timestamp = time();
        $nonceStr = Helpers::createNonceStr();

        // 这里参数的顺序要按照 key 值 ASCII 码升序排序
        $string = "jsapi_ticket={$jsapi_ticket}&noncestr={$nonceStr}&timestamp={$timestamp}&url={$url}";
        $signature = sha1($string);

        $signPackage = array(
            "nonceStr" => $nonceStr,
            "timestamp" => $timestamp,
            "url" => $url,
            "signature" => $signature,
            "rawString" => $string
        );
        return $signPackage;
    }
}
