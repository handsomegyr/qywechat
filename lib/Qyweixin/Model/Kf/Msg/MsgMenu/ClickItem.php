<?php

namespace Qyweixin\Model\Kf\Msg\MsgMenu;

/**
 * click的菜单项构体
 */
class ClickItem extends \Qyweixin\Model\Kf\Msg\MsgMenu\ItemBase
{
    /**
     * id	否	string	菜单ID。不少于1字节不多于128字节
     */
    public $id = NULL;

    /**
     * content	是	string	菜单显示内容不少于1字节不多于128字节
     */
    public $content = NULL;

    public function __construct()
    {
    }

    public function getParams()
    {
        $params = parent::getParams();

        if ($this->isNotNull($this->id)) {
            $params[$this->type]['id'] = $this->id;
        }
        if ($this->isNotNull($this->content)) {
            $params[$this->type]['content'] = $this->content;
        }
        return $params;
    }
}
