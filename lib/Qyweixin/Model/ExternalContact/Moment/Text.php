<?php

namespace Qyweixin\Model\ExternalContact\Moment;

/**
 * 消息文本内容构体
 */
class Text extends \Qyweixin\Model\Base
{

    /**
     * text.content 消息文本内容，不能与附件同时为空，最多支持传入2000个字符，若超出长度报错'invalid text size'
     */
    public $content = NULL;

    public function __construct($content)
    {
        $this->content = $content;
    }

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->content)) {
            $params['content'] = $this->content;
        }

        return $params;
    }
}
