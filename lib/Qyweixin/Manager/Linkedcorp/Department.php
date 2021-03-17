<?php

namespace Qyweixin\Manager\Linkedcorp;

use Qyweixin\Client;

/**
 * 互联企业部门
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class Department
{

    // 接口地址
    private $_url = 'https://qyapi.weixin.qq.com/cgi-bin/linkedcorp/department/';
    private $_client;
    private $_request;
    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 获取互联企业部门列表
     * 请求方式： POST（HTTPS）
     * 请求地址： https://qyapi.weixin.qq.com/cgi-bin/linkedcorp/department/list?access_token=ACCESS_TOKEN
     *
     * 请求包体：
     *
     * {
     * "department_id": "LINKEDID/DEPARTMENTID"
     * }
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * department_id 是 该字段用的是互联应用可见范围接口返回的department_ids参数，用的是 linkedid + ’/‘ + department_id 拼成的字符串
     * 权限说明：
     *
     * 仅自建应用可调用，应用须拥有指定部门的查看权限。
     *
     * 返回结果：
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "department_list": [
     * {
     * "department_id": "1",
     * "department_name": "测试部门1",
     * "parentid": "0",
     * "order": 100000000
     * },
     * {
     * "department_id": "2",
     * "department_name": "测试部门2",
     * "parentid": "1",
     * "order": 99999999
     * }
     * ]
     * }
     * 参数说明：
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     * department_list 部门列表
     * department_id 部门id
     * department_name 部门名称
     * parentid 上级部门的id
     * order 排序值
     */
    public function departmentlist($department_id)
    {
        $params = array();
        $params['department_id'] = $department_id;
        $rst = $this->_request->post($this->_url . 'list', $params);
        return $this->_client->rst($rst);
    }
}
