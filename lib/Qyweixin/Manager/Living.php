<?php

namespace Qyweixin\Manager;

use Qyweixin\Client;

/**
 * 企业直播管理
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class Living
{

    // 接口地址
    private $_url = 'https://qyapi.weixin.qq.com/cgi-bin/living/';

    private $_client;

    private $_request;

    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 获取成员直播ID列表
     * 获取成员直播ID列表
     * 获取成员直播ID列表
     * 通过此接口可以获取指定成员指定时间内的所有直播ID
     *
     * 请求方式：POST（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/living/get_user_livingid?access_token=ACCESS_TOKEN
     *
     * 请求包体：
     *
     * {
     * "userid": "USERID",
     * "begin_time": 1586136317,
     * "end_time": 1586236317,
     * "next_key": "NEXT_KEY",
     * "limit": 100
     * }
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * userid 是 企业成员的userid
     * begin_time 是 开始时间，最长只能拉取180天前数据。只能取到2020-04-23日后数据
     * end_time 是 结束时间，时间跨度不超过180天
     * next_key 否 上一次调用时返回的next_key，初次调用可以填”0”
     * limit 否 每次拉取的数据量，默认值和最大值都为100
     * 权限说明：
     *
     * 只允许「直播」应用调用该接口。
     * 返回结果：
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "ending":1,
     * "next_key": "NEXT_KEY",
     * "livingid_list":[
     * "livingid1",
     * "livingid2"
     * ]
     * }
     * 参数说明：
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     * ending 是否结束。0：表示还有更多数据，需要继续拉取，1：表示已经拉取完所有数据
     * next_key 当前数据最后一个key值，如果下次调用带上该值则从该key值往后拉，用于实现分页拉取
     * livingid_list 直播ID列表
     */
    public function getUserLivingid($userid, $begin_time, $end_time, $next_key = 0, $limit = 100)
    {
        $params = array();
        $params['userid'] = $userid;
        $params['begin_time'] = $begin_time;
        $params['end_time'] = $end_time;
        $params['next_key'] = $next_key;
        $params['limit'] = $limit;
        $rst = $this->_request->post($this->_url . 'get_user_livingid', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 获取直播详情
     * 获取直播详情
     * 获取直播详情
     * 请求方式：GET（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/living/get_living_info?access_token=ACCESS_TOKEN&livingid=LIVINGID
     *
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * livingid 是 直播ID
     * 权限说明：
     *
     * 只允许「直播」应用调用该接口。
     * 返回结果：
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "living_info":{
     * "theme": "直角三角形讲解",
     * "living_start": 1586405229,
     * "living_duration": 1800,
     * "anchor_userid": "zhangsan",
     * "main_department": 1,
     * "viewer_num": 100,
     * "comment_num": 110,
     * "mic_num": 120,
     * "open_replay": 1
     * }
     * }
     * 参数说明：
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     * living_info 直播信息
     * living_info.theme 直播主题
     * living_info.living_start 直播开始时间戳
     * living_info.living_duration 直播时长，单位为秒
     * living_info.anchor_userid 主播的userid
     * main_department 主播所在主部门id
     * viewer_num 观看直播总人数
     * comment_num 评论数
     * mic_num 连麦发言人数
     * open_replay 是否开启回放，1表示开启，0表示关闭
     */
    public function getLivingInfo($livingid)
    {
        $params = array();
        $params['livingid'] = $livingid;
        $rst = $this->_request->get($this->_url . 'update', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 获取看直播统计
     * 获取看直播统计
     * 获取看直播统计
     * 通过该接口可以获取所有观看直播的人员统计
     *
     * 请求方式：POST（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/living/get_watch_stat?access_token=ACCESS_TOKEN
     *
     * 请求包体：
     *
     * {
     * "livingid": "livingid1",
     * "next_key": "NEXT_KEY"
     * }
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * livingid 是 直播的id
     * next_key 否 上一次调用时返回的next_key，初次调用可以填”0”
     * 权限说明：
     *
     * 只允许「直播」应用调用该接口。
     * 返回结果：
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "ending":1,
     * "next_key": "NEXT_KEY",
     * "stat_info":{
     * "users":[
     * {
     * "userid": "userid",
     * "watch_time": 30,
     * "is_comment": 1,
     * "is_mic": 1
     * }
     * ],
     * "external_users":[
     * {
     * "external_userid": "external_userid1",
     * "type": 1,
     * "name": "user name",
     * "watch_time": 30,
     * "is_comment": 1,
     * "type": 1,
     * "is_mic": 1
     * },
     * {
     * "external_userid": "external_userid2",
     * "type": 2,
     * "name": "user_name",
     * "watch_time": 30,
     * "is_comment": 1,
     * "is_mic": 1
     * }
     * ],
     * }
     * }
     * 参数说明：
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     * ending 是否结束。0：表示还有更多数据，需要继续拉取，1：表示已经拉取完所有数据。注意只能根据该字段判断是否已经拉完数据
     * next_key 当前数据最后一个key值，如果下次调用带上该值则从该key值往后拉，用于实现分页拉取
     * stat_info 统计信息列表
     * stat_info.users 观看直播的企业成员列表
     * stat_info.users.userid 企业成员的userid
     * stat_info.users.watch_time 观看时长，单位为秒
     * stat_info.users.is_comment 是否评论，1表示评论，0表示没有评论
     * stat_info.users.is_mic 是否连麦发言 1表示连麦 0表示未连麦
     * stat_info.external_users 观看直播的外部成员列表
     * stat_info.external_users.external_userid 外部成员的userid
     * stat_info.external_users.type 外部成员类型，1表示该外部成员是微信用户，2表示该外部成员是企业微信用户
     * stat_info.external_users.name 外部成员的名称
     * stat_info.external_users.watch_time 观看时长，单位为秒
     * stat_info.external_users.is_comment 是否评论，1表示评论，0表示没有评论
     * stat_info.external_users.is_mic 是否连麦发言
     */
    public function getWatchStat($livingid, $next_key = 0)
    {
        $params = array();
        $params['livingid'] = $livingid;
        $params['next_key'] = $next_key;
        $rst = $this->_request->post($this->_url . 'get_watch_stat', $params);
        return $this->_client->rst($rst);
    }
}
