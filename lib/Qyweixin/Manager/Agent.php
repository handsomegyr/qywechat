<?php

namespace Qyweixin\Manager;

use Qyweixin\Client;

/**
 * 应用管理
 * https://work.weixin.qq.com/api/doc/90000/90135/90226
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class Agent
{

    // 接口地址
    private $_url = 'https://qyapi.weixin.qq.com/cgi-bin/agent/';

    private $_client;

    private $_request;

    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 获取应用
     * 调试工具
     * 获取指定的应用详情
     * 获取access_token对应的应用列表
     * 获取指定的应用详情
     * 请求方式：GET（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/agent/get?access_token=ACCESS_TOKEN&agentid=AGENTID
     * 参数说明 ：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * agentid 是 应用id
     * 权限说明：
     * 企业仅可获取当前凭证对应的应用；第三方仅可获取被授权的应用。
     *
     * 返回结果：
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "agentid": 1000005,
     * "name": "HR助手",
     * "square_logo_url": "https://p.qlogo.cn/bizmail/FicwmI50icF8GH9ib7rUAYR5kicLTgP265naVFQKnleqSlRhiaBx7QA9u7Q/0",
     * "description": "HR服务与员工自助平台",
     * "allow_userinfos": {
     * "user": [
     * {"userid": "zhangshan"},
     * {"userid": "lisi"}
     * ]
     * },
     * "allow_partys": {
     * "partyid": [1]
     * },
     * "allow_tags": {
     * "tagid": [1,2,3]
     * },
     * "close": 0,
     * "redirect_domain": "open.work.weixin.qq.com",
     * "report_location_flag": 0,
     * "isreportenter": 0,
     * "home_url": "https://open.work.weixin.qq.com"
     * }
     * 参数说明：
     *
     * 参数 说明
     * errcode 出错返回码，为0表示成功，非0表示调用失败
     * errmsg 返回码提示语
     * agentid 企业应用id
     * name 企业应用名称
     * square_logo_url 企业应用方形头像
     * description 企业应用详情
     * allow_userinfos 企业应用可见范围（人员），其中包括userid
     * allow_partys 企业应用可见范围（部门）
     * allow_tags 企业应用可见范围（标签）
     * close 企业应用是否被停用
     * redirect_domain 企业应用可信域名
     * report_location_flag 企业应用是否打开地理位置上报 0：不上报；1：进入会话上报；
     * isreportenter 是否上报用户进入应用事件。0：不接收；1：接收
     * home_url 应用主页url
     */
    public function get($agentid)
    {
        $params = array();
        $params['agentid'] = $agentid;
        $rst = $this->_request->get($this->_url . 'get', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 获取access_token对应的应用列表
     * 请求方式：GET（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/agent/list?access_token=ACCESS_TOKEN
     *
     * 参数说明 ：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * 权限说明：
     * 企业仅可获取当前凭证对应的应用；第三方仅可获取被授权的应用。
     *
     * 返回结果：
     *
     * {
     * "errcode":0,
     * "errmsg":"ok" ,
     * "agentlist":[
     * {
     * "agentid": 1000005,
     * "name": "HR助手",
     * "square_logo_url": "https://p.qlogo.cn/bizmail/FicwmI50icF8GH9ib7rUAYR5kicLTgP265naVFQKnleqSlRhiaBx7QA9u7Q/0"
     * }
     * ]
     * }
     * 参数说明：
     *
     * 参数 类型 说明
     * errcode Integer 出错返回码，为0表示成功，非0表示调用失败
     * errmsg String 返回码提示语
     * agentlist AgentItemArray 当前凭证可访问的应用列表
     * AgentItem 结构：
     *
     * 参数 类型 说明
     * agentid Integer 企业应用id
     * name String 企业应用名称
     * square_logo_url String 企业应用方形头像url
     */
    public function getAgentList()
    {
        $params = array();
        $rst = $this->_request->get($this->_url . 'list', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 设置应用
     * 调试工具
     * 请求方式：POST（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/agent/set?access_token=ACCESS_TOKEN
     *
     * 请求示例：
     *
     * {
     * "agentid": 1000005,
     * "report_location_flag": 0,
     * "logo_mediaid": "j5Y8X5yocspvBHcgXMSS6z1Cn9RQKREEJr4ecgLHi4YHOYP-plvom-yD9zNI0vEl",
     * "name": "财经助手",
     * "description": "内部财经服务平台",
     * "redirect_domain": "open.work.weixin.qq.com",
     * "isreportenter": 0,
     * "home_url": "https://open.work.weixin.qq.com"
     * }
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * agentid 是 企业应用的id
     * report_location_flag 否 企业应用是否打开地理位置上报 0：不上报；1：进入会话上报；
     * logo_mediaid 否 企业应用头像的mediaid，通过素材管理接口上传图片获得mediaid，上传后会自动裁剪成方形和圆形两个头像
     * name 否 企业应用名称，长度不超过32个utf8字符
     * description 否 企业应用详情，长度为4至120个utf8字符
     * redirect_domain 否 企业应用可信域名。注意：域名需通过所有权校验，否则jssdk功能将受限，此时返回错误码85005
     * isreportenter 否 是否上报用户进入应用事件。0：不接收；1：接收。
     * home_url 否 应用主页url。url必须以http或者https开头（为了提高安全性，建议使用https）。
     * 权限说明：
     * 仅企业可调用，可设置当前凭证对应的应用；第三方不可调用。
     *
     * 返回结果 ：
     *
     * {
     * "errcode":0,
     * "errmsg":"ok"
     * }
     */
    public function set(\Qyweixin\Model\Agent $agent)
    {
        $params = $agent->getParams();
        $rst = $this->_request->post($this->_url . 'set', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 设置应用在工作台展示的模版
     * 请求说明：该接口指定应用自定义模版类型。同时也支持设置企业默认模版数据。若type指定为 “normal” 则为取消自定义模式，改为普通展示模式
     * 请求方式：POST（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/agent/set_workbench_template?access_token=ACCESS_TOKEN
     *
     * 请求示例
     *
     * {
     * "agentid":1000005,
     * "type":"image",
     * "image":{
     * "url":"xxxx",
     * "jump_url":"http://www.qq.com",
     * "pagepath":"pages/index"
     * },
     * "replace_user_data":true
     * }
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * type 是 模版类型，目前支持的自定义类型包括 “keydata”、 “image”、 “list”、 “webview” 。若设置的type为 “normal”,则相当于从自定义模式切换为普通宫格或者列表展示模式
     * agentid 是 应用id
     * keydata 否 若type指定为 “keydata”，且需要设置企业级别默认数据，则需要设置关键数据型模版数据,数据结构参考“关键数据型”
     * image 否 若type指定为 “image”，且需要设置企业级别默认数据，则需要设置图片型模版数据,数据结构参考“图片型”
     * list 否 若type指定为 “list”，且需要设置企业级别默认数据，则需要设置列表型模版数据,数据结构参考“列表型”
     * webview 否 若type指定为 “webview”，且需要设置企业级别默认数据，则需要设置webview型模版数据,数据结构参考“webview型”
     * replace_user_data 否 是否覆盖用户工作台的数据。设置为true的时候，会覆盖企业所有用户当前设置的数据。若设置为false,则不会覆盖用户当前设置的所有数据。默认为false
     * 权限说明：
     * 可设置当前凭证对应的应用；
     *
     * 返回结果 ：
     *
     * {
     * "errcode":0,
     * "errmsg":"ok"
     * }
     */
    public function setWorkbenchTemplate($agentid, \Qyweixin\Model\WorkbenchTemplate\Base $workbenchTemplate, $replace_user_data = false)
    {
        $params = array();
        $params['agentid'] = $agentid;
        $params = array_merge($params, $workbenchTemplate->getParams());
        $params['replace_user_data'] = $replace_user_data;

        $rst = $this->_request->post($this->_url . 'set_workbench_template', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 获取应用在工作台展示的模版
     * 请求方式：POST（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/agent/get_workbench_template?access_token=ACCESS_TOKEN
     *
     * 请求示例：
     *
     * {
     * "agentid":1000005
     * }
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * agentid 是 应用id
     * 权限说明：
     * 可设置当前凭证对应的应用；
     *
     * 返回结果 ：
     *
     * {
     * "errcode":0,
     * "errmsg":"ok"
     * "type":"image",
     * "image":{
     * "url":"xxxx",
     * "jump_url":"http://www.qq.com",
     * "pagepath":"pages/index"
     * },
     * "replace_user_data":true
     * }
     */
    public function getWorkbenchTemplate($agentid)
    {
        $params = array();
        $params['agentid'] = $agentid;
        $rst = $this->_request->post($this->_url . 'get_workbench_template', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 设置应用在用户工作台展示的数据
     * 请求方式：POST（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/agent/set_workbench_data?access_token=ACCESS_TOKEN
     *
     * 请求示例
     *
     * {
     * "agentid":1000005,
     * "userid":"test",
     * "type":"keydata",
     * "keydata":{
     * "items":[
     * {
     * "key":"待审批",
     * "data":"2",
     * "jump_url":"http://www.qq.com",
     * "pagepath":"pages/index"
     * },
     * {
     * "key":"带批阅作业",
     * "data":"4",
     * "jump_url":"http://www.qq.com",
     * "pagepath":"pages/index"
     * },
     * {
     * "key":"成绩录入",
     * "data":"45",
     * "jump_url":"http://www.qq.com",
     * "pagepath":"pages/index"
     * },
     * {
     * "key":"综合评价",
     * "data":"98",
     * "jump_url":"http://www.qq.com",
     * "pagepath":"pages/index"
     * }
     * ]
     * }
     * }
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * agentid 是 应用id
     * userid 是 需要设置的用户的userid
     * type 是 目前支持 “keydata”、 “image”、 “list” 、”webview”
     * keydata 否 若type指定为 “keydata”，则需要设置关键数据型模版数据,数据结构参考“关键数据型”
     * image 否 若type指定为 “image”，则需要设置图片型模版数据，数据结构参考“图片型”
     * list 否 若type指定为 “list”，则需要设置列表型模版数据，数据结构参考“列表型”
     * webview 否 若type指定为 “webview”，则需要设置webview型模版数据，数据结构参考“webview数据型”
     * 权限说明：
     * 可设置当前凭证对应的应用；设置的userid必须在应用可见范围
     * 每个用户每个应用接口限制10次/分钟
     */
    public function setWorkbenchData($agentid, $userid, \Qyweixin\Model\WorkbenchTemplate\Base $workbenchTemplate)
    {
        $params = array();
        $params['agentid'] = $agentid;
        $params['userid'] = $userid;
        $params = array_merge($params, $workbenchTemplate->getParams());
        $rst = $this->_request->post($this->_url . 'set_workbench_data', $params);
        return $this->_client->rst($rst);
    }
}
