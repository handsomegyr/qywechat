<?php

namespace Qyweixin\Model\ExternalContact;

/**
 * 敏感词适用范围构体
 */
class ApplicableRange extends \Qyweixin\Model\Base
{

    /**
     * user_list	否	可使用的userid列表。必须为应用可见范围内的成员；最多支持传1000个节点
     */
    public $user_list = NULL;

    /**
     * department_list	否	可使用的部门列表，必须为应用可见范围内的部门；最多支持传1000个节点
     */
    public $department_list = NULL;

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->user_list)) {
            $params['user_list'] = $this->user_list;
        }
        if ($this->isNotNull($this->department_list)) {
            $params['department_list'] = $this->department_list;
        }
        return $params;
    }
}
