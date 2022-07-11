<?php

namespace Qyweixin\Model\Message;

/**
 * 更新按钮为不可点击状态构体
 */
class ReplaceButton extends \Qyweixin\Model\Message\Base
{
    /**
     * msgtype 是 消息类型，此时固定为：button
     */
    protected $msgtype = 'button';

    /**
     * replace_name	是	需要更新的按钮的文案
     */
    public $replace_name = NULL;

    public function getParams()
    {
        $params = parent::getParams();

        if ($this->isNotNull($this->replace_name)) {
            $params[$this->msgtype]['replace_name'] = $this->replace_name;
        }

        return $params;
    }
}
