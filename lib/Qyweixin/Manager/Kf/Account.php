<?php

namespace Qyweixin\Manager\Kf;

use Qyweixin\Client;

/**
 * 客服帐号管理
 * https://developer.work.weixin.qq.com/document/path/94688
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class Account
{

    // 接口地址
    private $_url = 'https://qyapi.weixin.qq.com/cgi-bin/kf/account/';
    private $_client;
    private $_request;
    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 添加客服帐号
     * 添加客服帐号，并可设置客服名称和头像。目前一家企业最多可添加10个客服帐号。
     *
     * 请求方式: POST(HTTPS)
     *
     * 请求地址: https://qyapi.weixin.qq.com/cgi-bin/kf/account/add?access_token=ACCESS_TOKEN
     *
     * 请求示例
     *
     * {
     * "name": "新建的客服帐号",
     * "media_id": "294DpAog3YA5b9rTK4PjjfRfYLO0L5qpDHAJIzhhQ2jAEWjb9i661Q4lk8oFnPtmj"
     * }
     * 参数说明:
     *
     * 参数 必须 类型 说明
     * access_token 是 string 调用接口凭证
     * name 是 string 客服名称
     * 不多于16个字符
     * media_id 是 string 客服头像临时素材。可以调用上传临时素材接口获取。
     * 不多于128个字节
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
     * "open_kfid": "wkAJ2GCAAAZSfhHCt7IFSvLKtMPxyJTw"
     * }
     * 参数说明:
     *
     * 参数 类型 说明
     * errcode int32 返回码
     * errmsg string 错误码描述
     * open_kfid string 新创建的客服帐号ID
     */
    public function add($name, $media_id)
    {
        $params = array();
        $params['name'] = $name;
        $params['media_id'] = $media_id;

        $rst = $this->_request->post($this->_url . 'add', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 删除客服帐号
     * 删除已有的客服帐号
     *
     * 请求方式: POST(HTTPS)
     *
     * 请求地址: https://qyapi.weixin.qq.com/cgi-bin/kf/account/del?access_token=ACCESS_TOKEN
     *
     * 请求示例
     *
     * {
     * "open_kfid": "wkAJ2GCAAAZSfhHCt7IFSvLKtMPxyJTw"
     * }
     * 参数说明:
     *
     * 参数 必须 类型 说明
     * access_token 是 string 调用接口凭证
     * open_kfid 是 string 客服帐号ID。
     * 不多于64字节
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
     * "errmsg": "ok"
     * }
     * 参数说明:
     *
     * 参数 类型 说明
     * errcode int32 返回码
     * errmsg string 错误码描述
     */
    public function delete($open_kfid)
    {
        $params = array();
        $params['open_kfid'] = $open_kfid;
        $rst = $this->_request->post($this->_url . 'del', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 修改客服帐号
     * 修改已有的客服帐号，可修改客服名称和头像。
     *
     * 请求方式: POST(HTTPS)
     *
     * 请求地址: https://qyapi.weixin.qq.com/cgi-bin/kf/account/update?access_token=ACCESS_TOKEN
     *
     * 请求示例
     *
     * {
     * "open_kfid": "wkAJ2GCAAAZSfhHCt7IFSvLKtMPxyJTw",
     * "name": "修改客服名",
     * "media_id": "294DpAog3YA5b9rTK4PjjfRfYLO0L5qpDHAJIzhhQ2jAEWjb9i661Q4lk8oFnPtmj"
     * }
     * 参数说明:
     *
     * 参数 必须 类型 说明
     * access_token 是 string 调用接口凭证
     * open_kfid 是 string 要修改的客服帐号ID。
     * 不多于64字节
     * name 否 string 新的客服名称，如不需要修改可不填。
     * 不多于16个字符
     * media_id 否 string 新的客服头像临时素材，如不需要修改可不填。可以调用上传临时素材接口获取。
     * 不多于128个字节
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
     * "errmsg": "ok"
     * }
     * 参数说明:
     *
     * 参数 类型 说明
     * errcode int32 返回码
     * errmsg string 错误码描述
     */
    public function update($open_kfid, $name, $media_id)
    {
        $params = array();
        $params['open_kfid'] = $open_kfid;
        $params['name'] = $name;
        $params['media_id'] = $media_id;
        $rst = $this->_request->post($this->_url . 'update', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 获取客服帐号列表
     * 获取客服帐号列表，包括所有的客服帐号的客服ID、名称和头像。
     *
     * 请求方式: GET(HTTPS)
     *
     * 请求地址: https://qyapi.weixin.qq.com/cgi-bin/kf/account/list?access_token=ACCESS_TOKEN
    
     * 参数说明:
     *
     * 参数 必须 类型 说明
     * access_token 是 string 调用接口凭证
     * 权限说明:
     *
     * 企业需要使用“微信客服”secret所获取的accesstoken来调用（accesstoken如何获取？）
     * 第三方应用需具有“微信客服->获取基础信息”权限
     * 代开发自建应用需具有“微信客服->获取基础信息”权限
     *
     *
     * 返回结果:
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "account_list": [
     * {
     * "open_kfid": "wkAJ2GCAAASSm4_FhToWMFea0xAFfd3Q",
     * "name": "咨询客服",
     * "avatar": "https://wework.qpic.cn/wwhead/duc2TvpEgSSjibPZlNR6chpx9W3dtd9Ogp8XEmSNKGa6uufMWn2239HUPuwIFoYYZ7Ph580FPvo8/0"
     * }
     * ]
     * }
     * 参数说明:
     *
     * 参数 类型 说明
     * errcode int32 返回码
     * errmsg string 错误码描述
     * account_list obj[] 帐号信息列表
     * account_list.open_kfid string 客服帐号ID
     * account_list.name string 客服名称
     * account_list.avatar string 客服头像URL
     */
    public function getList()
    {
        $params = array();
        $rst = $this->_request->get($this->_url . 'list', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 获取客服帐号链接
     * 企业可通过此接口获取带有不同参数的客服链接，不同客服帐号对应不同的客服链接。获取后，企业可将链接嵌入到网页等场景中，微信用户点击链接即可向对应的客服帐号发起咨询。企业可依据参数来识别用户的咨询来源等。
     
     * 请求方式： POST（HTTPS）
     *
     * 请求地址： https://qyapi.weixin.qq.com/cgi-bin/kf/add_contact_way?access_token=ACCESS_TOKEN
     *
     * 请求示例：
     *
     * {
     * "open_kfid": "OPEN_KFID",
     * "scene": "12345"
     * }
     * 参数说明：
     *
     * 参数 必须 类型 说明
     * access_token 是 string 调用接口凭证
     * open_kfid 是 string 客服帐号ID
     * scene 否 string 场景值，字符串类型，由开发者自定义。
     * 不多于32字节
     * 字符串取值范围(正则表达式)：[0-9a-zA-Z_-]*
     * 1. 若scene非空，返回的客服链接开发者可拼接scene_param=SCENE_PARAM参数使用，用户进入会话事件会将SCENE_PARAM原样返回。其中SCENE_PARAM需要urlencode，且长度不能超过128字节。
     * 如 https://work.weixin.qq.com/kf/kfcbf8f8d07ac7215f?enc_scene=ENCGFSDF567DF&scene_param=a%3D1%26b%3D2
     * 2. 历史调用接口返回的客服链接（包含encScene=XXX参数），不支持scene_param参数。
     * 3. 返回的客服链接，不能修改或复制参数到其他链接使用。否则进入会话事件参数校验不通过，导致无法回调。
     * 权限说明:
     *
     * 企业需要使用“微信客服”secret所获取的accesstoken来调用（accesstoken如何获取？）
     * 第三方应用需具有“微信客服->获取基础信息”权限
     * 代开发自建应用需具有“微信客服->获取基础信息”权限
     *
     *
     * 返回结果：
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "url":"https://work.weixin.qq.com/kf/kfcbf8f8d07ac7215f?enc_scene=ENCGFSDF567DF"
     * }
     * 参数说明：
     *
     * 参数 类型 说明
     * errcode int32 返回码
     * errmsg string 对返回码的文本描述内容
     * url string 客服链接，开发者可将该链接嵌入到H5页面中，用户点击链接即可向对应的微信客服帐号发起咨询。开发者也可根据该url自行生成需要的二维码图片
     */
    public function addContactWay($open_kfid, $scene)
    {
        $params = array();
        $params['open_kfid'] = $open_kfid;
        $params['scene'] = $scene;
        $rst = $this->_request->post('https://qyapi.weixin.qq.com/cgi-bin/kf/add_contact_way', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 获取「客户数据统计」企业汇总数据
     * 通过此接口，可以获取咨询会话数、咨询客户数等企业汇总统计数据
     * 请求方式: POST(HTTPS)
     *
     * 请求地址: https://qyapi.weixin.qq.com/cgi-bin/kf/get_corp_statistic?access_token=ACCESS_TOKEN
     *
     * 请求示例
     *
     * {
     * "open_kfid": "OPEN_KFID",
     * "start_time": 1645545600,
     * "end_time": 1645632000
     * }
     * 参数说明:
     *
     * 参数 必须 类型 说明
     * access_token 是 string 调用接口凭证
     * open_kfid 否 string 客服帐号ID。不传入时返回的数据为企业维度汇总的数据
     * start_time 是 uint32 起始日期的时间戳，填这一天的0时0分0秒（否则系统自动处理为当天的0分0秒）。取值范围：昨天至前180天
     * end_time 是 uint32 结束日期的时间戳，填这一天的0时0分0秒（否则系统自动处理为当天的0分0秒）。取值范围：昨天至前180天
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
     * "stat_time" : 1645545600,
     * "statistic" : {
     * "session_cnt" : 2,
     * "customer_cnt" : 1,
     * "customer_msg_cnt" : 6,
     * "upgrade_service_customer_cnt" : 0,
     * "ai_session_reply_cnt" : 1,
     * "ai_transfer_rate" : 1,
     * "ai_knowledge_hit_rate" : 0,
     * },
     * },
     * {
     * "stat_time" : 1645632000,
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
     * statistic_list.statistic.session_cnt uint64 咨询会话数。客户发过消息并分配给接待人员或智能助手的客服会话数，转接不会产生新的会话
     * statistic_list.statistic.customer_cnt uint64 咨询客户数。在会话中发送过消息的客户数量，若客户多次咨询只计算一个客户
     * statistic_list.statistic.customer_msg_cnt uint64 咨询消息总数。客户在会话中发送的消息的数量
     * statistic_list.statistic.upgrade_service_customer_cnt uint64 升级服务客户数。通过「升级服务」功能成功添加专员或加入客户群的客户数，若同一个客户添加多个专员或客户群，只计算一个客户。在2022年3月10日以后才会有对应统计数据
     * statistic_list.statistic.ai_session_reply_cnt uint64 智能回复会话数。客户发过消息并分配给智能助手的咨询会话数。通过API发消息或者开启智能回复功能会将客户分配给智能助手
     * statistic_list.statistic.ai_transfer_rate float 转人工率。一个自然日内，客户给智能助手发消息的会话中，转人工的会话的占比。
     * statistic_list.statistic.ai_knowledge_hit_rate float 知识命中率。一个自然日内，客户给智能助手发送的消息中，命中知识库的占比。只有在开启了智能回复原生功能并配置了知识库的情况下，才会产生该项统计数据。当api托管了会话分配，智能回复原生功能失效。若不返回，代表没有向配置知识库的智能接待助手发送消息，该项无法计算
     */
    public function getCorpStatistic($open_kfid, int $start_time, int $end_time)
    {
        $params = array();
        if(!empty($open_kfid)){
            $params['open_kfid'] = $open_kfid;
        }
        $params['start_time'] = $start_time;
        $params['end_time'] = $end_time;

        $rst = $this->_request->post('https://qyapi.weixin.qq.com/cgi-bin/kf/get_corp_statistic', $params);
        return $this->_client->rst($rst);
    }
}
