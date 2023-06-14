<?php

namespace Qyweixin\Token;

use Qyweixin\Client;
use Qyweixin\Http\Request;
use Qyweixin\Model\Config;

/**
 * 网页授权登录 https://work.weixin.qq.com/api/doc/90000/90135/91020
 * 扫描授权登录 https://work.weixin.qq.com/api/doc/90000/90135/90988
 */
class Sns
{
    // 企业的CorpID
    private $_appid;
    private $_secret;
    private $_redirect_uri;
    private $_scope = 'snsapi_base';
    private $_state = '';
    private $_agentid = '';
    private $_request;
    private $_config = null;
    private $_client = null;

    public function __construct($appid, $secret, Config $conf = null)
    {
        if (empty($appid)) {
            throw new \Exception('请设定$appid');
        }
        if (empty($secret)) {
            throw new \Exception('请设定$secret');
        }
        $this->_state = uniqid();
        $this->_appid = $appid;
        $this->_secret = $secret;
        $this->_config = $conf;
        $this->_client = new Client($this->_appid, $this->_secret, $this->_config);
    }

    /**
     * 设定微信回调地址
     *
     * @param string $redirect_uri
     * @throws Exception
     */
    public function setRedirectUri($redirect_uri)
    {
        // $redirect_uri = trim(urldecode($redirect_uri));
        $redirect_uri = trim($redirect_uri);
        if (filter_var($redirect_uri, FILTER_VALIDATE_URL) === false) {
            throw new \Exception('$redirect_uri无效');
        }
        $this->_redirect_uri = urlencode($redirect_uri);
    }

    /**
     * 设定作用域类型
     *
     * @param string $scope
     * @throws Exception
     */
    public function setScope($scope)
    {
        if (!in_array($scope, array(
            'snsapi_privateinfo',
            'snsapi_base'
        ), true)) {
            throw new \Exception('$scope无效');
        }
        $this->_scope = $scope;
    }

    /**
     * 设定携带参数信息，请使用rawurlencode编码
     *
     * @param string $state
     */
    public function setState($state)
    {
        $this->_state = $state;
    }

    /**
     * 应用agentid，snsapi_privateinfo时必填
     *
     * @param string $agentid
     */
    public function setAgentid($agentid)
    {
        $this->_agentid = $agentid;
    }

