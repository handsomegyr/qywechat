<?php

namespace Qyweixin\Manager\Kf;

use Qyweixin\Client;

/**
 * 发送消息管理
 * https://developer.work.weixin.qq.com/document/path/94700
 * https://developer.work.weixin.qq.com/document/path/94910
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class Msg
{

    // 接口地址
    private $_url = 'https://qyapi.weixin.qq.com/cgi-bin/kf/';
    private $_client;
    private $_request;
    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 发送消息
     * 概述
     * 当微信客户处于“新接入待处理”或“由智能助手接待”状态下，可调用该接口给用户发送消息。
     * 注意仅当微信客户在主动发送消息给客服后的48小时内，企业可发送消息给客户，最多可发送5条消息；若用户继续发送消息，企业可再次下发消息。
     * 支持发送消息类型：文本、图片、语音、视频、文件、图文、小程序、菜单消息、地理位置。
     * 目前该接口允许下发消息条数和下发时限如下：
     *
     * 用户动作 允许下发条数限制 下发时限
     * 用户发送消息 5条 48 小时
     * 接口定义
     * 请求方式: POST(HTTPS)
     *
     * 请求地址: https://qyapi.weixin.qq.com/cgi-bin/kf/send_msg?access_token=ACCESS_TOKEN
     *
     * 参数说明：
     *
     * 参数 是否必须 说明
     * access_token 是 调用接口凭证
     *
     * 权限说明:
     *
     * 企业需要使用“微信客服”secret所获取的accesstoken来调用（accesstoken如何获取？），同时开启“会话消息管理”开关
     * 第三方应用需具有“微信客服->管理帐号、分配会话和收发消息”权限
     * 代开发自建应用需具有“微信客服->管理帐号、分配会话和收发消息”权限
     *
     *
     * 返回结果:
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "msgid": "MSG_ID"
     * }
     * 参数说明:
     *
     * 参数 类型 说明
     * errcode int32 返回码
     * errmsg string 错误码描述
     * msgid string 消息ID。如果请求参数指定了msgid，则原样返回，否则系统自动生成并返回。若指定msgid，开发者需确保客服账号内唯一，否则接口返回错误。
     * 不多于32字节
     * 字符串取值范围(正则表达式)：[0-9a-zA-Z_-]*
     */
    public function sendMsg($touser, $open_kfid, \Qyweixin\Model\Kf\Msg\MsgBase $msg)
    {
        $params = $msg->getParams();
        $params['touser'] = $touser;
        $params['open_kfid'] = $open_kfid;
        $rst = $this->_request->post($this->_url . 'send_msg', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 发送欢迎语等事件响应消息
     * 概述
     * 当特定的事件回调消息包含code字段，或通过接口变更到特定的会话状态，会返回code字段。
     * 开发者可以此code为凭证，调用该接口给用户发送相应事件场景下的消息，如客服欢迎语、客服提示语和会话结束语等。
     * 除"用户进入会话事件"以外，响应消息仅支持会话处于获取该code的会话状态时发送，如将会话转入待接入池时获得的code仅能在会话状态为”待接入池排队中“时发送。
     *
     * 目前支持的事件场景和相关约束如下：
     *
     * 事件场景 允许下发条数 code有效期 支持的消息类型 获取code途径
     * 用户进入会话，用于发送客服欢迎语 1条 20秒 文本、菜单 事件回调
     * 进入接待池，用于发送排队提示语等 1条 48小时 文本 转接会话接口
     * 从接待池接入会话，用于发送非工作时间的提示语或超时未回复的提示语等 1条 48小时 文本 事件回调、转接会话接口
     * 结束会话，用于发送结束会话提示语或满意度评价等 1条 20秒 文本、菜单 事件回调、转接会话接口
     *
     *
     * 接口定义
     * 请求方式: POST(HTTPS)
     *
     * 请求地址: https://qyapi.weixin.qq.com/cgi-bin/kf/send_msg_on_event?access_token=ACCESS_TOKEN
     *
     * 请求示例
     *
     * {
     * "code": "CODE",
     * "msgid": "MSG_ID",
     * "msgtype": "MSG_TYPE"
     * }
     * 参数说明：
     *
     * 参数 是否必须 类型 说明
     * access_token 是 string 调用接口凭证
     * code 是 string 事件响应消息对应的code。通过事件回调下发，仅可使用一次。
     * msgid 否 string 消息ID。如果请求参数指定了msgid，则原样返回，否则系统自动生成并返回。
     * 不多于32字节
     * 字符串取值范围(正则表达式)：[0-9a-zA-Z_-]*
     * msgtype 是 string 消息类型。对不同的msgtype，有相应的结构描述，详见消息类型
     * 「进入会话事件」响应消息：
     * 如果满足通过API下发欢迎语条件（条件为：用户在过去48小时里未收过欢迎语，且未向客服发过消息），则用户进入会话事件会额外返回一个welcome_code，开发者以此为凭据调用接口（填到该接口code参数），即可向客户发送客服欢迎语。
     *
     *
     * 权限说明:
     *
     * 企业需要使用“微信客服”secret所获取的accesstoken来调用（accesstoken如何获取？），同时开启“会话消息管理”开关
     * 第三方应用需具有“微信客服->管理帐号、分配会话和收发消息”权限
     * 代开发自建应用需具有“微信客服->管理帐号、分配会话和收发消息”权限
     *
     *
     * 返回结果:
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "msgid": "MSG_ID"
     * }
     * 参数说明:
     *
     * 参数 类型 说明
     * errcode int32 返回码
     * errmsg string 错误码描述
     * msgid string 消息ID
     */
    public function sendMsgOnEvent($code, \Qyweixin\Model\Kf\Msg\MsgBase $msg)
    {
        $params = $msg->getParams();
        $params['code'] = $code;
        $rst = $this->_request->post($this->_url . 'add', $params);
        return $this->_client->rst($rst);
    }
}
