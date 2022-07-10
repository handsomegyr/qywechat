<?php

namespace Qyweixin\Model\ExternalContact;

/**
 * 规则组构体
 */
class MomentStrategy extends \Qyweixin\Model\Base
{
    /**
     * strategy_id	否	规则组id
     */
    public $strategy_id = NULL;
    /**
     * parent_id	否	父规则组id
     */
    public $parent_id = NULL;

    /**
     * strategy_name	是	规则组名称
     */
    public $strategy_name = NULL;

    /**
     * admin_list	是	规则组管理员userid列表，不可配置超级管理员，每个规则组最多可配置20个负责人
     */
    public $admin_list = NULL;

    /**
     * privilege 基础权限
     *
     * @var \Qyweixin\Model\ExternalContact\MomentStrategy\Privilege
     */
    public $privilege = NULL;

    /**
     * range 规则组的管理范围节点类型
     */
    public $range = NULL;

    /**
     * range 向管理范围添加的节点类型
     */
    public $range_add = NULL;
    /**
     * range 从管理范围删除的节点类型
     */
    public $range_del = NULL;

    public function __construct($strategy_name)
    {
        $this->strategy_name = $strategy_name;
    }

    public function getParams()
    {
        $params = array();
        if ($this->isNotNull($this->strategy_id)) {
            $params['strategy_id'] = $this->strategy_id;
        }
        if ($this->isNotNull($this->parent_id)) {
            $params['parent_id'] = $this->parent_id;
        }
        if ($this->isNotNull($this->strategy_name)) {
            $params['strategy_name'] = $this->strategy_name;
        }
        if ($this->isNotNull($this->admin_list)) {
            $params['admin_list'] = $this->admin_list;
        }
        if ($this->isNotNull($this->privilege)) {
            $params['privilege'] = $this->privilege->getParams();
        }
        if ($this->isNotNull($this->range)) {
            foreach ($this->range as $rangeInfo) {
                $params['range'][] = $rangeInfo->getParams();
            }
        }
        if ($this->isNotNull($this->range_add)) {
            foreach ($this->range_add as $rangeInfo) {
                $params['range_add'][] = $rangeInfo->getParams();
            }
        }
        if ($this->isNotNull($this->range_del)) {
            foreach ($this->range_del as $rangeInfo) {
                $params['range_del'][] = $rangeInfo->getParams();
            }
        }
        return $params;
    }
}
