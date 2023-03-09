<?php

namespace Qyweixin\Model\RobotMsg;

/**
 * 文本消息构体
 */
class Text extends \Qyweixin\Model\RobotMsg\Base
{

    /**
     * msgtype 是 消息类型，此时固定为：text
     */
    protected $msgtype = 'text';

    /**
     * content 是	文本内容，最长不超过2048个字节，必须是utf8编码
     */
    public $content = NULL;

    /**
     * mentioned_list	否	userid的列表，提醒群中的指定成员(@某个成员)，@all表示提醒所有人，如果开发者获取不到userid，可以使用mentioned_mobile_list
     */
    public $mentioned_list = NULL;

    /**
     * mentioned_mobile_list 否	手机号列表，提醒手机号对应的群成员(@某个成员)，@all表示提醒所有人
     */
    public $mentioned_mobile_list = NULL;

    public function __construct($content)
    {
        $this->content = $content;
    }

    public function getParams()
    {
        $params = parent::getParams();

        if ($this->isNotNull($this->content)) {
            $params[$this->msgtype]['content'] = $this->content;
        }
        if ($this->isNotNull($this->mentioned_list)) {
            $params[$this->msgtype]['mentioned_list'] = $this->mentioned_list;
        }
        if ($this->isNotNull($this->mentioned_mobile_list)) {
            $params[$this->msgtype]['mentioned_mobile_list'] = $this->mentioned_mobile_list;
        }
        return $params;
    }
}
