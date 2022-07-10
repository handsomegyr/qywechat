<?php

namespace Qyweixin\Model\ExternalContact;

/**
 * 朋友圈的客户列表构体
 */
class ExternalContactList extends \Qyweixin\Model\Base
{

    /**
     * tag_list	否	可见到该朋友圈的客户标签列表
     */
    public $tag_list = NULL;

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->tag_list)) {
            $params['tag_list'] = $this->tag_list;
        }

        return $params;
    }
}
