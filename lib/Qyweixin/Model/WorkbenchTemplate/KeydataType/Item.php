<?php

namespace Qyweixin\Model\WorkbenchTemplate\KeydataType;

/**
 * 关键数型数据
 */
class Item extends \Qyweixin\Model\WorkbenchTemplate\Base
{
    /**
     * key	否	关键数据名称，需要设置在模版中
     */
    public $key = NULL;

    /**
     * data	是	关键数据
     */
    public $data = NULL;

    /**
     * jump_url	否	点击跳转url，若不填且应用设置了主页url，则跳转到主页url，否则跳到应用会话窗口
     */
    public $jump_url = NULL;
    /**
     * pagepath	否	若应用为小程序类型，该字段填小程序pagepath，若未设置，跳到小程序主页
     */
    public $pagepath = NULL;

    public function __construct($data)
    {
        $this->type = null;
        $this->data = $data;
    }

    public function getParams()
    {
        $params = parent::getParams();

        if ($this->isNotNull($this->key)) {
            $params['key'] = $this->key;
        }
        if ($this->isNotNull($this->data)) {
            $params['data'] = $this->data;
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
