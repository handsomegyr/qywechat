<?php

namespace Qyweixin\Model\Kf\Msg;

/**
 * 文本消息构体
 */
class Text extends \Qyweixin\Model\Kf\Msg\MsgBase
{

    /**
     * msgtype	是	string	消息类型，此时固定为：text
     */
    protected $msgtype = 'text';
    /**
     * content	是	string	消息内容，最长不超过2048个字节
     */
    public $content = NULL;

    public function __construct()
    {
    }

    public function getParams()
    {
        $params = parent::getParams();

        if ($this->isNotNull($this->content)) {
            $params[$this->msgtype]['content'] = $this->content;
        }
        return $params;
    }
}
