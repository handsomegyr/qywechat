<?php

namespace Qyweixin\Model\WorkbenchTemplate;

/**
 * 列表型
 */
class ListType extends \Qyweixin\Model\WorkbenchTemplate\Base
{
    /**
     * type 是 类型，此时固定为：列表型 list
     */
    protected $type = 'list';

    /**
     * items	是	关键数据列表个，不超过3个
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
