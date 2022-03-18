<?php

namespace Qyweixin\Manager\Kf;

use Qyweixin\Client;

/**
 * 升级服务管理
 * https://developer.work.weixin.qq.com/document/path/94702
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class Customer
{

    // 接口地址
    private $_url = 'https://qyapi.weixin.qq.com/cgi-bin/kf/customer/';
    private $_client;
    private $_request;
    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 获取配置的专员与客户群
     * 企业需要在管理后台或移动端中的「微信客服」-「升级服务」中，配置专员和客户群。该接口提供获取配置的专员与客户群列表的能力。
     *
     * 请求方式: GET(HTTPS)
     *
     * 请求地址: https://qyapi.weixin.qq.com/cgi-bin/kf/customer/get_upgrade_service_config?access_token=ACCESS_TOKEN
     *
     * 参数说明：
     *
     * 参数 是否必须 说明
     * access_token 是 调用接口凭证
     * 权限说明:
     *
     * 企业需要使用“微信客服”secret所获取的accesstoken来调用（accesstoken如何获取？）
     * 第三方应用需具有“微信客服权限->服务工具->配置「升级服务」”权限
     * 代开发自建应用需具有“微信客服权限->服务工具->配置「升级服务」”权限
     *
     *
     * 返回结果:
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "member_range": {
     * "userid_list": [
     * "zhangsan",
     * "lisi"
     * ],
     * "department_id_list": [
     * 2,
     * 3
     * ]
     * },
     * "groupchat_range": {
     * "chat_id_list": [
     * "wraaaaaaaaaaaaaaaa",
     * "wrbbbbbbbbbbbbbbb"
     * ]
     * }
     * }
     * 参数说明:
     *
     * 参数 类型 说明
     * errcode int 返回码
     * errmsg string 错误码描述
     * member_range object 专员服务配置范围
     * member_range.userid_list string 专员userid列表
     * member_range.department_list unsigned int 专员部门列表
     * groupchat_range object 客户群配置范围
     * groupchat_range.chat_id_list string 客户群列表
     */
    public function getUpgradeServiceConfig()
    {
        $params = array();
        $rst = $this->_request->get($this->_url . 'get_upgrade_service_config', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 为客户升级为专员或客户群服务
     * 企业可通过其他接口获知客户的 external_userid 以及客户与接待人员的聊天内容，因此可以结合实际业务场景，为客户推荐指定的服务专员或客户群。
     * 通过该 API 为客户指定专员或客户群后，接待人员可在企业微信中，见到特殊的状态提示（Windows 为 icon 样式变化，移动端为出现一条 bar ），便于接待人员知晓企业的指定动作。
     *
     *
     * 请求方式: POST(HTTPS)
     *
     * 请求地址: https://qyapi.weixin.qq.com/cgi-bin/kf/customer/upgrade_service?access_token=ACCESS_TOKEN
     *
     * 升级专员服务:
     *
     * {
     * "open_kfid": "kfxxxxxxxxxxxxxx",
     * "external_userid": "wmxxxxxxxxxxxxxxxxxx",
     * "type": 1,
     * "member": {
     * "userid": "zhangsan",
     * "wording": "你好，我是你的专属服务专员zhangsan"
     * }
     * }
     * 升级客户群服务:
     *
     * {
     * "open_kfid": "kfxxxxxxxxxxxxxx",
     * "external_userid": "wmxxxxxxxxxxxxxxxxxx",
     * "type": 2,
     * "groupchat": {
     * "chat_id": "wraaaaaaaaaaaaaaaa",
     * "wording": "欢迎加入你的专属服务群"
     * }
     * }
     * 参数说明：
     *
     * 参数 是否必须 说明
     * access_token 是 调用接口凭证
     * open_kfid 是 客服帐号ID
     * external_userid 是 微信客户的external_userid
     * type 是 表示是升级到专员服务还是客户群服务。1:专员服务。2:客户群服务
     * member 否 推荐的服务专员，type等于1时有效
     * member.userid 是 服务专员的userid
     * member.wording 否 推荐语
     * groupchat 否 推荐的客户群，type等于2时有效
     * groupchat.chat_id 是 客户群id
     * groupchat.wording 否 推荐语
     *
     * 权限说明:
     *
     * 企业需要使用“微信客服”secret所获取的accesstoken来调用（accesstoken如何获取？）
     * 第三方应用需具有“微信客服权限->服务工具->配置「升级服务」”权限
     * 代开发自建应用需具有“微信客服权限->服务工具->配置「升级服务」”权限
     * 要求userid/chatid已配置在微信客服中的“升级服务”中专员服务或客户群服务才可使用API进行设置，否则会返回95021错误码。
     * 要求userid在“客户联系->权限配置->客户联系和客户群"的使用范围内
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
     * 参数 类型 说明
     * errcode int 返回码
     * errmsg string 错误码描述
     */
    public function upgradeService($open_kfid, $external_userid, \Qyweixin\Model\Kf\Customer\UpgradeService $upgradeService)
    {
        $params = $upgradeService->getParams();
        $params['open_kfid'] = $open_kfid;
        $params['external_userid'] = $external_userid;
        $rst = $this->_request->post($this->_url . 'upgrade_service', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 为客户取消推荐
     * 当企业通过 API 为客户指定了专员或客户群后，如果客户已经完成服务升级，或是企业需要取消推荐，则可调用该接口清空之前为客户指定的专员或客户群。清空后，企业微信中的特殊状态提示也会同步消失。
     *
     * 请求方式: POST(HTTPS)
     *
     * 请求地址: https://qyapi.weixin.qq.com/cgi-bin/kf/customer/cancel_upgrade_service?access_token=ACCESS_TOKEN
     *
     * 请求示例:
     *
     * {
     * "open_kfid": "kfxxxxxxxxxxxxxx",
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
     * 企业需要使用“微信客服”secret所获取的accesstoken来调用（accesstoken如何获取？）
     * 第三方应用需具有“微信客服权限->服务工具->配置「升级服务」”权限
     * 代开发自建应用需具有“微信客服权限->服务工具->配置「升级服务」”权限
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
     * 参数 类型 说明
     * errcode int 返回码
     * errmsg string 错误码描述
     */
    public function cancelUpgradeService($open_kfid, $external_userid,)
    {
        $params = array();
        $params['open_kfid'] = $open_kfid;
        $params['external_userid'] = $external_userid;
        $rst = $this->_request->post($this->_url . 'cancel_upgrade_service', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 获取客户基础信息
     * 请求方式: POST(HTTPS)
     *
     * 请求地址: https://qyapi.weixin.qq.com/cgi-bin/kf/customer/batchget?access_token=ACCESS_TOKEN
     *
     * 请求实例:
     *
     * {
     * "external_userid_list": [
     * "wmxxxxxxxxxxxxxxxxxxxxxx",
     * "zhangsan"
     * ],
     * "need_enter_session_context": 0
     * }
     * 参数说明：
     *
     * 参数 是否必须 说明
     * access_token 是 调用接口凭证
     * external_userid_list 是 external_userid列表
     * 可填充个数：1 ~ 100。超过100个需分批调用。
     * need_enter_session_context 否 是否需要返回客户48小时内最后一次进入会话的上下文信息。
     * 0-不返回 1-返回。默认不返回
     *
     *
     * 权限说明:
     *
     * 企业需要使用“微信客服”secret所获取的accesstoken来调用（accesstoken如何获取？）
     * 第三方应用需具有“微信客服权限->获取基础信息”权限
     * 代开发自建应用需具有“微信客服权限->获取基础信息”权限
     *
     *
     * 返回结果:
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "customer_list": [
     * {
     * "external_userid": "wmxxxxxxxxxxxxxxxxxxxxxx",
     * "nickname": "张三",
     * "avatar": "http://xxxxx",
     * "gender": 1,
     * "unionid": "oxasdaosaosdasdasdasd",
     * "enter_session_context": {
     * "scene": "123",
     * "scene_param": "abc",
     * "wechat_channels": {
     * "nickname": "进入会话的视频号名称"
     * }
     * }
     * }
     * ],
     * "invalid_external_userid": [
     * "zhangsan"
     * ]
     * }
     * 参数说明:
     *
     * 参数 类型 说明
     * errcode int 返回码
     * errmsg string 错误码描述
     * customer_list array 返回结果
     * customer_list.external_userid string 微信客户的external_userid
     * customer_list.nickname string 微信昵称
     * customer_list.avatar string 微信头像。第三方不可获取
     * customer_list.gender int 性别
     * customer_list.unionid string unionid，需要绑定微信开发者帐号才能获取到，查看绑定方法。第三方不可获取
     * customer_list.enter_session_context obj 48小时内最后一次进入会话的上下文信息。
     * 请求的need_enter_session_context参数设置为1才返回
     * customer_list.enter_session_context.scene string 进入会话的场景值，获取客服帐号链接开发者自定义的场景值
     * customer_list.enter_session_context.scene_param string 进入会话的自定义参数，获取客服帐号链接返回的url，开发者按规范拼接的scene_param参数
     * customer_list.enter_session_context.wechat_channels obj 进入会话的视频号信息，从视频号进入会话才有值
     * customer_list.enter_session_context.wechat_channels.nickname string 视频号名称
     * 如何获取微信客户的unionid
     * 在企业微信管理后台“应用管理-微信客服-通过API管理微信客服”处，点击“绑定”去到微信公众平台进行授权，支持绑定公众号和小程序（需要同时绑定微信开放平台）；绑定的公众号或小程序主体需与企业微信主体一致，暂且支持绑定一个
     * 绑定完成后，即可通过此接口获取微信客服所对应的微信unionid
     */
    public function batchGet(array $external_userid_list, $need_enter_session_context)
    {
        $params = array();
        $params['external_userid_list'] = $external_userid_list;
        $params['need_enter_session_context'] = $need_enter_session_context;
        $rst = $this->_request->post($this->_url . 'batchget', $params);
        return $this->_client->rst($rst);
    }
}
