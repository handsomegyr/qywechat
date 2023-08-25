<?php

namespace Qyweixin\Manager\Kf;

use Qyweixin\Client;

/**
 * 知识库分组管理
 * https://developer.work.weixin.qq.com/document/path/95971
 * 知识库问答管理
 * https://developer.work.weixin.qq.com/document/path/95972
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class Knowledge
{

    // 接口地址
    private $_url = 'https://qyapi.weixin.qq.com/cgi-bin/kf/knowledge/';
    private $_client;
    private $_request;
    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 添加分组
     * 可通过此接口创建新的知识库分组。
     *
     * 请求方式: POST (HTTPS)
     *
     * 请求地址: https://qyapi.weixin.qq.com/cgi-bin/kf/knowledge/add_group?access_token=ACCESS_TOKEN
     *
     * 请求示例:
     *
     * {
     * "name": "分组名"
     * }
     *
     *
     * 参数说明:
     *
     * 参数 类型 必须 说明
     * access_token string 是 调用接口凭证
     * name stirng 是 分组名。不超过12个字
     *
     *
     * 返回结果:
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "group_id" "GROUP_ID"
     * }
     * 参数说明:
     *
     * 参数 类型 说明
     * errcode int32 返回码
     * errmsg string 错误码描述
     * group_id string 分组ID
     */
    public function addGroup($name)
    {
        $params = array();
        $params['name'] = $name;

        $rst = $this->_request->post($this->_url . 'add_group', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 删除分组
     * 可通过此接口删除已有的知识库分组，但不能删除系统创建的默认分组。
     *
     * 请求方式: POST (HTTPS)
     *
     * 请求地址: https://qyapi.weixin.qq.com/cgi-bin/kf/knowledge/del_group?access_token=ACCESS_TOKEN
     *
     * 请求示例:
     *
     * {
     * "group_id": "GROUP_ID"
     * }
     *
     *
     * 参数说明:
     *
     * 参数 类型 必须 说明
     * access_token string 是 调用接口凭证
     * group_id string 是 分组ID
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
    public function delGroup($group_id)
    {
        $params = array();
        $params['group_id'] = $group_id;
        $rst = $this->_request->post($this->_url . 'del_group', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 修改分组
     * 可通过此接口修改已有的知识库分组，但不能修改系统创建的默认分组。
     *
     * 请求方式: POST (HTTPS)
     *
     * 请求地址: https://qyapi.weixin.qq.com/cgi-bin/kf/knowledge/mod_group?access_token=ACCESS_TOKEN
     *
     * 请求示例:
     *
     * {
     * "group_id": "GROUP_ID"，
     * "name": "分组名"
     * }
     * 参数说明:
     *
     * 参数 类型 必须 说明
     * access_token string 是 调用接口凭证
     * group_id string 是 分组ID
     * name stirng 是 分组名。不超过12个字
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
     * group_id string 分组ID
     */
    public function modGroup($group_id, $name)
    {
        $params = array();
        $params['group_id'] = $group_id;
        $params['name'] = $name;
        $rst = $this->_request->post($this->_url . 'mod_group', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 获取分组列表
     * 可通过此接口分页获取所有的知识库分组。
     *
     * 请求方式: POST (HTTPS)
     *
     * 请求地址: https://qyapi.weixin.qq.com/cgi-bin/kf/knowledge/list_group?access_token=ACCESS_TOKEN
     *
     * 请求示例:
     *
     * {
     * "cursor": "CURSOR"，
     * "limit": 100,
     * "group_id": "GROUP_ID"
     * }
     * 参数说明:
     *
     * 参数 类型 必须 说明
     * access_token string 是 调用接口凭证
     * cursor string 否 上一次调用时返回的next_cursor，第一次拉取可以不填
     * limit uint32 否 每次拉取的数据量，默认值500，最大值为1000
     * group_id string 否 分组ID。可指定拉取特定的分组
     * 返回结果:
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "next_cursor": "NEXT_CURSOR",
     * "has_more"：1,
     * "group_list": [
     * {
     * "group_id": "GROUP_ID",
     * "name": "NAME",
     * "is_default": 1
     * }, {
     * "group_id": "GROUP_ID",
     * "name": "NAME",
     * "is_default": 0
     * }
     * ]
     * }
     * 参数说明:
     *
     * 参数 类型 说明
     * errcode int32 返回码
     * errmsg string 错误码描述
     * next_cursor string 分页游标，再下次请求时填写以获取之后分页的记录
     * has_more uint32 是否还有更多数据。0-没有 1-有
     * group_list obj[] 分组列表
     * group_list[].group_id string 分组ID
     * group_list[].name string 分组名
     * group_list[].is_default uint32 是否为默认分组。0-否 1-是。默认分组为系统自动创建，不可修改/删除
     */
    public function listGroup($cursor = "", $limit = 1000, $group_id = "")
    {
        $params = array();
        $params['cursor'] = $cursor;
        $params['limit'] = $limit;
        $params['group_id'] = $group_id;
        $rst = $this->_request->post($this->_url . 'list_group', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 添加问答
     * 可通过此接口创建新的知识库问答。
     *
     * 请求方式: POST (HTTPS)
     *
     * 请求地址: https://qyapi.weixin.qq.com/cgi-bin/kf/knowledge/add_intent?access_token=ACCESS_TOKEN
     *
     * 请求示例:
     *
     * {
     * "group_id": "GROUP_ID",
     * "question": {
     * "text": {
     * "content": "主问题"
     * }
     * },
     * "similar_questions": {
     * "items": [
     * {
     * "text": {
     * "content": "相似问题1"
     * }
     * },
     * {
     * "text": {
     * "content": "相似问题2"
     * }
     * }
     * ]
     * },
     * "answers": [
     * {
     * "text": {
     * "content": "问题的回复"
     * },
     * "attachments": [
     * {
     * "msgtype": "image",
     * "image": {
     * "media_id": "MEDIA_ID"
     * }
     * }
     * ]
     * }
     * ]
     * }
     *
     *
     * 参数说明:
     *
     * 参数 类型 必须 说明
     * access_token string 是 调用接口凭证
     * group_id string 是 分组ID
     * question obj 是 主问题
     * question.text obj 是 主问题文本
     * question.text.content string 是 主问题文本内容。不超过200个字
     * similar_questions obj 否 相似问题
     * similar_questions.items obj[] 否 相似问题列表。最多支持100个
     * similar_questions.items[].text obj 是 相似问题文本
     * similar_questions.items[].text.content string 是 相似问题文本内容。不超过200个字
     * answers obj[] 是 回答列表。目前仅支持1个
     * answers[].text obj 是 回答文本
     * answers[].text.content string 是 回答文本内容。不超过500个字
     * answers[].attachments obj[] 否 回答附件列表。最多支持4个
     * answers[].attachments[].* obj 是 回答附件。具体见附录-问答附件类型
     *
     *
     * 返回结果:
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "intent_id": "INTENT_ID"
     * }
     * 参数说明:
     *
     * 参数 类型 说明
     * errcode int32 返回码
     * errmsg string 错误码描述
     * intent_id string 问答ID
     */
    public function addIntent(\Qyweixin\Model\Kf\Knowledge\Intent $intent)
    {
        $params = $intent->getParams();

        $rst = $this->_request->post($this->_url . 'add_intent', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 删除问答
     * 可通过此接口删除已有的知识库问答。
     *
     * 请求方式: POST (HTTPS)
     *
     * 请求地址: https://qyapi.weixin.qq.com/cgi-bin/kf/knowledge/del_intent?access_token=ACCESS_TOKEN
     *
     * 请求示例:
     *
     * {
     * "intent_id": "INTENT_ID"
     * }
     *
     *
     * 参数说明:
     *
     * 参数 类型 必须 说明
     * access_token string 是 调用接口凭证
     * intent_id string 是 问答ID
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
    public function delIntent($intent_id)
    {
        $params = array();
        $params['intent_id'] = $intent_id;

        $rst = $this->_request->post($this->_url . 'del_intent', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 修改问答
     * 可通过此接口修改已有的知识库问答。
     * question/similar_questions/answers这三部分可以按需更新，但更新的每一部分是覆盖写，需要传完整的字段。
     *
     * 请求方式: POST (HTTPS)
     *
     * 请求地址: https://qyapi.weixin.qq.com/cgi-bin/kf/knowledge/mod_intent?access_token=ACCESS_TOKEN
     *
     * 请求示例:
     *
     * {
     * "intent_id": "INTENT_ID",
     * "question": {
     * "text": {
     * "content": "主问题"
     * }
     * },
     * "similar_questions": {
     * "items": [
     * {
     * "text": {
     * "content": "相似问题1"
     * }
     * },
     * {
     * "text": {
     * "content": "相似问题2"
     * }
     * }
     * ]
     * },
     * "answers": [
     * {
     * "text": {
     * "content": "问题的回复"
     * },
     * "attachments": [
     * {
     * "msgtype": "image",
     * "image": {
     * "media_id": "MEDIA_ID"
     * }
     * }
     * ]
     * }
     * ]
     * }
     * 参数说明:
     *
     * 参数 类型 必须 说明
     * access_token string 是 调用接口凭证
     * intent_id string 是 问答ID
     * question obj 否 主问题
     * question.text obj 否 主问题文本
     * question.text.content string 是 主问题文本内容
     * similar_questions obj 否 相似问题
     * similar_questions.items obj[] 否 相似问题列表。最多支持100个
     * similar_questions.items[].text obj 是 相似问题文本
     * similar_questions.items[].text.content string 是 相似问题文本内容
     * answers obj[] 否 回答列表。目前仅支持1个
     * answers[].text obj 是 回答文本
     * answers[].text.content string 是 回答文本内容
     * answers[].attachments obj[] 否 回答附件列表。最多支持4个
     * answers[].attachments[].* obj 是 回答附件。具体见附录-问答附件类型
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
     * intent_id string 问答ID
     */
    public function modIntent(\Qyweixin\Model\Kf\Knowledge\Intent $intent)
    {
        $params = $intent->getParams();

        $rst = $this->_request->post($this->_url . 'mod_intent', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 获取问答列表
     * 可通过此接口分页获取的知识库问答详情列表。
     *
     * 请求方式: POST (HTTPS)
     *
     * 请求地址: https://qyapi.weixin.qq.com/cgi-bin/kf/knowledge/list_intent?access_token=ACCESS_TOKEN
     *
     * 请求示例:
     *
     * {
     * "cursor": "CURSOR"，
     * "limit": 100,
     * "group_id": "GROUP_ID",
     * "intent_id": "INTENT_ID"
     * }
     * 参数说明:
     *
     * 参数 类型 必须 说明
     * access_token string 是 调用接口凭证
     * cursor string 否 上一次调用时返回的next_cursor，第一次拉取可以不填
     * limit uint32 否 每次拉取的数据量，默认值500，最大值为1000
     * group_id string 否 分组ID。可指定拉取特定分组下的问答
     * intent_id string 否 问答ID。可指定拉取特定的问答
     *
     *
     * 返回结果:
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "next_cursor": "NEXT_CURSOR",
     * "has_more": 1,
     * "intent_list": [
     * {
     * "group_id": "GROUP_ID",
     * "intent_id": "INTENT_ID",
     * "question": {
     * "text": {
     * "content": "主问题"
     * },
     * "similar_questions": {
     * "items": [
     * {
     * "text": {
     * "content": "相似问题1"
     * }
     * },
     * {
     * "text": {
     * "content": "相似问题2"
     * }
     * }
     * ]
     * },
     * "answers": [
     * {
     * "text": {
     * "content": "问题的回复"
     * },
     * "attachments": [
     * {
     * "msgtype": "image",
     * "image": {
     * "name": "图片（仅返回名字）.jpg"
     * }
     * }
     * ]
     * }
     * ]
     * }
     * }
     * ]
     * }
     * 参数说明:
     *
     * 参数 类型 说明
     * errcode int32 返回码
     * errmsg string 错误码描述
     * next_cursor string 分页游标，再下次请求时填写以获取之后分页的记录
     * has_more uint32 是否还有更多数据。0-没有 1-有
     * intent_list obj[] 问答摘要列表
     * intent_list[].group_id string 分组ID
     * intent_list[].intent_id string 问答ID
     * intent_list[].question obj 主问题
     * intent_list[].question.text obj 主问题文本
     * intent_list[].question.text.content string 主问题文本内容
     * intent_list[].similar_questions obj 相似问题
     * intent_list[].similar_questions.items obj[] 相似问题列表。最多支持100个
     * intent_list[].similar_questions.items[].text obj 相似问题文本
     * intent_list[].similar_questions.items[].text.content string 相似问题文本内容
     * intent_list[].answers obj[] 回答列表。目前仅支持1个
     * intent_list[].answers[].text obj 回答文本
     * intent_list[].answers[].text.content string 回答文本内容
     * intent_list[].answers[].attachments obj[] 回答附件列表。最多支持4个
     * intent_list[].answers[].attachments[].* obj 回答附件。具体见附录-问答附件类型
     */
    public function listIntent($cursor = "", $limit = 1000, $group_id = "", $intent_id = "")
    {
        $params = array();
        $params['cursor'] = $cursor;
        $params['limit'] = $limit;
        $params['group_id'] = $group_id;
        $params['intent_id'] = $intent_id;
        $rst = $this->_request->post($this->_url . 'list_intent', $params);
        return $this->_client->rst($rst);
    }
}
