<?php

namespace Qyweixin\Model\ExternalContact;

/**
 * 新客户欢迎语
 */
class WelcomeMsg extends \Qyweixin\Model\Base
{

    /**
     * welcome_code 是 通过添加外部联系人事件推送给企业的发送欢迎语的凭证，有效期为20秒*
     */
    public $welcome_code = NULL;

    /**
     * text 消息文本
     *
     * @var \Qyweixin\Model\ExternalContact\Conclusion\Text
     */
    public $text = NULL;

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

    public function __construct($welcome_code)
    {
        $this->welcome_code = $welcome_code;
    }

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->welcome_code)) {
            $params['welcome_code'] = $this->welcome_code;
        }
        if ($this->isNotNull($this->text)) {
            $params['text'] = $this->text->getParams();
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
