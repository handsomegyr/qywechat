<?php

namespace Qyweixin\Manager\Linkedcorp;

use Qyweixin\Client;

/**
 * 互联企业应用
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class Agent
{

    // 接口地址
    private $_url = 'https://qyapi.weixin.qq.com/cgi-bin/linkedcorp/agent/';
    private $_client;
    private $_request;
    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 获取应用的可见范围
     * 本接口只返回互联企业中非本企业内的成员和部门的信息，如果要获取本企业的可见范围，请调用“获取应用”接口
     *
     * 请求方式： POST（HTTPS）
     * 请求地址： https://qyapi.weixin.qq.com/cgi-bin/linkedcorp/agent/get_perm_list?access_token=ACCESS_TOKEN
     *
     * 权限说明：
     *
     * 仅自建应用可调用。
     *
     * 返回结果：
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "userids": [
     * "CORPID/USERID"
     * ],
     * "department_ids": [
     * "LINKEDID/DEPARTMENTID"
     * ]
     * }
     * 参数说明：
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     * userids 可见的userids，是用 CorpId + ’/‘ + USERID 拼成的字符串
     * department_ids 可见的department_ids，是用 linkedid + ’/‘ + department_id 拼成的字符串
     */
    public function getPermList()
    {
        $params = array();
        $rst = $this->_request->post($this->_url . 'get_perm_list', $params);
        return $this->_client->rst($rst);
    }
}
