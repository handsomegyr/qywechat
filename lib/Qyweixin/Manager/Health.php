<?php

namespace Qyweixin\Manager;

use Qyweixin\Client;

/**
 * 健康上报管理
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class Health
{

    // 接口地址
    private $_url = 'https://qyapi.weixin.qq.com/cgi-bin/health/';

    private $_client;

    private $_request;

    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 获取健康上报使用统计
     * 请求方式：POST（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/health/get_health_report_stat?access_token=ACCESS_TOKEN
     *
     * {
     * "date": "2020-03-27"
     * }
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证。
     * date 是 具体某天的使用统计，最长支持获取30天前数据
     * 权限说明：
     *
     * 仅健康上报应用可调用。
     * 返回结果：
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "pv": 100,
     * "uv": 50
     * }
     * 参数说明：
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     * pv 应用使用次数
     * uv 应用使用成员数
     */
    public function getHealthReportStat($date)
    {
        $params = array();
        $params['date'] = $date;
        $rst = $this->_request->post($this->_url . 'get_health_report_stat', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 获取健康上报任务ID列表
     * 获取健康上报任务ID列表
     * 获取健康上报任务ID列表
     * 通过此接口可以获取企业当前正在运行的上报任务ID列表。
     *
     * 请求方式：POST（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/health/get_report_jobids?access_token=ACCESS_TOKEN
     *
     * 请求包体：
     *
     * {
     * "offset": 0,
     * "limit": 100
     * }
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * offset 否 分页，偏移量, 默认为0
     * limit 否 分页，预期请求的数据量，默认为100，取值范围 1 ~ 100
     * 权限说明：
     *
     * 仅健康上报应用可调用。
     * 返回结果：
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "ending":1,
     * "jobids":[
     * "jobid1",
     * "jobid2"
     * ]
     * }
     * 参数说明：
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     * ending 是否结束。0：表示还有更多数据，需要继续拉取，1：表示已经拉取完所有数据
     * jobids 任务id
     */
    public function getReportJobids($offset = 0, $limit = 100)
    {
        $params = array();
        $params['offset'] = $offset;
        $params['limit'] = $limit;

        $rst = $this->_request->post($this->_url . 'get_report_jobids', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 获取健康上报任务详情
     * 获取健康上报任务详情
     * 获取健康上报任务详情
     * 通过此接口可以获取指定的健康上报任务详情。
     *
     * 请求方式：POST（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/health/get_report_job_info?access_token=ACCESS_TOKEN
     *
     * 请求包体：
     *
     * {
     * "jobid": "jobid1",
     * "date": "2020-03-27"
     * }
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * jobid 是 任务ID
     * date 是 具体某天任务详情
     * 权限说明：
     *
     * 仅健康上报应用可调用。
     * 返回结果：
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "job_info":{
     * "title": "职工收集任务",
     * "creator"： "creator_userid",
     * "type": 1,
     * "apply_range": {
     * "userids":[
     * "userid1",
     * "userid2"
     * ],
     * "partyids":[
     * 1,
     * 2
     * ]
     * },
     * "report_to":{
     * "userids":[
     * "userid1",
     * "userid2"
     * ]
     * }
     * "report_type": 1,
     * "skip_weekend": 0,
     * "finish_cnt": 10,
     * "question_templates":[
     * {
     * "question_id": 1,
     * "title": "请问你有任何身体不适吗？",
     * "question_type": 2,
     * "is_required": 1,
     * "option_list":[
     * {
     * "option_id": 1,
     * "option_text": "有"
     * },
     * {
     * "option_id": 2,
     * "option_text": "没有"
     * }
     * ]
     * },
     * {
     * "question_id": 2,
     * "title": "常驻地址",
     * "question_type": 1,
     * "is_required": 0
     * }
     * ]
     * }
     * }
     * 参数说明：
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     * title 任务名称
     * creator 发起人的userid
     * type 任务类型。1：表示企业内部成员，2：表示家长
     * apply_range 适用范围
     * apply_range.userids type=1时表示企业成员的userid，type=2时表示学生的userid
     * apply_range.partyids type=1时表示企业通讯录的部门id，type=2时表示学校通讯录的部门id
     * report_to.userids 汇报对象的企业通讯录userid
     * report_type 上报方式。1表示仅上报一次，2表示每天都上报
     * skip_weekend 非工作日是否需要上报。0表示周末需要上报，1表示周末不需要上报
     * finish_cnt 已填表人数
     * question_templates 健康上报问题列表
     * question_templates.question_id 问题的question_id
     * question_templates.title 问题的title
     * question_templates.question_type 问题类型，1：表示是填空题，2：表示是单选题 ,3：表示多选题
     * question_templates.is_required 问题是否必填，1：表示“是”，0：表示“否”
     * question_templates.option_list 选项列表，仅当该题为单/多选题时才有该字段
     * question_templates.option_list.option_id 该选项的option_id
     * question_templates.option_list.option_text 该选项的文案说明
     */
    public function getReportJobInfo($jobid, $date)
    {
        $params = array();
        $params['jobid'] = $jobid;
        $params['date'] = $date;

        $rst = $this->_request->get($this->_url . 'get_report_job_info', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 获取用户填写答案
     * 获取用户填写答案
     * 获取用户填写答案
     * 通过此接口可以获取指定的健康上报任务详情。
     *
     * 请求方式：POST（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/health/get_report_answer?access_token=ACCESS_TOKEN
     *
     * 请求包体：
     *
     * {
     * "jobid": "jobid1",
     * "date": "2020-03-27",
     * "offset": 0,
     * "limit": 100
     * }
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * jobid 是 任务ID
     * date 是 具体某天任务的填写答案
     * offset 否 数据偏移量
     * limit 否 拉取的数据量
     * 权限说明：
     *
     * 仅健康上报应用可调用。
     * 返回结果：
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "answers":[
     * {
     * "id_type": 1,
     * "userid": "userid2",
     * "report_values": [
     * {
     * "question_id": 1,
     * "single_choice": 2
     * },
     * {
     * "question_id": 2,
     * "text": "广东省广州市"
     * },
     * {
     * "question_id": 2,
     * "multi_choice": [
     * 1, 3
     * ]
     * }
     * ]
     * },
     * {
     * "id_type": 2,
     * "student_userid": "student_userid1",
     * "parent_userid": "parent_userid1",
     * "report_values":[
     * {
     * "question_id": 1,
     * "single_choice": 1
     * },
     * {
     * "question_id": 2,
     * "text": "广东省深圳市"
     * },
     * {
     * "question_id": 2,
     * "multi_choice":[
     * 1,2,3
     * ]
     * }
     * ]
     * }
     * ]
     * }
     * 参数说明：
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     * answers 答案列表
     * creator 发起人的userid
     * answers.id_type id类型：1：表示返回企业内部成员的userid，2：表示返回的是家长和学生的userid
     * answers.userid 企业内部成员的userid，id_type=1时返回
     * answers.student_userid 学生的userid，id_type=2时返回
     * answers.parent_userid 家长的userid，id_type=2时返回
     * answers.report_values 用户填写的答案列表
     * answers.report_values.question_id 问题的id
     * answers.report_values.single_choice 单选题答案编号
     * answers.report_values.text 填空题答案内容
     * answers.report_values.multi_choice 多选题答案编号
     */
    public function getReportAnswer($jobid, $date, $offset = 0, $limit = 100)
    {
        $params = array();
        $params['jobid'] = $jobid;
        $params['date'] = $date;
        $params['offset'] = $offset;
        $params['limit'] = $limit;

        $rst = $this->_request->get($this->_url . 'get_report_answer', $params);
        return $this->_client->rst($rst);
    }
}
