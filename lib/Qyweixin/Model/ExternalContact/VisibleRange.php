<?php

namespace Qyweixin\Model\ExternalContact;

/**
 * 指定的发表范围构体
 */
class VisibleRange extends \Qyweixin\Model\Base
{

    /**
     * sender_list	否	发表任务的执行者列表，详见下文的“可见范围说明
     * @var \Qyweixin\Model\ExternalContact\SenderList
     */
    public $sender_list = NULL;

    /**
     * external_contact_list	否	可见到该朋友圈的客户列表，详见下文的“可见范围说明”
     * @var \Qyweixin\Model\ExternalContact\ExternalContactList
     */
    public $external_contact_list = NULL;

    public function __construct($type)
    {
        $this->type = $type;
    }

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->sender_list)) {
            $params['sender_list'] = $this->sender_list->getParams();
        }
        if ($this->isNotNull($this->external_contact_list)) {
            $params['external_contact_list'] = $this->external_contact_list->getParams();
        }
        return $params;
    }
}
