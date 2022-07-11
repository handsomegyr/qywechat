<?php

namespace Qyweixin\Model\Message\TemplateCard;

/**
 * 按钮构体
 */
class Button extends \Qyweixin\Model\Message\Base
{
    /** button_list.type	否	按钮点击事件类型，0 或不填代表回调点击事件，1 代表跳转url */
    public $type = NULL;
    /** button_list.text	是	按钮文案，建议不超过10个字 */
    public $text = NULL;
    /** button_list.style	否	按钮样式，目前可填1~4，不填或错填默认1 */
    public $style = NULL;
    /** button_list.key	否	按钮key值，用户点击后，会产生回调事件将本参数作为EventKey返回，回调事件会带上该key值，最长支持1024字节，不可重复，button_list.type是0时必填 */
    public $key = NULL;
    /** button_list.url	否	跳转事件的url，button_list.type是1时必填 */
    public $url = NULL;

    public function getParams()
    {
        $params = parent::getParams();

        if ($this->isNotNull($this->type)) {
            $params['type'] = $this->type;
        }
        if ($this->isNotNull($this->text)) {
            $params['text'] = $this->text;
        }
        if ($this->isNotNull($this->style)) {
            $params['style'] = $this->style;
        }
        if ($this->isNotNull($this->key)) {
            $params['key'] = $this->key;
        }
        if ($this->isNotNull($this->url)) {
            $params['url'] = $this->url;
        }
        return $params;
    }
}
