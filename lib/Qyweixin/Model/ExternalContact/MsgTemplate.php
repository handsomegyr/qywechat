<?php

namespace Qyweixin\Model\ExternalContact;

/**
 * 企业群发消息任务
 */
class MsgTemplate extends \Qyweixin\Model\Base
{
    /**
     * chat_type 否 群发任务的类型，默认为single，表示发送给客户，group表示发送给客户群
     */
    public $chat_type = NULL;

    /**
     * external_userid 否 客户的外部联系人id列表，仅在chat_type为single时有效，不可与sender同时为空，最多可传入1万个客户
     */
    public $external_userid = NULL;

    /**
     * sender 否 发送企业群发消息的成员userid，当类型为发送给客户群时必填
     */
    public $sender = NULL;

    /**
     * text 消息文本
     *
     * @var \Qyweixin\Model\ExternalContact\Conclusion\Text
     */
    public $text = NULL;

    /**
     * 是否允许成员在待发送客户列表中重新进行选择，默认为false
     */
    public $allow_select = NULL;

    // /**
    //  * image 图片
    //  *
    //  * @var \Qyweixin\Model\ExternalContact\Conclusion\Image
    //  */
    // public $image = NULL;

    // /**
    //  * link 图文消息
    //  *
    //  * @var \Qyweixin\Model\ExternalContact\Conclusion\Link
    //  */
    // public $link = NULL;

    // /**
    //  * miniprogram 小程序消息
    //  *
    //  * @var \Qyweixin\Model\ExternalContact\Conclusion\Miniprogram
    //  */
    // public $miniprogram = NULL;

    /**
     * attachments	否	附件，最多支持添加9个附件
     *
     * @var array
     */
    public $attachments = NULL;

    public function __construct()
    {
    }

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->chat_type)) {
            $params['chat_type'] = $this->chat_type;
        }
        if ($this->isNotNull($this->external_userid)) {
            $params['external_userid'] = $this->external_userid;
        }
        if ($this->isNotNull($this->sender)) {
            $params['sender'] = $this->sender;
        }
        if ($this->isNotNull($this->text)) {
            $params['text'] = $this->text->getParams();
        }
        if ($this->isNotNull($this->allow_select)) {
            $params['allow_select'] = $this->allow_select;
        }
        if ($this->isNotNull($this->attachments)) {
            foreach ($this->attachments as $attachment) {
                $params['attachments'][] = $attachment->getParams();
            }
        }
        // if ($this->isNotNull($this->image)) {
        //     $params['image'] = $this->image->getParams();
        // }
        // if ($this->isNotNull($this->link)) {
        //     $params['link'] = $this->link->getParams();
        // }
        // if ($this->isNotNull($this->miniprogram)) {
        //     $params['miniprogram'] = $this->miniprogram->getParams();
        // }
        return $params;
    }
}
