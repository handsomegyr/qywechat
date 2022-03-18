<?php

namespace Qyweixin\Model\Kf\Msg\MsgMenu;

/**
 * view的菜单项构体
 */
class ViewItem extends \Qyweixin\Model\Kf\Msg\MsgMenu\ItemBase
{
    /**
     * url	是	string	点击后跳转的链接。不少于1字节不多于2048字节
     */
    public $url = NULL;

    /**
     * content	是	string	菜单显示内容。不少于1字节不多于1024字节
     */
    public $content = NULL;

    public function __construct()
    {
    }

    public function getParams()
    {
        $params = parent::getParams();

        if ($this->isNotNull($this->url)) {
            $params[$this->type]['url'] = $this->url;
        }
        if ($this->isNotNull($this->content)) {
            $params[$this->type]['content'] = $this->content;
        }
        return $params;
    }
}
