<?php

namespace Qyweixin\Model\WorkbenchTemplate\ListType;

/**
 * 列表型数据
 */
class Item extends \Qyweixin\Model\WorkbenchTemplate\Base
{

    /**
     * title	是	列表显示文字，不超过128个字节
     */
    public $title = NULL;

    /**
     * jump_url	否	点击跳转url，若不填且应用设置了主页url，则跳转到主页url，否则跳到应用会话窗口
     */
    public $jump_url = NULL;
    /**
     * pagepath	否	若应用为小程序类型，该字段填小程序pagepath，若未设置，跳到小程序主页
     */
    public $pagepath = NULL;

    public function __construct($title)
    {
        $this->type = null;
        $this->title = $title;
    }

    public function getParams()
    {
        $params = parent::getParams();

        if ($this->isNotNull($this->title)) {
            $params['title'] = $this->title;
        }
        if ($this->isNotNull($this->jump_url)) {
            $params['jump_url'] = $this->jump_url;
        }
        if ($this->isNotNull($this->pagepath)) {
            $params['pagepath'] = $this->pagepath;
        }
        return $params;
    }
}
