<?php

namespace Qyweixin\Manager\ExternalContact;

use Qyweixin\Client;

/**
 * 管理聊天敏感词
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class InterceptRule
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
     * 获取敏感词规则列表
企业和第三方应用可以通过此接口获取敏感词规则列表
请求方式：GET(HTTPS)
请求地址：https://qyapi.weixin.qq.com/cgi-bin/externalcontact/get_intercept_rule_list?access_token=ACCESS_TOKEN
参数说明：

参数	必须	说明
access_token	是	调用接口凭证
权限说明:

企业需要使用“客户联系”secret或配置到“可调用应用”列表中的自建应用secret所获取的accesstoken来调用（accesstoken如何获取？）。
第三方应用或者代开发自建应用调用需要企业授权客户联系下管理敏感词的权限
可获取企业所有敏感词规则
返回结果:

{
    "errcode":0,
    "errmsg":"ok",
	"rule_list":[
		{
			"rule_id":"xxxx",
			"rule_name":"rulename",
			"create_time":1600000000
		}
	]
}
参数说明:

参数	说明
errcode	返回码
errmsg	对返回码的文本描述内容
rule_id	规则id
rule_name	规则名称，长度上限20个字符
create_time	创建时间
     */
    public function getList()
    {
        $params = array();
        $rst = $this->_request->post($this->_url . 'get_intercept_rule_list', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 新建敏感词规则
企业和第三方应用可以通过此接口新建敏感词规则
请求方式：POST(HTTPS)
请求地址：https://qyapi.weixin.qq.com/cgi-bin/externalcontact/add_intercept_rule?access_token=ACCESS_TOKEN

请求示例：

{
	"rule_name":"rulename",
	"word_list":[
	  "敏感词1","敏感词2"
	],
	"semantics_list":[1,2,3],
	"intercept_type":1,
	"applicable_range":{
		"user_list":["zhangshan"],
		"department_list":[2,3]
	}
}
参数说明：

参数	必须	说明
access_token	是	调用接口凭证
rule_name	是	规则名称，长度1~20个utf8字符
word_list	是	敏感词列表，敏感词长度1~32个utf8字符，列表大小不能超过300个
semantics_list	否	额外的拦截语义规则，1：手机号、2：邮箱地:、3：红包
intercept_type	是	拦截方式，1:警告并拦截发送；2:仅发警告
applicable_range	是	敏感词适用范围，userid与department不能同时为不填
applicable_range.user_list	否	可使用的userid列表。必须为应用可见范围内的成员；最多支持传1000个节点
applicable_range.department_list	否	可使用的部门列表，必须为应用可见范围内的部门；最多支持传1000个节点
注：企业敏感词规则条数上限为100个。
权限说明:

企业需要使用“客户联系”secret或配置到“可调用应用”列表中的自建应用secret所获取的accesstoken来调用（accesstoken如何获取？）。
第三方应用或者代开发自建应用调用需要企业授权客户联系下管理敏感词的权限
返回结果:

{
    "errcode":0,
    "errmsg":"ok",
	"rule_id" : "xxx"
}
参数说明:

参数	说明
errcode	返回码
errmsg	对返回码的文本描述内容
rule_id	规则id
     */
    public function add(\Qyweixin\Model\ExternalContact\InterceptRule $interceptRule)
    {
        $params = $interceptRule->getParams();
        $rst = $this->_request->post($this->_url . 'add_intercept_rule', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 获取敏感词规则详情
企业和第三方应用可以通过此接口获取敏感词规则详情
请求方式：POST(HTTPS)
请求地址：https://qyapi.weixin.qq.com/cgi-bin/externalcontact/get_intercept_rule?access_token=ACCESS_TOKEN
请求示例：

{
	"rule_id":"xxx"
}
参数说明：

参数	必须	说明
access_token	是	调用接口凭证
rule_id	是	规则id
 

权限说明:

企业需要使用“客户联系”secret或配置到“可调用应用”列表中的自建应用secret所获取的accesstoken来调用（accesstoken如何获取？）。
第三方应用或者代开发自建应用调用需要企业授权客户联系下管理敏感词的权限
使用范围只返回应用可见范围内的成员跟部门
返回结果:

{
    "errcode":0,
    "errmsg":"ok",
	"rule":{
		"rule_id":1,
		"rule_name":"rulename",
		"word_list":[
	 	 "敏感词1","敏感词2"
		],
		"extra_rule":{
			"semantics_list":[1,2,3],
		},
		"intercept_type":1,
		"applicable_range":{
			"user_list":["zhangshan"],
			"department_list":[2,3]
		}
	}

}
参数说明:

参数	说明
errcode	返回码
errmsg	对返回码的文本描述内容
rule_id	规则id
rule_name	规则名称，长度上限20个字符
word_list	敏感词列表，敏感词不能超过30个字符，列表大小不能超过300个
extra_rule	额外的规则
semantics_list	额外的拦截语义规则，1：手机号、2：邮箱地:、3：红包
intercept_type	拦截方式，1:警告并拦截发送；2:仅发警告
applicable_range	敏感词适用范围
applicable_range.user_list	可使用的userid列表，只返回应用可见范围内的用户
applicable_range.department_list	可使用的部门列表，只返回应用可见范围内的部门
create_time	创建时间
     */
    public function get($rule_id)
    {
        $params = array();
        $params['rule_id'] = $rule_id;
        $rst = $this->_request->post($this->_url . 'get_intercept_rule', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 修改敏感词规则
企业和第三方应用可以通过此接口修改敏感词规则
请求方式：POST(HTTPS)
请求地址：https://qyapi.weixin.qq.com/cgi-bin/externalcontact/update_intercept_rule?access_token=ACCESS_TOKEN

请求示例：

{
	"rule_id":"xxxx",
	"rule_name":"rulename",
	"word_list":[
	  "敏感词1","敏感词2"
	],
	"extra_rule":{
			"semantics_list":[1,2,3],
	},
	"intercept_type":1,
	"add_applicable_range":{
		"user_list":["zhangshan"],
		"department_list":[2,3]
	},
	"remove_applicable_range":{
		"user_list":["zhangshan"],
		"department_list":[2,3]
	}
}
参数说明：

参数	必须	说明
access_token	是	调用接口凭证
rule_id	是	规则id
rule_name	否	规则名称，长度1~20个utf8字符
word_list	否	敏感词列表，敏感词长度1~32个utf8字符，列表大小不能超过300个；若为空忽略该字段
extra_rule	否	额外的规则
semantics_list	否	额外的拦截语义规则，1：手机号、2：邮箱地:、3：红包；若为空表示清楚所有的语义规则
intercept_type	否	拦截方式，1:警告并拦截发送；2:仅发警告
add_applicable_range	否	需要新增的使用范围
add_applicable_range.user_list	否	可使用的userid列表，必须为应用可见范围内的成员；每次最多支持传1000个节点；该规则最多可包含的userid总数上限为10000个。若超过建议设置部门id
add_applicable_range.department_list	否	可使用的部门列表，必须为应用可见范围内的部门；最多支持传1000个节点
remove_applicable_range	否	需要删除的使用范围
remove_applicable_range.user_list	否	可使用的userid列表，必须为应用可见范围内的成员；最多支持传1000个节点
remove_applicable_range.department_list	否	可使用的部门列表，必须为应用可见范围内的部门；最多支持传1000个节点
注：除rule_id外，需要更新的字段才填，不需更新的字段可不填。
权限说明:

企业需要使用“客户联系”secret或配置到“可调用应用”列表中的自建应用secret所获取的accesstoken来调用（accesstoken如何获取？）。
第三方应用或者代开发自建应用调用需要企业授权客户联系下管理敏感词的权限
应用只可修改应用自己创建的敏感词规则；客户联系系统应用可修改所有规则
返回结果:

{
    "errcode":0,
    "errmsg":"ok"
}
参数说明:

参数	说明
errcode	返回码
errmsg	对返回码的文本描述内容
     */
    public function update(\Qyweixin\Model\ExternalContact\InterceptRule $interceptRule)
    {
        $params = $interceptRule->getParams();
        $rst = $this->_request->post($this->_url . 'update_intercept_rule', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 删除敏感词规则
企业和第三方应用可以通过此接口修改敏感词规则
请求方式：POST(HTTPS)
请求地址：https://qyapi.weixin.qq.com/cgi-bin/externalcontact/del_intercept_rule?access_token=ACCESS_TOKEN

请求示例：

{
	"rule_id":"xxx"
}
参数说明：

参数	必须	说明
access_token	是	调用接口凭证
rule_id	是	规则id
权限说明:

企业需要使用“客户联系”secret或配置到“可调用应用”列表中的自建应用secret所获取的accesstoken来调用（accesstoken如何获取？）。
第三方应用或者代开发自建应用调用需要企业授权客户联系下管理敏感词的权限
应用只可删除应用自己创建的敏感词规则；客户联系系统应用可删除所有规则
返回结果:

{
    "errcode":0,
    "errmsg":"ok"
}
参数说明:

参数	说明
errcode	返回码
errmsg	对返回码的文本描述内容
     */
    public function del($rule_id)
    {
        $params = array();
        $params['rule_id'] = $rule_id;
        $rst = $this->_request->post($this->_url . 'del_intercept_rule', $params);
        return $this->_client->rst($rst);
    }
}
