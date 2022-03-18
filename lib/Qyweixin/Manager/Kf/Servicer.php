<?php

namespace Qyweixin\Manager\Kf;

use Qyweixin\Client;

/**
 * 接待人员管理
 * https://developer.work.weixin.qq.com/document/path/94695
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class Servicer
{

    // 接口地址
    private $_url = 'https://qyapi.weixin.qq.com/cgi-bin/kf/servicer/';
    private $_client;
    private $_request;
    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 添加接待人员
     * 添加指定客服帐号的接待人员，每个客服帐号目前最多可添加500个接待人员。
     *
     * 请求方式: POST(HTTPS)
     *
     * 请求地址: https://qyapi.weixin.qq.com/cgi-bin/kf/servicer/add?access_token=ACCESS_TOKEN
     *
     * 请求实例:
     *
     * {
     * "open_kfid": "kfxxxxxxxxxxxxxx",
     * "userid_list": ["zhangsan", "lisi"]
     * }
     * 参数说明：
     *
     * 参数 是否必须 说明
     * access_token 是 调用接口凭证
     * open_kfid 是 客服帐号ID
     * userid_list 是 接待人员userid列表。第三方应用填密文userid，即open_userid
     * 可填充个数：1 ~ 100。超过100个需分批调用。
     *
     * 权限说明:
     *
     * 企业需要使用“微信客服”secret所获取的accesstoken来调用（accesstoken如何获取？），同时开启“会话消息管理”开关
     * 第三方应用需具有“微信客服->管理帐号、分配会话和收发消息”权限。仅可将应用可见范围内的成员添加为接待人员
     * 代开发自建应用需具有“微信客服->管理帐号、分配会话和收发消息”权限。仅可将应用可见范围内的成员添加为接待人员
     *
     *
     * 返回结果:
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "result_list": [
     * {
     * "userid": "zhangsan",
     * "errcode": 0,
     * "errmsg": "success"
     * },
     * {
     * "userid": "lisi",
     * "errcode": 0,
     * "errmsg": "ignored"
     * }
     * ]
     * }
     * 参数说明:
     *
     * 参数 类型 说明
     * errcode int 返回码
     * errmsg string 错误码描述
     * result_list arrary 操作结果
     * result_list.userid string 接待人员的userid
     * result_list.errcode int 该userid的添加结果
     * result_list.errmsg string 结果信息
     */
    public function add($open_kfid, array $userid_list)
    {
        $params = array();
        $params['open_kfid'] = $open_kfid;
        $params['userid_list'] = $userid_list;
        $rst = $this->_request->post($this->_url . 'add', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 获取接待人员列表
     * 获取某个客服帐号的接待人员列表
     *
     * 请求方式: GET(HTTPS)
     *
     * 请求地址: https://qyapi.weixin.qq.com/cgi-bin/kf/servicer/list?access_token=ACCESS_TOKEN&open_kfid=XXX
     *
     * 参数说明：
     *
     * 参数 是否必须 说明
     * access_token 是 调用接口凭证
     * open_kfid 是 客服帐号ID
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
     * "servicer_list": [
     * {
     * "userid": "zhangsan",
     * "status": 0
     * },
     * {
     * "userid": "lisi",
     * "status": 1
     * }
     * ]
     * }
     * 参数说明:
     *
     * 参数 类型 说明
     * errcode int 返回码
     * errmsg string 错误码描述
     * servicer_list arrary 客服帐号的接待人员列表
     * servicer_list.userid string 接待人员的userid。第三方应用获取到的为密文userid，即open_userid
     * servicer_list.status int 接待人员的接待状态。0:接待中,1:停止接待。第三方应用需具有“管理帐号、分配会话和收发消息”权限才可获取
     */
    public function getList($open_kfid)
    {
        $params = array();
        $params['open_kfid'] = $open_kfid;
        $rst = $this->_request->get($this->_url . 'list', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 删除接待人员
     * 从客服帐号删除接待人员
     *
     * 请求方式: POST(HTTPS)
     *
     * 请求地址: https://qyapi.weixin.qq.com/cgi-bin/kf/servicer/del?access_token=ACCESS_TOKEN
     *
     * 请求实例:
     *
     * {
     * "open_kfid": "kfxxxxxxxxxxxxxx",
     * "userid_list": ["zhangsan", "lisi"]
     * }
     * 参数说明：
     *
     * 参数 是否必须 说明
     * access_token 是 调用接口凭证
     * open_kfid 是 客服帐号ID
     * userid_list 是 接待人员userid列表。第三方应用填密文userid，即open_userid
     * 可填充个数：1 ~ 100。超过100个需分批调用。
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
     * "result_list": [
     * {
     * "userid": "zhangsan",
     * "errcode": 0,
     * "errmsg": "success"
     * },
     * {
     * "userid": "lisi",
     * "errcode": 0,
     * "errmsg": "ignored"
     * }
     * ]
     * }
     * 参数说明:
     *
     * 参数 类型 说明
     * errcode int 返回码
     * errmsg string 错误码描述
     * result_list arrary 操作结果
     * result_list.userid string 接待人员的userid
     * result_list.errcode int 该userid的删除结果
     * result_list.errmsg string 结果信息
     */
    public function delete($open_kfid, array $userid_list)
    {
        $params = array();
        $params['open_kfid'] = $open_kfid;
        $params['userid_list'] = $userid_list;
        $rst = $this->_request->post($this->_url . 'del', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 获取「客户数据统计」接待人员明细数据
     * 通过此接口，可获取接入人工会话数、咨询会话数等与接待人员相关的统计信息
     * 请求方式: POST(HTTPS)
     *
     * 请求地址: https://qyapi.weixin.qq.com/cgi-bin/kf/get_servicer_statistic?access_token=ACCESS_TOKEN
     *
     * 请求示例
     *
     * {
     * "open_kfid": "OPEN_KFID",
     * "servicer_userid":"zhangsan",
     * "start_time": 1645545600,
     * "end_time": 1645632000
     * }
     * 参数说明:
     *
     * 参数 必须 类型 说明
     * access_token 是 string 调用接口凭证
     * open_kfid 否 string 客服帐号ID
     * servicer_userid 否 string 接待人员的userid。第三方应用为密文userid，即open_userid
     * start_time 是 uint32 起始日期的时间戳，填当天的0时0分0秒（否则系统自动处理为当天的0分0秒）。取值范围：昨天至前180天
     * end_time 是 uint32 结束日期的时间戳，填当天的0时0分0秒（否则系统自动处理为当天的0分0秒）。取值范围：昨天至前180天
     * open_kfid和servicer_userid均为非必填参数:
     * 1. 不指定open_kfid，指定servicer_userid，返回单个接待人员的汇总数据；
     * 2. 指定open_kfid，不指定servicer_userid，返回客服帐号维度汇总数据；
     * 3. 不指定open_kfid，不指定servicer_userid，返回企业维度汇总数据；
     * 4. 指定open_kfid，指定servicer_userid，返回该接待人员在此客服账号下的数据。
     * 查询时间区间[start_time, end_time]为闭区间，最大查询跨度为31天，用户最多可获取最近180天内的数据。当天的数据需要等到第二天才能获取，建议在第二天早上六点以后再调用此接口获取前一天的数据
     * 当传入的时间不为0点时，会向下取整，如传入1554296400(Wed Apr 3 21:00:00 CST 2019)会被自动转换为1554220800（Wed Apr 3 00:00:00 CST 2019）;
     * 开启API或授权第三方应用管理会话，没有2022年3月11日以前的统计数据
     *
     *
     * 权限说明:
     *
     * 企业需要使用“微信客服”secret所获取的accesstoken来调用（accesstoken如何获取？）
     * 第三方应用需具有“微信客服权限->服务工具->获取客服数据统计”权限
     * 代开发自建应用需具有“微信客服权限->服务工具->获取客服数据统计”权限
     *
     *
     * 返回结果:
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "statistic_list" : [
     * {
     * "stat_date" : 1645545600,
     * "statistic" : {
     * "session_cnt" : 1,
     * "customer_cnt" : 1,
     * "customer_msg_cnt" : 1,
     * "reply_rate" : 1,
     * "first_reply_average_sec" : 17,
     * "satisfaction_investgate_cnt" : 1,
     * "satisfaction_participation_rate" : 1,
     * "satisfied_rate" : 1,
     * "middling_rate" : 0,
     * "dissatisfied_rate" : 0,
     * "upgrade_service_customer_cnt" : 0,
     * "upgrade_service_member_invite_cnt" : 0,
     * "upgrade_service_member_customer_cnt" : 0,
     * "upgrade_service_groupchat_invite_cnt" : 0,
     * "upgrade_service_groupchat_customer_cnt" : 0
     * }
     * },
     * {
     * "stat_date" : 1645632000,
     * "statistic" : {
     * ...
     * }
     * }
     * ]
     * }
     * 参数说明:
     *
     * 参数 类型 说明
     * errcode int32 返回码
     * errmsg string 错误码描述
     * statistic_list obj 统计数据列表
     * statistic_list.stat_time uint32 数据统计日期，为当日0点的时间戳
     * statistic_list.statistic obj 一天的统计数据。若当天未产生任何下列统计数据或统计数据还未计算完成则不会返回此项
     * statistic_list.statistic.session_cnt uint64 接入人工会话数。客户发过消息并分配给接待人员的咨询会话数
     * statistic_list.statistic.customer_cnt uint64 咨询客户数。在会话中发送过消息的客户数量，若客户多次咨询只计算一个客户
     * statistic_list.statistic.reply_rate float 人工回复率。一个自然日内，客户给接待人员发消息的会话中，接待人员回复了的会话的占比。若数据项不返回，代表没有给接待人员发送消息的客户，此项无法计算。
     * statistic_list.statistic.first_reply_average_sec uint64 平均首次响应时长，单位：秒。一个自然日内，客户给接待人员发送的第一条消息至接待人员回复之间的时长，为首次响应时长。所有的首次回复总时长/已回复的咨询会话数，即为平均首次响应时长 。若数据项不返回，代表没有给接待人员发送消息的客户，此项无法计算
     * statistic_list.statistic.satisfaction_investgate_cnt uint64 满意度评价发送数。当api托管了会话分配，满意度原生功能失效，满意度评价发送数为0
     * statistic_list.statistic.satisfaction_participation_rate uint64 满意度参评率 。当api托管了会话分配，满意度原生功能失效。若数据项不返回，代表没有发送满意度评价，此项无法计算
     * statistic_list.statistic.satisfied_rate float “满意”评价占比 。在客户参评的满意度评价中，评价是“满意”的占比。当api托管了会话分配，满意度原生功能失效。若数据项不返回，代表没有客户参评的满意度评价，此项无法计算
     * statistic_list.statistic.middling_rate float “一般”评价占比 。在客户参评的满意度评价中，评价是“一般”的占比。当api托管了会话分配，满意度原生功能失效。若数据项不返回，代表没有客户参评的满意度评价，此项无法计算
     * statistic_list.statistic.dissatisfied_rate float “不满意”评价占比。在客户参评的满意度评价中，评价是“不满意”的占比。当api托管了会话分配，满意度原生功能失效。若数据项不返回，代表没有客户参评的满意度评价，此项无法计算
     * statistic_list.statistic.upgrade_service_customer_cnt uint64 升级服务客户数。通过「升级服务」功能成功添加专员或加入客户群的客户数，若同一个客户添加多个专员或客户群，只计算一个客户。在2022年3月10日以后才会有对应统计数据
     * statistic_list.statistic.upgrade_service_member_invite_cnt uint64 专员服务邀请数。接待人员通过「升级服务-专员服务」向客户发送服务专员名片的次数。在2022年3月10日以后才会有对应统计数据
     * statistic_list.statistic.upgrade_service_member_customer_cnt uint64 添加专员的客户数 。客户成功添加专员为好友的数量，若同一个客户添加多个专员，则计算多个客户数。在2022年3月10日以后才会有对应统计数据
     * statistic_list.statistic.upgrade_service_groupchat_invite_cnt uint64 客户群服务邀请数。接待人员通过「升级服务-客户群服务」向客户发送客户群二维码的次数。在2022年3月10日以后才会有对应统计数据
     * statistic_list.statistic.upgrade_service_groupchat_customer_cnt uint64 加入客户群的客户数。客户成功加入客户群的数量，若同一个客户加多个客户群，则计算多个客户数。在2022年3月10日以后才会有对应统计数据
     */
    public function getServicerStatistic($open_kfid, $servicer_userid, int $start_time, int $end_time)
    {
        $params = array();
        $params['open_kfid'] = $open_kfid;
        $params['servicer_userid'] = $servicer_userid;
        $params['start_time'] = $start_time;
        $params['end_time'] = $end_time;
        $rst = $this->_request->post('https://qyapi.weixin.qq.com/cgi-bin/kf/get_servicer_statistic', $params);
        return $this->_client->rst($rst);
    }
}
