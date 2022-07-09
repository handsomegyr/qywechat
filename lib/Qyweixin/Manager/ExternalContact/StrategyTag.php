<?php

namespace Qyweixin\Manager\ExternalContact;

use Qyweixin\Client;

/**
 * 管理企业规则组下的客户标签
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class StrategyTag
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
     * 获取指定规则组下的企业客户标签
     * 企业可通过此接口获取某个规则组内的企业客户标签详情。
     *
     *
     *
     * 请求方式: POST(HTTP)
     *
     * 请求地址:https://qyapi.weixin.qq.com/cgi-bin/externalcontact/get_strategy_tag_list?access_token=ACCESS_TOKEN
     *
     * 请求示例:
     *
     * {
     * "strategy_id":1,
     * "tag_id":
     * [
     * "etXXXXXXXXXX",
     * "etYYYYYYYYYY"
     * ],
     * "group_id":
     * [
     * "etZZZZZZZZZZZZZ",
     * "etYYYYYYYYYYYYY"
     * ]
     * }
     *
     *
     * 参数说明:
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * strategy_id 否 规则组id
     * tag_id 否 要查询的标签id
     * group_id 否 要查询的标签组id，返回该标签组以及其下的所有标签信息
     * 若tag_id和group_id均为空，则返回所有标签。
     * 同时传递tag_id和group_id时，忽略tag_id，仅以group_id作为过滤条件。
     *
     *
     * 返回结果:
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "tag_group": [{
     * "group_id": "TAG_GROUPID1",
     * "group_name": "GOURP_NAME",
     * "create_time": 1557838797,
     * "order": 1,
     * "strategy_id":1,
     * "tag": [{
     * "id": "TAG_ID1",
     * "name": "NAME1",
     * "create_time": 1557838797,
     * "order": 1
     * },
     * {
     * "id": "TAG_ID2",
     * "name": "NAME2",
     * "create_time": 1557838797,
     * "order": 2
     * }
     * ]
     * }]
     * }
     * 参数说明:
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     * tag_group 标签组列表
     * tag_group.group_id 标签组id
     * tag_group.group_name 标签组名称
     * tag_group.create_time 标签组创建时间
     * tag_group.order 标签组排序的次序值，order值大的排序靠前。有效的值范围是[0, 2^32)
     * tag_group.strategy_id 标签组所属的规则组id
     * tag_group.tag 标签组内的标签列表
     * tag_group.tag.id 标签id
     * tag_group.tag.name 标签名称
     * tag_group.tag.create_time 标签创建时间
     * tag_group.tag.order 标签排序的次序值，order值大的排序靠前。有效的值范围是[0, 2^32)
     */
    public function getList($strategy_id = 0, array $tag_id = array(), array $group_id = array())
    {
        $params = array();
        if (!empty($strategy_id)) {
            $params['strategy_id'] = $strategy_id;
        }
        if (!empty($tag_id)) {
            $params['tag_id'] = $tag_id;
        }
        if (!empty($group_id)) {
            $params['group_id'] = $group_id;
        }
        $rst = $this->_request->post($this->_url . 'get_strategy_tag_list', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 为指定规则组创建企业客户标签
     * 企业可通过此接口向规则组中添加新的标签组和标签，每个企业的企业标签和规则组标签合计最多可配置3000个。注意，仅可在一级规则组下添加标签。
     *
     *
     *
     * 请求方式: POST(HTTP)
     *
     * 请求地址:https://qyapi.weixin.qq.com/cgi-bin/externalcontact/add_strategy_tag?access_token=ACCESS_TOKEN
     *
     * 请求示例:
     *
     * {
     * "strategy_id":1,
     * "group_id": "GROUP_ID",
     * "group_name": "GROUP_NAME",
     * "order": 1,
     * "tag": [{
     * "name": "TAG_NAME_1",
     * "order": 1
     * },
     * {
     * "name": "TAG_NAME_2",
     * "order": 2
     * }
     * ]
     * }
     * 参数说明:
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * strategy_id 是 规则组id
     * group_id 否 标签组id
     * group_name 否 标签组名称，最长为30个字符
     * order 否 标签组次序值。order值大的排序靠前。有效的值范围是[0, 2^32)
     * tag.name 是 添加的标签名称，最长为30个字符
     * tag.order 否 标签次序值。order值大的排序靠前。有效的值范围是[0, 2^32)
     * 注意:
     * 如果填写了group_id参数，则group_name和标签组的order参数会被忽略。
     * 如果填写的group_name和此规则组下的其他标签组同名，则会将相关标签加入已存在的同名标签组下
     * 不支持创建空标签组。
     * 标签组内的标签不可同名，如果传入多个同名标签，则只会创建一个。
     *
     *
     * 返回结果:
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "tag_group": {
     * "group_id": "TAG_GROUPID1",
     * "group_name": "GOURP_NAME",
     * "create_time": 1557838797,
     * "order": 1,
     * "tag": [{
     * "id": "TAG_ID1",
     * "name": "NAME1",
     * "create_time": 1557838797,
     * "order": 1
     * },
     * {
     * "id": "TAG_ID2",
     * "name": "NAME2",
     * "create_time": 1557838797,
     * "order": 2
     * }
     * ]
     * }
     * }
     * 参数说明:
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     * tag_group.group_id 标签组id
     * tag_group.group_name 标签组名称
     * tag_group.create_time 标签组创建时间
     * tag_group.order 标签组次序值。order值大的排序靠前。有效的值范围是[0, 2^32)
     * tag_group.tag 标签组内的标签列表
     * tag_group.tag.id 新建标签id
     * tag_group.tag.name 新建标签名称
     * tag_group.tag.create_time 标签创建时间
     * tag_group.tag.order 标签次序值。order值大的排序靠前。有效的值范围是[0, 2^32)
     */
    public function add(\Qyweixin\Model\ExternalContact\StrategyTag $strategyTag)
    {
        $params = $strategyTag->getParams();
        $rst = $this->_request->post($this->_url . 'add_strategy_tag', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 编辑指定规则组下的企业客户标签
     * 企业可通过此接口编辑指定规则组下的客户标签/标签组的名称或次序值，但不可重新指定标签/标签组所属规则组。
     *
     *
     *
     * 请求方式: POST(HTTP)
     *
     * 请求地址:https://qyapi.weixin.qq.com/cgi-bin/externalcontact/edit_strategy_tag?access_token=ACCESS_TOKEN
     *
     * 请求示例:
     *
     * {
     * "id": "TAG_ID",
     * "name": "NEW_TAG_NAME",
     * "order": 1,
     *
     * }
     * 参数说明:
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * id 是 标签或标签组的id
     * name 否 新的标签或标签组名称，最长为30个字符
     * order 否 标签/标签组的次序值。order值大的排序靠前。有效的值范围是[0, 2^32)
     *
     *
     * 注意:修改后的标签组不能和已有的标签组重名，标签也不能和同一标签组下的其他标签重名。
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
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     */
    public function edit($id, $name = "", $order = "")
    {
        $params = array();
        $params['id'] = $id;
        if (!empty($name)) {
            $params['name'] = $name;
        }
        if (!empty($order)) {
            $params['order'] = $order;
        }
        $rst = $this->_request->post($this->_url . 'edit_strategy_tag', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 删除指定规则组下的企业客户标签
     * 企业可通过此接口删除某个规则组下的标签，或删除整个标签组。
     *
     * 请求方式: POST(HTTP)
     *
     * 请求地址:https://qyapi.weixin.qq.com/cgi-bin/externalcontact/del_strategy_tag?access_token=ACCESS_TOKEN
     *
     * 请求示例:
     *
     * {
     * "tag_id": [
     * "TAG_ID_1",
     * "TAG_ID_2"
     * ],
     * "group_id": [
     * "GROUP_ID_1",
     * "GROUP_ID_2"
     * ],
     * }
     * 参数说明:
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * tag_id 否 标签的id列表
     * group_id 否 标签组的id列表
     *
     *
     * tag_id和group_id不可同时为空。
     * 如果一个标签组下所有的标签均被删除，则标签组会被自动删除。
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
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     */
    public function del($tag_id, $group_id)
    {
        $params = array();
        if (empty($tag_id) && empty($group_id)) {
            throw new \Exception('tag_id和group_id不可同时为空');
        }
        if (!empty($tag_id)) {
            $params['tag_id'] = $tag_id;
        }
        if (!empty($group_id)) {
            $params['group_id'] = $group_id;
        }
        // if (!empty($agentid)) {
        // $params['agentid'] = $agentid;
        // }
        $rst = $this->_request->post($this->_url . 'del_strategy_tag', $params);
        return $this->_client->rst($rst);
    }
}
