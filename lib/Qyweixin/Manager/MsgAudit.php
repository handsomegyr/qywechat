<?php

namespace Qyweixin\Manager;

use Qyweixin\Client;

/**
 * 会话内容存档管理
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class MsgAudit
{

    // 接口地址
    private $_url = 'https://qyapi.weixin.qq.com/cgi-bin/msgaudit/';

    private $_client;

    private $_request;

    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 获取会话内容存档开启成员列表
     * 企业可通过此接口，获取企业开启会话内容存档的成员列表
     *
     * 请求方式：GET（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/msgaudit/get_permit_user_list?access_token=ACCESS_TOKEN
     *
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * 权限说明：
     * 企业需要使用会话内容存档应用secret所获取的accesstoken来调用（accesstoken如何获取？）；
     *
     * 返回结果：
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "ids":[
     * "userid_111",
     * "userid_222",
     * "userid_333",
     * ],
     * }
     * 返回字段说明：
     *
     * 字段名 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     * ids 设置在开启范围内的成员的userid列表
     * 注：开启范围可设置为具体成员、部门、标签。通过此接口拉取成员列表，会将部门、标签进行打散处理，获取部门、标签范围内的全部成员。最终以成员userid的形式返回。
     */
    public function getPermitUserList()
    {
        $params = array();
        $rst = $this->_request->get($this->_url . 'get_permit_user_list', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 获取会话同意情况
     * 企业可通过下述接口，获取会话中外部成员的同意情况
     *
     * 单聊请求地址：https://qyapi.weixin.qq.com/cgi-bin/msgaudit/check_single_agree?access_token=ACCESS_TOKEN
     *
     * 请求方式：POST（HTTPS）
     *
     * 请求示例：
     *
     * {
     * "info":[
     * {"userid":"XuJinSheng","exteranalopenid":"wmeDKaCQAAGd9oGiQWxVsAKwV2HxNAAA"},{"userid":"XuJinSheng","exteranalopenid":"wmeDKaCQAAIQ_p7ACn_jpLVBJSGocAAA"},
     * {"userid":"XuJinSheng","exteranalopenid":"wmeDKaCQAAPE_p7ABnxkpLBBJSGocAAA"}
     * ]
     * }
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * info 是 待查询的会话信息，数组
     * userid 是 内部成员的userid
     * exteranalopenid 是 外部成员的externalopenid
     * 此接口可以批量查询userid与externalopenid之间的会话同意情况。
     *
     * 权限说明：
     * 企业需要使用会话内容存档应用secret所获取的accesstoken来调用（accesstoken如何获取？）；
     *
     * 返回结果：
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "agreeinfo" : [
     * {
     * "status_change_time" : 1562766651,
     * "userid" : "XuJinSheng",
     * "exteranalopenid" : "wmeDKaCPAAGdvxciQWxVsAKwV2HxNAAA",
     * "agree_status":"Agree",
     * },
     * {
     * "status_change_time" : 1562766651,
     * "userid" : "XuJinSheng",
     * "exteranalopenid" : "wmeDKaCQAAIQ_p7ACnxksfeBJSGocAAA",
     * "agree_status":"Disagree",
     * },
     * {
     * "status_change_time" : 1562766651,
     * "userid" : "XuJinSheng",
     * "exteranalopenid" : "wmeDKaCwAAIQ_p7ACnxckLBBJSGocAAA",
     * "agree_status":"Default_Agree",
     * },
     * ],
     * }
     * 返回字段说明：
     *
     * 字段名 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     * agreeinfo 同意情况
     * agree_status 同意:”Agree”，不同意:”Disagree”，默认同意:”Default_Agree”
     * status_change_time 同意状态改变的具体时间，utc时间
     */
    public function checkSingleAgree(array $info)
    {
        $params = array();
        $params['info'] = $info;
        $rst = $this->_request->post($this->_url . 'check_single_agree', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 群聊请求地址：https://qyapi.weixin.qq.com/cgi-bin/msgaudit/check_room_agree?access_token=ACCESS_TOKEN
     *
     * 请求方式：POST（HTTPS）
     *
     * 请求示例：
     *
     * {
     * "roomid":"wrjc7bDwAASxc8tZvBErFE02BtPWyAAA",
     * }
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * roomid 是 待查询的roomid
     * 此接口可以查询对应roomid里面所有外企业的外部联系人的同意情况
     *
     * 权限说明：
     * 企业需要使用会话内容存档应用secret所获取的accesstoken来调用（accesstoken如何获取？）；
     *
     * 返回结果：
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "agreeinfo" : [
     * {
     * "status_change_time" : 1562766651,
     * "exteranalopenid" : "wmeDKaCQAAGdtHdiQWxVadfwV2HxNAAA",
     * "agree_status":"Agree",
     * },
     * {
     * "status_change_time" : 1562766651,
     * "exteranalopenid" : "wmeDKaCQAAIQ_p9ACyiopLBBJSGocAAA",
     * "agree_status":"Disagree",
     * },
     * {
     * "status_change_time" : 1562766651,
     * "exteranalopenid" : "wmeDKaCQAAIQ_p9ACnxacyBBJSGocAAA",
     * "agree_status":"Default_Agree",
     * },
     * ],
     * }
     * 返回字段说明：
     *
     * 字段名 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     * agreeinfo 同意情况
     * agree_status 同意:”Agree”，不同意:”Disagree”，默认同意:”Default_Agree”
     * status_change_time 同意状态改变的具体时间，utc时间
     * exteranalopenid 群内外部联系人的externalopenid
     */
    public function checkRoomAgree($roomid)
    {
        $params = array();
        $params['roomid'] = $roomid;
        $rst = $this->_request->post($this->_url . 'check_room_agree', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 获取机器人信息
     * 通过robot_id获取机器人的名称和创建者
     *
     * 请求方式：GET（HTTPS）
     *
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/msgaudit/get_robot_info?access_token=ACCESS_TOKEN&robot_id=ROBOT_ID
     *
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * robot_id 是 机器人ID。
     * 权限说明：
     *
     * 只能通过会话存档的access_token获取。
     *
     * 返回结果：
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "data": {
     * "robot_id": "wbxxxxxxxxxxxxxxxxxxxxxxxx",
     * "name": "机器人A",
     * "creator_userid": "zhangsan"
     * }
     * 参数说明：
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     * robot_id 机器人ID
     * name 机器人名称
     * creator_userid 机器人创建者的UserID
     */
    public function getRobotInfo($robot_id)
    {
        $params = array();
        $params['robot_id'] = $robot_id;
        $rst = $this->_request->get($this->_url . 'get_robot_info', $params);
        return $this->_client->rst($rst);
    }
}
