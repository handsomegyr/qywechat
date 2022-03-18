<?php

namespace Qyweixin\Model\Kf\Msg\MsgMenu;

/**
 * type为miniprogram的菜单项构体
 */
class MiniprogramItem extends \Qyweixin\Model\Kf\Msg\MsgMenu\ItemBase
{
    /**
     * appid	是	string	小程序appid。不少于1字节不多于32字节
     */
    public $appid = NULL;

    /**
     * pagepath	是	string	点击后进入的小程序页面。不少于1字节不多于1024字节
     */
    public $pagepath = NULL;

    /**
     * content	是	string	菜单显示内容。不多于1024字节
     */
    public $content = NULL;

    public function __construct()
    {
    }

    public function getParams()
    {
        $params = parent::getParams();

        if ($this->isNotNull($this->appid)) {
            $params[$this->type]['appid'] = $this->appid;
        }
        if ($this->isNotNull($this->pagepath)) {
            $params[$this->type]['pagepath'] = $this->pagepath;
        }
        if ($this->isNotNull($this->content)) {
            $params[$this->type]['content'] = $this->content;
        }
        return $params;
    }
}
