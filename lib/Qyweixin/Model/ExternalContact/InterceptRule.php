<?php

namespace Qyweixin\Model\ExternalContact;

/**
 * 聊天敏感词构体
 */
class InterceptRule extends \Qyweixin\Model\Base
{
    /**
     * rule_id	是	规则id
     */
    public $rule_id = NULL;

    /**
     * rule_name	是	规则名称，长度1~20个utf8字符
     */
    public $rule_name = NULL;

    /**
     * word_list	是	敏感词列表，敏感词长度1~32个utf8字符，列表大小不能超过300个
     */
    public $word_list = NULL;

    /**
     * semantics_list	否	额外的拦截语义规则，1：手机号、2：邮箱地:、3：红包
     */
    public $semantics_list = NULL;

    /**
     * intercept_type	是	拦截方式，1:警告并拦截发送；2:仅发警告
     */
    public $intercept_type = NULL;

    /**
     * applicable_range	是	敏感词适用范围，userid与department不能同时为不填
     * @var \Qyweixin\Model\ExternalContact\ApplicableRange
     */
    public $applicable_range = NULL;

    /**
     * add_applicable_range	否	需要新增的使用范围
     * @var \Qyweixin\Model\ExternalContact\ApplicableRange
     */
    public $add_applicable_range = NULL;

    /**
     * remove_applicable_range	否	需要删除的使用范围
     * @var \Qyweixin\Model\ExternalContact\ApplicableRange
     */
    public $remove_applicable_range = NULL;


    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->rule_id)) {
            $params['rule_id'] = $this->rule_id;
        }

        if ($this->isNotNull($this->rule_name)) {
            $params['rule_name'] = $this->rule_name;
        }
        if ($this->isNotNull($this->word_list)) {
            $params['word_list'] = $this->word_list;
        }
        if ($this->isNotNull($this->semantics_list)) {
            $params['semantics_list'] = $this->semantics_list;
        }
        if ($this->isNotNull($this->intercept_type)) {
            $params['intercept_type'] = $this->intercept_type;
        }
        if ($this->isNotNull($this->applicable_range)) {
            $params['applicable_range'] = $this->applicable_range->getParams();
        }
        if ($this->isNotNull($this->add_applicable_range)) {
            $params['add_applicable_range'] = $this->add_applicable_range->getParams();
        }
        if ($this->isNotNull($this->remove_applicable_range)) {
            $params['remove_applicable_range'] = $this->remove_applicable_range->getParams();
        }
        return $params;
    }
}
