<?php

namespace Qyweixin\Manager\ExternalContact;

use Qyweixin\Client;

/**
 * 客户朋友圈
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class Moment
{

    // 接口地址
    private $_url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/';
    private $_client;
    private $_request;
    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 获取企业全部的发表列表
     * 企业和第三方应用可通过该接口获取企业全部的发表内容。
     *
     * 请求方式：POST(HTTPS)
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/externalcontact/get_moment_list?access_token=ACCESS_TOKEN
     *
     * 请求示例：
     *
     * {
     * "start_time":1605000000,
     * "end_time":1605172726,
     * "creator":"zhangsan",
     * "filter_type":1,
     * "cursor":"CURSOR",
     * "limit":10
     * }
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * start_time 是 朋友圈记录开始时间
     * end_time 是 朋友圈记录结束时间
     * creator 否 朋友圈创建人企业账号id
     * filter_type 否 朋友圈类型。0：企业发表 1：个人发表 2：所有，包括个人创建以及企业创建，默认情况下为所有类型
     * cursor 否 用于分页查询的游标，字符串类型，由上一次调用返回，首次调用可不填
     * limit 否 返回的最大记录数，整型，最大值100，默认值100，超过最大值时取默认值
     * 补充说明:
     *
     * 朋友圈记录的起止时间间隔不能超过1个月
     * web管理端会展示企业成员所有已经发表的朋友圈（包括已经删除朋友圈），而API接口将会不会吐出已经删除的朋友圈记录
     *
     * 权限说明：
     *
     * 企业需要使用“客户联系”secret或配置到“可调用应用”列表中的自建应用secret所获取的accesstoken来调用（accesstoken如何获取？）。
     * 自建应用调用，只会返回应用可见范围内用户的发送情况。
     * 第三方应用调用需要企业授权客户朋友圈下获取企业全部的发表记录的权限
     * 返回结果：
     *
     * {
     * "errcode":0,
     * "errmsg":"ok",
     * "next_cursor":"CURSOR",
     * "moment_list":[
     * {
     * "moment_id":"momxxx",
     * "creator":"xxxx",
     * "create_time":"xxxx",
     * "create_type":1,
     * "visible_type ":1,
     * "text":{
     * "content":"test"
     * },
     * "image":[
     * {"media_id":"WWCISP_xxxxx"}
     * ],
     * "video":{
     * "media_id":"WWCISP_xxxxx",
     * "thumb_media_id":"WWCISP_xxxxx"
     * },
     * "link":{
     * "title":"腾讯网-QQ.COM",
     * "url":"https://www.qq.com"
     * },
     * "location":{
     * "latitude":"23.10647",
     * "longitude":"113.32446",
     * "name":"广州市 · 广州塔"
     * }
     * }
     * ]
     * }
     * 参数说明：
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     * next_cursor 分页游标，下次请求时填写以获取之后分页的记录，如果已经没有更多的数据则返回空
     * moment_list 朋友圈列表
     * moment_list.moment_id 朋友圈id
     * moment_list.creator 朋友圈创建者userid
     * moment_list.create_time 创建时间
     * moment_list.create_type 朋友圈创建来源。0：企业 1：个人
     * moment_list.visible_type 可见范围类型。0：部分可见 1：公开
     * moment_list.text.content 文本消息结构
     * moment_list.image.media_id 图片的media_id列表，可以通过获取临时素材下载资源
     * moment_list.video.media_id 视频media_id，可以通过获取临时素材下载资源
     * moment_list.video.thumb_media_id 视频封面media_id，可以通过获取临时素材下载资源
     * moment_list.link.title 网页链接标题
     * moment_list.link.url 网页链接url
     * moment_list.location.latitude 地理位置纬度
     * moment_list.location.longitude 地理位置经度
     * moment_list.location.name 地理位置名称
     */
    public function getMomentList($start_time, $end_time, $creator = "", $filter_type = 2, $limit = 100, $cursor = "")
    {
        $params = array();
        $params['start_time'] = $start_time;
        $params['end_time'] = $end_time;
        if (!empty($creator)) {
            $params['creator'] = $creator;
        }
        $params['filter_type'] = $filter_type;
        if (!empty($cursor)) {
            $params['cursor'] = $cursor;
        }
        $params['limit'] = $limit;
        $rst = $this->_request->post($this->_url . 'get_moment_list', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 获取客户朋友圈企业发表的列表
     * 企业和第三方应用可通过该接口获取企业发表的朋友圈成员执行情况
     *
     * 请求方式：POST(HTTPS)
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/externalcontact/get_moment_task?access_token=ACCESS_TOKEN
     *
     * 请求示例：
     *
     * {
     * "moment_id":"momxxx",
     * "cursor":"CURSOR",
     * "limit":10
     * }
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * moment_id 是 朋友圈id,仅支持企业发表的朋友圈id
     * cursor 否 用于分页查询的游标，字符串类型，由上一次调用返回，首次调用可不填
     * limit 否 返回的最大记录数，整型，最大值1000，默认值500，超过最大值时取默认值
     * 权限说明：
     *
     * 企业需要使用“客户联系”secret或配置到“可调用应用”列表中的自建应用secret所获取的accesstoken来调用（accesstoken如何获取？）。
     * 自建应用调用，只会返回应用可见范围内用户的发送情况。
     * 第三方应用调用需要企业授权客户朋友圈下获取企业全部的发表记录的权限
     * 返回结果：
     *
     * {
     * "errcode":0,
     * "errmsg":"ok",
     * "next_cursor":"CURSOR",
     * "task_list":[
     * {
     * "userid":"zhangsan",
     * "publish_status":1
     * }
     * ]
     * }
     * 参数说明：
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     * next_cursor 分页游标，再下次请求时填写以获取之后分页的记录，如果已经没有更多的数据则返回空
     * task_list 发表任务列表
     * task_list.userid 发表成员用户userid
     * task_list.publish_status 成员发表状态。0:未发表 1：已发表
     */
    public function getMomentTask($moment_id, $limit = 1000, $cursor = "")
    {
        $params = array();
        $params['moment_id'] = $moment_id;
        if (!empty($cursor)) {
            $params['cursor'] = $cursor;
        }
        $params['limit'] = $limit;
        $rst = $this->_request->post($this->_url . 'get_moment_task', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 获取客户朋友圈发表时选择的可见范围
     * 企业和第三方应用可通过该接口获取客户朋友圈创建时，选择的客户可见范围
     * 请求方式：POST(HTTPS)
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/externalcontact/get_moment_customer_list?access_token=ACCESS_TOKEN
     *
     * 请求示例：
     *
     * {
     * "moment_id":"momxxx",
     * "userid":"xxx",
     * "cursor":"CURSOR",
     * "limit":10
     * }
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * moment_id 是 朋友圈id
     * userid 否 企业发表成员userid，如果是企业创建的朋友圈，可以通过获取朋友圈成员任务列表获取已发表成员userid，如果是个人创建的朋友圈，创建人userid就是发表成员userid
     * cursor 否 用于分页查询的游标，字符串类型，由上一次调用返回，首次调用可不填
     * limit 否 返回的最大记录数，整型，最大值1000，默认值500，超过最大值时取默认值
     * 权限说明：
     *
     * 企业需要使用“客户联系”secret或配置到“可调用应用”列表中的自建应用secret所获取的accesstoken来调用（accesstoken如何获取？）。
     * 自建应用调用，只会返回应用可见范围内用户的发送情况。
     * 第三方应用调用需要企业授权客户朋友圈下获取企业全部的发表记录的权限
     * 返回结果：
     *
     * {
     * "errcode":0,
     * "errmsg":"ok",
     * "next_cursor":"CURSOR",
     * "customer_list":[
     * {
     * "userid":"xxx",
     * "external_userid":"zhangsan "
     * }
     * ]
     * }
     * 参数说明：
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     * next_cursor 分页游标，再下次请求时填写以获取之后分页的记录，如果已经没有更多的数据则返回空
     * customer_list 成员可见客户列表
     * customer_list.userid 发表成员用户userid
     * customer_list.external_userid 发送成功的客户external_userid列表
     */
    public function getMomentCustomerList($moment_id, $userid, $limit = 1000, $cursor = "")
    {
        $params = array();
        $params['moment_id'] = $moment_id;
        $params['userid'] = $userid;
        if (!empty($cursor)) {
            $params['cursor'] = $cursor;
        }
        $params['limit'] = $limit;
        $rst = $this->_request->post($this->_url . 'get_moment_customer_list', $params);
        return $this->_client->rst($rst);
    }
    /**
     * 获取客户朋友圈发表后的可见客户列表
     * 企业和第三方应用可通过该接口获取客户朋友圈发表后，可在微信朋友圈中查看的客户列表
     * 请求方式：POST(HTTPS)
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/externalcontact/get_moment_send_result?access_token=ACCESS_TOKEN
     *
     * 请求示例：
     *
     * {
     * "moment_id":"momxxx",
     * "userid":"xxx",
     * "cursor":"CURSOR",
     * "limit":100
     * }
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * moment_id 是 朋友圈id
     * userid 是 企业发表成员userid，如果是企业创建的朋友圈，可以通过获取朋友圈成员任务列表获取已发表成员userid，如果是个人创建的朋友圈，创建人userid就是发表成员userid企业成员userid
     * cursor 否 用于分页查询的游标，字符串类型，由上一次调用返回，首次调用可不填
     * limit 否 返回的最大记录数，整型，最大值5000，默认值3000，超过最大值时取默认值
     * 权限说明：
     *
     * 企业需要使用“客户联系”secret或配置到“可调用应用”列表中的自建应用secret所获取的accesstoken来调用（accesstoken如何获取？）。
     * 自建应用调用，只会返回应用可见范围内用户的发送情况。
     * 第三方应用调用需要企业授权客户朋友圈下获取企业全部的发表记录的权限
     * 返回结果：
     *
     * {
     * "errcode":0,
     * "errmsg":"ok",
     * "next_cursor":"CURSOR",
     * "customer_list":[
     * {
     * "external_userid":"zhangsan"
     * }
     * ]
     * }
     * 参数说明：
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     * next_cursor 分页游标，再下次请求时填写以获取之后分页的记录，如果已经没有更多的数据则返回空
     * customer_list 成员发送成功客户列表
     * customer_list.external_userid 客户external_userid
     */
    public function getMomentSendResult($moment_id, $userid, $limit = 5000, $cursor = "")
    {
        $params = array();
        $params['moment_id'] = $moment_id;
        $params['userid'] = $userid;
        if (!empty($cursor)) {
            $params['cursor'] = $cursor;
        }
        $params['limit'] = $limit;
        $rst = $this->_request->post($this->_url . 'get_moment_send_result', $params);
        return $this->_client->rst($rst);
    }
    /**
     * 获取客户朋友圈的互动数据
     * 企业和第三方应用可通过此接口获取客户朋友圈的互动数据。
     *
     * 请求方式：POST(HTTPS)
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/externalcontact/get_moment_comments?access_token=ACCESS_TOKEN
     *
     * 请求示例：
     *
     * {
     * "moment_id":"momxxx",
     * "userid":"xxx"
     * }
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * moment_id 是 朋友圈id
     * userid 是 企业发表成员userid，如果是企业创建的朋友圈，可以通过获取朋友圈成员任务列表获取已发表成员userid，如果是个人创建的朋友圈，创建人userid就是发表成员userid
     * 权限说明：
     *
     * 企业需要使用“客户联系”secret或配置到“可调用应用”列表中的自建应用secret所获取的accesstoken来调用（accesstoken如何获取？）。
     * 自建应用调用，只会返回应用可见范围内用户的发送情况。
     * 第三方应用调用需要企业授权客户朋友圈下获取企业全部的发表记录的权限
     * 返回结果：
     *
     * {
     * "errcode":0,
     * "errmsg":"ok",
     * "comment_list":[
     * {
     * "external_userid":"xxx",
     * "create_time":1605172726
     * }
     * ],
     * "like_list":[
     * {
     * "external_userid":"xxx",
     * "create_time":1605172726
     * }
     * ]
     * }
     * 参数说明：
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     * comment_list 评论列表
     * comment_list.external_userid 评论的客户列表
     * comment_list.create_time 评论时间
     * like_list 点赞列表
     * like_list.external_userid 点赞的客户列表
     * like_list.create_time 点赞时间
     */
    public function getMomentComments($moment_id, $userid)
    {
        $params = array();
        $params['moment_id'] = $moment_id;
        $params['userid'] = $userid;
        $rst = $this->_request->post($this->_url . 'get_moment_comments', $params);
        return $this->_client->rst($rst);
    }
}
