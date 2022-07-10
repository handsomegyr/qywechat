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
     * 创建发表任务
企业和第三方应用可通过该接口创建客户朋友圈的发表任务。

请求方式：POST(HTTPS)
请求地址：https://qyapi.weixin.qq.com/cgi-bin/externalcontact/add_moment_task?access_token=ACCESS_TOKEN

请求示例：

{
	"text": {
		"content": "文本消息内容"
	},
	"attachments": [
		{
			"msgtype": "image",
			"image": {
				"media_id": "MEDIA_ID"
			}
		},
		{
			"msgtype": "video",
			"video": {
				"media_id": "MEDIA_ID"
			}
		},
		{
			"msgtype": "link",
			"link": {
				"title": "消息标题",
				"url": "https://example.link.com/path",
				"media_id": "MEDIA_ID"
			}
		}
	],
 	"visible_range":{
		"sender_list":{
			"user_list":["zhangshan","lisi"],
			"department_list":[2,3]
		},
		"external_contact_list":{
			"tag_list":[ "etXXXXXXXXXX", "etYYYYYYYYYY"]
		}
	}
}
参数说明：

参数	必须	说明
access_token		调用接口凭证
visible_range	否	指定的发表范围；若未指定，则表示执行者为应用可见范围内所有成员
sender_list	否	发表任务的执行者列表，详见下文的“可见范围说明”
sender_list.user_list	否	发表任务的执行者用户列表，最多支持10万个
sender_list.department_list	否	发表任务的执行者部门列表
external_contact_list	否	可见到该朋友圈的客户列表，详见下文的“可见范围说明”
external_contact_list.tag_list	否	可见到该朋友圈的客户标签列表
text	否	文本消息
text.content	否	消息文本内容，不能与附件同时为空，最多支持传入2000个字符，若超出长度报错'invalid text size'
attachments	否	附件，不能与text.content同时为空，最多支持9个图片类型，或者1个视频，或者1个链接。类型只能三选一，若传了不同类型，报错'invalid attachments msgtype'
msgtype	是	附件类型，可选image、link或者video
image	否	图片消息附件。普通图片：总像素不超过1555200。图片大小不超过10M。最多支持传入9个；超过9个报错'invalid attachments size'
image.media_id	是	图片的素材id。可通过上传附件资源接口获得
link	否	图文消息附件。只支持1个；若超过1个报错'invalid attachments size'
link.title	否	图文消息标题，最多64个字节
link.url	是	图文消息链接
link.media_id	是	图片链接封面，普通图片：总像素不超过1555200。可通过上传附件资源接口获得
video	否	视频消息附件。最长不超过30S，最大不超过10MB。只支持1个；若超过1个报错'invalid attachments size'
video.media_id	是	视频的素材id，未填写报错"invalid msg"。可通过上传附件资源接口获得
可见范围说明

visible_range，分以下几种情况：

若只指定sender_list，则可见的客户范围为该部分执行者的客户，目前执行者支持传userid与部门id列表，注意不在应用可见范围内的执行者会被忽略。
若只指定external_contact_list，即指定了可见该朋友圈的目标客户，此时会将该发表任务推给这些目标客户的应用可见范围内的跟进人。
若同时指定sender_list以及external_contact_list，会将该发表任务推送给sender_list指定的且在应用可见范围内的执行者，执行者发表后仅external_contact_list指定的客户可见。
若未指定visible_range，则可见客户的范围为该应用可见范围内执行者的客户，执行者为应用可见范围内所有成员。
注：若指定external_contact_list列表，则该条朋友圈为部分可见；否则为公开

权限说明：

企业需要使用“客户联系”secret或配置到“可调用应用”列表中的自建应用secret所获取的accesstoken来调用（accesstoken如何获取？）。
自建应用调用，只会返回应用可见范围内用户的发送情况。
第三方应用或代开发自建应用调用需要企业授权客户朋友圈下发表到成员客户的朋友圈的权限
企业每分钟创建朋友圈的频率：10条/分钟
返回结果：

{
	"errcode":0,
	"errmsg":"ok",
	"jobid":"xxxx"
}
参数说明：

参数	说明
errcode	返回码
errmsg	对返回码的文本描述内容
jobid	异步任务id，最大长度为64字节，24小时有效；可使用获取发表朋友圈任务结果查询任务状态
     */
    public function addMomentTask(\Qyweixin\Model\ExternalContact\Moment\Task $task)
    {
        $params = $task->getParams();
        $rst = $this->_request->post($this->_url . 'add_moment_task', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 获取任务创建结果
由于发表任务的创建是异步执行的，应用需要再调用该接口以获取创建的结果。
请求方式：GET（HTTPS）
请求地址：https://qyapi.weixin.qq.com/cgi-bin/externalcontact/get_moment_task_result?access_token=ACCESS_TOKEN&jobid=JOBID

 

参数说明：

参数	必须	说明
access_token	是	调用接口凭证
jobid	是	异步任务id，最大长度为64字节，由创建发表内容到客户朋友圈任务接口获取
权限说明：

只能查询已经提交过的历史任务。

返回结果：

{
    "errcode": 0,
    "errmsg": "ok",
    "status": 1,
    "type": "add_moment_task",
	"result": {
		"errcode":0,
		"errmsg":"ok"
		"moment_id":"xxxx",
		"invalid_sender_list":{
			"user_list":["zhangshan","lisi"],
			"department_list":[2,3]
		},
		"invalid_external_contact_list":{
			"tag_list":["xxx"]
		}
	}
}

参数说明：

参数	说明
errcode	返回码
errmsg	对返回码的文本描述内容
status	任务状态，整型，1表示开始创建任务，2表示正在创建任务中，3表示创建任务已完成
type	操作类型，字节串，此处固定为add_moment_task
result	详细的处理结果。当任务完成后此字段有效
result.errcode	返回码
result.errmsg	对返回码的文本描述内容
result.moment_id	朋友圈id，可通过获取客户朋友圈企业发表的列表接口获取朋友圈企业发表的列表
result.invalid_sender_list	不合法的执行者列表，包括不存在的id以及不在应用可见范围内的部门或者成员
     */
    public function getMomentTaskResult($jobid)
    {
        $params = array();
        $params['jobid'] = $jobid;
        $rst = $this->_request->get($this->_url . 'get_moment_task_result', $params);
        return $this->_client->rst($rst);
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
