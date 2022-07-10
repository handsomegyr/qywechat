<?php

namespace Qyweixin\Model\ExternalContact;

/**
 * 消息文本内容构体
 */
class SenderList extends \Qyweixin\Model\Base
{

    /**
     * user_list	否	发表任务的执行者用户列表，最多支持10万个
     */
    public $user_list = NULL;

    /**
     * department_list	否	发表任务的执行者部门列表
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
