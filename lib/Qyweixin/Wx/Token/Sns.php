<?php

namespace Qyweixin\Wx\Token;

/**
 * 小程序登录流程 https://work.weixin.qq.com/api/doc/90000/90136/91507
 */
class Sns
{
    private $_context;

    public function __construct()
    {
        $opts = array(
            'http' => array(
                'follow_location' => 3,
                'max_redirects' => 3,
                'timeout' => 10,
                'method' => "GET",
                'header' => "Connection: close\r\n",
                'user_agent' => 'R&D'
            ),
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false
            )
        );
        $this->_context = stream_context_create($opts);
    }

    /**
     * code2Session
     * 临时登录凭证校验接口是一个服务端HTTPS 接口，开发者服务器使用临时登录凭证code获取 session_key、用户userid以及用户所在企业的corpid等信息。
     *
     * 接口地址：
     *
     * https://qyapi.weixin.qq.com/cgi-bin/miniprogram/jscode2session?access_token=ACCESS_TOKEN&js_code=CODE&grant_type=authorization_code
     * 请求参数
     *
     * 参数 是否必须 说明
     * access_token 是 调用接口凭证(注意，此处的access_token 是企业微信应用的access_token，获取方法参见“获取access_token”。要求必须由该小程序关联的企业微信应用的secret获取
     * js_code 是 登录时获取的 code
     * grant_type 是 此处固定为authorization_code
     * 权限说明：
     * access_token必须是与小程序关联的企业微信应用secret所获得。
     *
     * 返回说明
     *
     * //正常返回的JSON数据包
     * {
     * "corpid": "CORPID",
     * "userid": "USERID",
     * "session_key": "kJtdi6RF+Dv67QkbLlPGjw==",
     * "errcode": 0,
     * "errmsg": "ok"
     * }
     * //错误时返回JSON数据包(示例为Code无效)
     * {
     * "errcode": 40029,
     * "errmsg": "invalid code"
     * }
     * 参数说明
     *
     * 参数 说明
     * corpid 用户所属企业的corpid
     * userid 用户在企业内的UserID，对应管理端的帐号，企业内唯一。注意：如果该企业没有关联该小程序，则此处返回加密的userid
     * session_key 会话密钥
     * 注意：
     *
     * 企业微信的jscode2session请求url与微信的不同
     * 企业微信的jscode2session返回的是userid，而微信返回的是openid
     * 获取access_token时请使用企业的corpid参数，请勿使用小程序的appid
     * 会话密钥 session_key 是对用户数据进行加密签名的密钥，为了应用自身的数据安全，开发者服务器不应该把会话密钥下发到小程序，也不应该对外提供这个密钥。
     *
     * @throws Exception
     * @return array
     */
    public function getJscode2session($access_token, $js_code)
    {
        if (empty($js_code)) {
            throw new \Exception('js_code不能为空');
        }
        $response = file_get_contents("https://qyapi.weixin.qq.com/cgi-bin/miniprogram/jscode2session?access_token={$access_token}&js_code={$js_code}&grant_type=authorization_code", false, $this->_context);
        $response = json_decode($response, true);

        return $response;
    }
}
