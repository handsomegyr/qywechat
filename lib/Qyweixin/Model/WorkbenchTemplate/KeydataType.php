<?php

namespace Qyweixin\Model\WorkbenchTemplate;

/**
 * 关键数据型
 */
class KeydataType extends \Qyweixin\Model\WorkbenchTemplate\Base
{
    /**
     * type 是 类型，此时固定为：关键数据型 keydata
     */
    protected $type = 'keydata';

    /**
     * items	是	关键数据列表个，不超过4个
     */
    public $items = NULL;

    public function __construct(array $items)
    {
        $this->items = $items;
    }

    public function getParams()
    {
        $params = parent::getParams();

        if ($this->isNotNull($this->items)) {
            foreach ($this->items as $item) {
                $params[$this->type]['items'][] = $item->getParams();
            }
        }
        return $params;
    }
}
