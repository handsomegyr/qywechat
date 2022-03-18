<?php

namespace Qyweixin\Model\Kf\Msg\MsgMenu;

/**
 * 菜单项构体
 */
class ItemBase extends \Qyweixin\Model\Base
{
    /**
     * type	是	string	菜单类型。click-回复菜单 view-超链接菜单 miniprogram-小程序菜单
     */
    protected $type = null;

    public function __construct()
    {
    }

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->type)) {
            $params['type'] = $this->type;
        }
        if ($this->isNotNull($this->type)) {
            $params['type'] = $this->type;
        }
        return $params;
    }
}
