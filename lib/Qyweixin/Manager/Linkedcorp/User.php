<?php

namespace Qyweixin\Manager\Linkedcorp;

use Qyweixin\Client;

/**
 * 互联企业成员
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class User
{

    // 接口地址
    private $_url = 'https://qyapi.weixin.qq.com/cgi-bin/linkedcorp/user/';
    private $_client;
    private $_request;
    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 获取互联企业成员详细信息
     * 请求方式： POST（HTTPS）
     * 请求地址： https://qyapi.weixin.qq.com/cgi-bin/linkedcorp/user/get?access_token=ACCESS_TOKEN
     *
     * 请求包体：
     *
     * {
     * "userid": "CORPID/USERID"
     * }
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * userid 是 该字段用的是互联应用可见范围接口返回的userids参数，用的是 CorpId + ’/‘ + USERID 拼成的字符串
     * 权限说明：
     *
     * 仅自建应用可调用，应用须拥有指定成员的查看权限。
     *
     * 返回结果：
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "user_info": {
     * "userid": "zhangsan",
     * "name": "张三",
     * "department": [
     * "LINKEDID/1" , "LINKEDID/2"
     * ],
     * "mobile": "+86 12345678901",
     * "telephone": "10086",
     * "email": "zhangsan@tencent.com",
     * "position": "后台开发",
     * "corpid": "xxxxxx",
     * "extattr": {
     * "attrs": [
     * {
     * "name": "自定义属性(文本)",
     * "value": "10086",
     * "type": 0,
     * "text": {
     * "value": "10086"
     * }
     * },
     * {
     * "name": "自定义属性(网页)",
     * "type": 1,
     * "web": {
     * "url": "https://work.weixin.qq.com/",
     * "title": "官网"
     * }
     * }
     * ]
     * }
     * }
     * }
     * }
     * 参数说明：
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     * user_info 成员的详细信息，user包含的属性可在管理端配置
     * userid 成员UserID。对应管理端的帐号，企业内必须唯一。不区分大小写，长度为1~64个字节
     * name 成员真实名称
     * mobile 手机号码
     * department 成员所属部门id列表，这个字段会返回在应用可见范围内，该用户所在的所有互联企业的部门
     * position 职务信息
     * email 邮箱
     * telephone 座机
     * corpid 所属企业的corpid
     * extattr 扩展属性
     */
    public function userget($userid)
    {
        $params = array();
        $params['userid'] = $userid;
        $rst = $this->_request->post($this->_url . 'get', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 获取互联企业部门成员
     * 请求方式： POST（HTTPS）
     * 请求地址： https://qyapi.weixin.qq.com/cgi-bin/linkedcorp/user/simplelist?access_token=ACCESS_TOKEN
     *
     * 请求包体：
     *
     * {
     * "department_id": "LINKEDID/DEPARTMENTID",
     * "fetch_child": true
     * }
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * department_id 是 该字段用的是互联应用可见范围接口返回的department_ids参数，用的是 linkedid + ’/‘ + department_id 拼成的字符串
     * fetch_child 否 是否递归获取子部门下面的成员：1-递归获取，0-只获取本部门，不传默认只获取本部门成员
     * 权限说明：
     *
     * 仅自建应用可调用，应用须拥有指定部门的查看权限。
     *
     * 返回结果：
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "userlist": [
     * {
     * "userid": "zhangsan",
     * "name": "张三",
     * "department": ["LINKEDID/1", "LINKEDID/2"],
     * "corpid": "xxxxxx"
     * },
     * {
     * "userid": "lisi",
     * "name": "李四",
     * "department": ["LINKEDID/1"],
     * "corpid": "xxxxxx"
     * }
     * ]
     * }
     * 参数说明：
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     * userlist 成员列表
     * userid 成员UserID。对应管理端的帐号
     * name 成员真实名称
     * department 成员所属部门id列表，这个字段只会返回传入的department_id所属的互联企业里的部门id
     * corpid 所属企业的corpid
     */
    public function simpleList($department_id, $fetch_child = 0)
    {
        $params = array();
        $params['department_id'] = $department_id;
        $params['fetch_child'] = $fetch_child;
        $rst = $this->_request->post($this->_url . 'simplelist', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 获取互联企业部门成员详情
     * 请求方式： POST（HTTPS）
     * 请求地址： https://qyapi.weixin.qq.com/cgi-bin/linkedcorp/user/list?access_token=ACCESS_TOKEN
     *
     * 请求包体：
     *
     * {
     * "department_id": "LINKEDID/DEPARTMENTID",
     * "fetch_child": true
     * }
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * department_id 是 该字段用的是互联应用可见范围接口返回的department_ids参数，用的是 linkedid + ’/‘ + department_id 拼成的字符串
     * fetch_child 否 是否递归获取子部门下面的成员：1-递归获取，0-只获取本部门，不传默认只获取本部门成员
     * 权限说明：
     *
     * 仅自建应用可调用，应用须拥有指定部门的查看权限。
     *
     * 返回结果：
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "userlist": [{
     * "userid": "zhangsan",
     * "name": "张三",
     * "department": [
     * "LINKEDID/1" , "LINKEDID/2"
     * ],
     * "mobile": "+86 12345678901",
     * "telephone": "10086",
     * "email": "zhangsan@tencent.com",
     * "position": "后台开发",
     * "corpid": "xxxxxx",
     * "extattr": {
     * "attrs": [
     * {
     * "name": "自定义属性(文本)",
     * "value": "10086",
     * "type": 0,
     * "text": {
     * "value": "10086"
     * }
     * },
     * {
     * "name": "自定义属性(网页)",
     * "type": 1,
     * "web": {
     * "url": "https://work.weixin.qq.com/",
     * "title": "官网"
     * }
     * }
     * ]
     * }
     * }
     * ]
     * }
     * 参数说明：
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     * userlist 成员列表，user包含的属性可在管理端配置
     * userid 成员UserID。对应管理端的帐号，企业内必须唯一。不区分大小写，长度为1~64个字节
     * name 成员真实名称
     * mobile 手机号码
     * department 成员所属部门id列表，这个字段只会返回传入的department_id所属的互联企业里的部门id
     * position 职务信息
     * email 邮箱
     * telephone 座机
     * corpid 所属企业的corpid
     * extattr 扩展属性
     */
    public function userlist($department_id, $fetch_child = 0)
    {
        $params = array();
        $params['department_id'] = $department_id;
        $params['fetch_child'] = $fetch_child;
        $rst = $this->_request->post($this->_url . 'list', $params);
        return $this->_client->rst($rst);
    }
}
