<?php

namespace Qyweixin\Model\WorkbenchTemplate;

/**
 * webview型
 */
class WebviewType extends \Qyweixin\Model\WorkbenchTemplate\Base
{
    /**
     * type 是 类型，此时固定为：webview型 image
     */
    protected $type = 'webview';

    /**
     * url	否	渲染展示的url
     */
    public $url = NULL;
    /**
     * jump_url	否	点击跳转url。若不填且应用设置了主页url，则跳转到主页url，否则跳到应用会话窗口
     */
    public $jump_url = NULL;
    /**
     * pagepath	否	若应用为小程序类型，该字段填小程序pagepath，若未设置，跳到小程序主页
     */
    public $pagepath = NULL;

    public function __construct()
    {
    }

    public function getParams()
    {
        $params = parent::getParams();

        if ($this->isNotNull($this->url)) {
            $params[$this->type]['url'] = $this->url;
        }
        if ($this->isNotNull($this->jump_url)) {
            $params[$this->type]['jump_url'] = $this->jump_url;
        }
        if ($this->isNotNull($this->pagepath)) {
            $params[$this->type]['pagepath'] = $this->pagepath;
        }
        return $params;
    }
}
