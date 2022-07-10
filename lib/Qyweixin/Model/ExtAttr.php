<?php

namespace Qyweixin\Model;

/**
 * 自定义字段构体
 */
class ExtAttr extends \Qyweixin\Model\Base
{

    /**
     * attrs 是 自定义字段
     */
    public $attrs = NULL;

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->attrs)) {
            foreach ($this->attrs as $attr) {
                $params['attrs'][] = $attr->getParams();
            }
        }
        return $params;
    }
}
