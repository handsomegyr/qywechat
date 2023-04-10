<?php

namespace Qyweixin\Model\ExternalContact;

/**
 * 获客链接关联范围
 * range.user_list和range.department_list不可同时为空
 */
class CustomerAcquisitionLinkRange extends \Qyweixin\Model\Base
{

    /**
     * user_list	否	此获客链接关联的userid列表，最多可关联100个
     */
    public $user_list = NULL;

    /**
     * department_list	否	此获客链接关联的部门id列表，部门覆盖总人数最多100个
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
