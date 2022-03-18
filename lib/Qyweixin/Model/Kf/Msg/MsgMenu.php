<?php

namespace Qyweixin\Model\Kf\Msg;

/**
 * 菜单消息构体
 */
class MsgMenu extends \Qyweixin\Model\Kf\Msg\MsgBase
{
    /**
     * msgtype	是	string	消息类型，此时固定为：msgmenu
     */
    protected $msgtype = 'msgmenu';
    /**
     * head_content	否	string	起始文本不多于1024字节
     */
    public $head_content = NULL;

    /**
     * list	否	obj[]	菜单项配置
     */
    public $list = NULL;

    /**
     * tail_content	否	string	结束文本不多于1024字节
     */
    public $tail_content = null;

    public function __construct()
    {
    }

    public function getParams()
    {
        $params = parent::getParams();

        if ($this->isNotNull($this->head_content)) {
            $params[$this->msgtype]['head_content'] = $this->head_content;
        }
        if ($this->isNotNull($this->list)) {
            foreach ($this->list as $item) {
                $params[$this->msgtype]['list'][] = $item->getParams();
            }
        }
        if ($this->isNotNull($this->tail_content)) {
            $params[$this->msgtype]['tail_content'] = $this->tail_content;
        }
        return $params;
    }
}
