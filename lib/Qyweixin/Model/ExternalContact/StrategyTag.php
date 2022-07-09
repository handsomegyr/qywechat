<?php

namespace Qyweixin\Model\ExternalContact;

/**
 * 为指定规则组创建企业客户标签
 */
class StrategyTag extends \Qyweixin\Model\Base
{
    /**
     * strategy_id	是	规则组id
     */
    public $strategy_id = NULL;
    /**
     * group_id 否 标签组id
     */
    public $group_id = NULL;

    /**
     * group_name 否 标签组名称，最长为30个字符
     */
    public $group_name = NULL;

    /**
     * order 否 标签组次序值。order值大的排序靠前。有效的值范围是[0, 2^32)
     */
    public $order = NULL;

    /**
     * tag.name 是 添加的标签名称，最长为30个字符
     * tag.order 否 标签次序值。order值大的排序靠前。有效的值范围是[0, 2^32)
     * 
     * @var array
     */
    public $tag = NULL;

    // /**
    //  * agentid	否	授权方安装的应用agentid。仅旧的第三方多应用套件需要填此参数
    //  */
    // public $agentid = NULL;

    public function __construct($strategy_id, array $tag)
    {
        $this->strategy_id = $strategy_id;
        $this->tag = $tag;
    }

    public function getParams()
    {
        $params = array();
        if ($this->isNotNull($this->strategy_id)) {
            $params['strategy_id'] = $this->strategy_id;
        }
        if ($this->isNotNull($this->group_id)) {
            $params['group_id'] = $this->group_id;
        }
        if ($this->isNotNull($this->group_name)) {
            $params['group_name'] = $this->group_name;
        }
        if ($this->isNotNull($this->order)) {
            $params['order'] = $this->order;
        }
        if ($this->isNotNull($this->tag)) {
            $params['tag'] = $this->tag;
        }
        // if ($this->isNotNull($this->agentid)) {
        //     $params['agentid'] = $this->agentid;
        // }
        return $params;
    }
}
