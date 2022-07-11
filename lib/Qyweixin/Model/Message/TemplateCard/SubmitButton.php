<?php

namespace Qyweixin\Model\Message\TemplateCard;

/**
 * 提交按钮样式构体
 */
class SubmitButton extends \Qyweixin\Model\Message\Base
{
    /** submit_button.text	是	按钮文案，建议不超过10个字，不填默认为提交 */
    public $text = NULL;
    /** submit_button.key	是	提交按钮的key，会产生回调事件将本参数作为EventKey返回，最长支持1024字节 */
    public $key = NULL;
    public function getParams()
    {
        $params = parent::getParams();

        if ($this->isNotNull($this->text)) {
            $params['text'] = $this->text;
        }
        if ($this->isNotNull($this->key)) {
            $params['key'] = $this->key;
        }
        return $params;
    }
}