    /**
     * 构造网页授权链接
     * 如果企业需要在打开的网页里面携带用户的身份信息，第一步需要构造如下的链接来获取code参数：
     *
     * https://open.weixin.qq.com/connect/oauth2/authorize?appid=CORPID&redirect_uri=REDIRECT_URI&response_type=code&scope=snsapi_base&state=STATE&agentid=AGENTID#wechat_redirect
     * 参数说明：
     *
     * 参数 必须 说明
     * appid 是 企业的CorpID
     * redirect_uri 是 授权后重定向的回调链接地址，请使用urlencode对链接进行处理
     * response_type 是 返回类型，此时固定为：code
     * scope 是 应用授权作用域。
     * snsapi_base：静默授权，可获取成员的基础信息（UserId与DeviceId）；
     * snsapi_privateinfo：手动授权，可获取成员的详细信息，包含头像、二维码等敏感信息。
     * state 否 重定向后会带上state参数，企业可以填写a-zA-Z0-9的参数值，长度不可超过128个字节
     * agentid 是 应用agentid，snsapi_privateinfo时必填
     * #wechat_redirect 是 终端使用此参数判断是否需要带上身份信息
     * 员工点击后，页面将跳转至 redirect_uri?code=CODE&state=STATE，企业可根据code参数获得员工的userid。code长度最大为512字节。
     *
     * 示例：
     *
     *
     *
     * 假定当前企业CorpID：wxCorpId
     * 访问链接：http://api.3dept.com/cgi-bin/query?action=get
     *
     * 根据URL规范，将上述参数分别进行UrlEncode，得到拼接的OAuth2链接为：
     *
     * https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxCorpId&redirect_uri=http%3a%2f%2fapi.3dept.com%2fcgi-bin%2fquery%3faction%3dget&response_type=code&scope=snsapi_base&state=#wechat_redirect
     *
     *
     * 注意，构造OAuth2链接中参数的redirect_uri是经过UrlEncode的
     * 员工点击后，页面将跳转至
     *
     * http://api.3dept.com/cgi-bin/query?action=get&code=AAAAAAgG333qs9EdaPbCAP1VaOrjuNkiAZHTWgaWsZQ&state=
     * 企业可根据code参数调用获取员工的信息
     */
    public function getAuthorizeUrl($is_redirect = true)
    {
        // https://open.weixin.qq.com/connect/oauth2/authorize?appid=CORPID&redirect_uri=REDIRECT_URI&response_type=code&scope=snsapi_base&state=STATE&agentid=AGENTID#wechat_redirect
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$this->_appid}&redirect_uri={$this->_redirect_uri}&response_type=code&scope={$this->_scope}&state={$this->_state}";
        if (!empty($this->_agentid)) {
            $url .= "&agentid={$this->_agentid}";
        }
        $url .= "#wechat_redirect";
        if (!empty($is_redirect)) {
            header("location:{$url}");
            exit();
        } else {
            return $url;
        }
    }

    /**
     * 获取访问用户身份
     * 该接口用于根据code获取成员信息，适用于自建应用与代开发应用
     *
     * 请求方式：GET（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/user/getuserinfo?access_token=ACCESS_TOKEN&code=CODE
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * code 是 通过成员授权获取到的code，最大为512字节。每次成员授权带上的code将不一样，code只能使用一次，5分钟未被使用自动过期。
     * 权限说明：
     * 跳转的域名须完全匹配access_token对应应用的可信域名，否则会返回50001错误。
     * 返回结果：
     * a) 当用户为企业成员时（无论是否在应用可见范围之内）返回示例如下：
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "UserId":"USERID",
     * "DeviceId":"DEVICEID",
     * "user_ticket": "USER_TICKET"
     * }
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     * UserId 成员UserID。若需要获得用户详情信息，可调用通讯录接口：读取成员。如果是互联企业/企业互联/上下游，则返回的UserId格式如：CorpId/userid
     * DeviceId 手机设备号(由企业微信在安装时随机生成，删除重装会改变，升级不受影响)
     * user_ticket 成员票据，最大为512字节。
     * scope为snsapi_privateinfo，且用户在应用可见范围之内时返回此参数。
     * 后续利用该参数可以获取用户信息或敏感信息，参见"获取访问用户敏感信息"。暂时不支持上下游或/企业互联场景
     * b) 非企业成员时，返回示例如下：
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "OpenId":"OPENID",
     * "DeviceId":"DEVICEID",
     * "external_userid":"EXTERNAL_USERID"
     * }
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     * OpenId 非企业成员的标识，对当前企业唯一。不超过64字节
     * DeviceId 手机设备号(由企业微信在安装时随机生成，删除重装会改变，升级不受影响)
     * external_userid 外部联系人id，当且仅当用户是企业的客户，且跟进人在应用的可见范围内时返回。如果是第三方应用调用，针对同一个客户，同一个服务商不同应用获取到的id相同
     * 出错返回示例：
     *
     * {
     * "errcode": 40029,
     * "errmsg": "invalid code"
     * }
     *
     *
     * @throws Exception
     * @return array
     */
    public function getUserInfo($access_token)
    {
        $code = isset($_GET['code']) ? trim($_GET['code']) : '';
        if ($code == '') {
            throw new \Exception('code不能为空');
        }
        // https://qyapi.weixin.qq.com/cgi-bin/user/getuserinfo?access_token=ACCESS_TOKEN&code=CODE
        $url = "https://qyapi.weixin.qq.com/cgi-bin/user/getuserinfo?access_token={$access_token}&code={$code}";
        $params = array(
            'access_token' => $access_token,
            'code' => $code
        );
        $request = new \Qyweixin\Http\Request($access_token);
        $request->setClient($this->_client);
        $rst = $request->get($url, $params);
        return $rst;
        // if (!empty($rst['errcode'])) {
        //     // 如果有异常，会在errcode 和errmsg 描述出来。
        //     throw new \Exception($rst['errmsg'], $rst['errcode']);
        // } else {
        //     return $rst;
        // }
    }

    /**
     *
     * 获取访问用户敏感信息
     * 自建应用与代开发应用可通过该接口获取成员授权的敏感字段
     *
     * 请求方式：POST（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/user/getuserdetail?access_token=ACCESS_TOKEN
     *
     * 请求包体：
     *
     * {
     * "user_ticket": "USER_TICKET"
     * }
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * user_ticket 是 成员票据
     *
     *
     * 权限说明：
     * 成员必须在应用的可见范围内。
     *
     * 返回结果：
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "userid":"lisi",
     * "gender":"1",
     * "avatar":"http://shp.qpic.cn/bizmp/xxxxxxxxxxx/0",
     * "qr_code":"https://open.work.weixin.qq.com/wwopen/userQRCode?vcode=vcfc13b01dfs78e981c",
     * "mobile": "13800000000",
     * "email": "zhangsan@gzdev.com",
     * "biz_mail":"zhangsan@qyycs2.wecom.work",
     * "address": "广州市海珠区新港中路"
     * }
     * 参数说明：
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     * userid 成员UserID
     * gender 性别。0表示未定义，1表示男性，2表示女性。仅在用户同意snsapi_privateinfo授权时返回真实值，否则返回0.
     * avatar 头像url。仅在用户同意snsapi_privateinfo授权时返回
     * qr_code 员工个人二维码（扫描可添加为外部联系人），仅在用户同意snsapi_privateinfo授权时返回
     * mobile 手机，仅在用户同意snsapi_privateinfo授权时返回，第三方应用不可获取
     * email 邮箱，仅在用户同意snsapi_privateinfo授权时返回，第三方应用不可获取
     * biz_mail 企业邮箱，仅在用户同意snsapi_privateinfo授权时返回，第三方应用不可获取
     * address 仅在用户同意snsapi_privateinfo授权时返回，第三方应用不可获取
     * 注：对于自建应用与代开发应用，敏感字段需要管理员在应用详情里选择，且成员oauth2授权时确认后才返回。敏感字段包括：性别、头像、员工个人二维码、手机、邮箱、企业邮箱、地址。
     *
     * @throws Exception
     * @return array
     */
    public function getUserDetail($access_token, $user_ticket)
    {
        // https://qyapi.weixin.qq.com/cgi-bin/user/getuserdetail?access_token=ACCESS_TOKEN
        $url = "https://qyapi.weixin.qq.com/cgi-bin/user/getuserdetail?access_token={$access_token}";
        $params = array();
        $params['access_token'] = $access_token;
        $params['user_ticket'] = $user_ticket;
        $request = new \Qyweixin\Http\Request($access_token);
        $request->setClient($this->_client);
        $rst = $request->post($url, $params);
        return $rst;
    }

    /**
     * 构造扫码登录链接
     * 构造独立窗口登录二维码
     * 开发者需要构造如下的链接来获取code参数：
     *
     * https://open.work.weixin.qq.com/wwopen/sso/qrConnect?appid=CORPID&agentid=AGENTID&redirect_uri=REDIRECT_URI&state=STATE
     * 参数说明
     *
     * 参数 必须 说明
     * appid 是 企业微信的CorpID，在企业微信管理端查看
     * agentid 是 授权方的网页应用ID，在具体的网页应用中查看
     * redirect_uri 是 重定向地址，需要进行UrlEncode
     * state 否 用于保持请求和回调的状态，授权请求后原样带回给企业。该参数可用于防止csrf攻击（跨站请求伪造攻击），建议企业带上该参数，可设置为简单的随机数加session进行校验
     * lang 否 自定义语言，支持zh、en；lang为空则从Headers读取Accept-Language，默认值为zh
     * 若提示“该链接无法访问”，请检查参数是否填写错误，如redirect_uri的域名与网页应用的可信域名不一致。
     * 若用户不在agentid所指应用的可见范围，扫码时会提示无权限。
     * 返回说明
     * 用户允许授权后，将会重定向到redirect_uri的网址上，并且带上code和state参数
     *
     * redirect_uri?code=CODE&state=STATE
     * 若用户禁止授权，则重定向后不会带上code参数，仅会带上state参数
     *
     * redirect_uri?state=STATE
     *
     *
     * 示例：
     *
     * 假定当前
     * 企业CorpID：wxCorpId
     * 开启授权登录的应用ID：1000000
     * 登录跳转链接：http://api.3dept.com
     * state设置为：weblogin@gyoss9
     *
     * 需要配置的授权回调域为：api.3dept.com
     *
     * 根据URL规范，将上述参数分别进行UrlEncode，得到拼接的OAuth2链接为：
     * https://open.work.weixin.qq.com/wwopen/sso/qrConnect?appid=wxCorpId&agentid=1000000&redirect_uri=http%3A%2F%2Fapi.3dept.com&state=web_login%40gyoss9
     */
    public function getQrConnectUrl($agentid, $is_redirect = true)
    {
        // https://open.work.weixin.qq.com/wwopen/sso/qrConnect?appid=CORPID&agentid=AGENTID&redirect_uri=REDIRECT_URI&state=STATE
        $url = "https://open.work.weixin.qq.com/wwopen/sso/qrConnect?appid={$this->_appid}&agentid={$agentid}&redirect_uri={$this->_redirect_uri}&state={$this->_state}";
        if (!empty($is_redirect)) {
            header("location:{$url}");
            exit();
        } else {
            return $url;
        }
    }
}
