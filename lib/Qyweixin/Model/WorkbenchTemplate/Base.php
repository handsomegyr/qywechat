<?php

namespace Qyweixin\Model\WorkbenchTemplate;

/**
 * 工作台展示的模版类型构体
 */
class Base extends \Qyweixin\Model\Base
{

    /**
     * type 是 模版类型，目前支持的自定义类型包括 “keydata”、 “image”、 “list”、 “webview” 。若设置的type为 “normal”,则相当于从自定义模式切换为普通宫格或者列表展示模式
     */
    protected $type = NULL;

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->type)) {
            $params['type'] = $this->type;
        }

        return $params;
    }
}
