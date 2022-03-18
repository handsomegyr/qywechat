<?php

namespace Qyweixin\Model\Kf\Msg;

/**
 * 群聊会话构体
 */
class MsgBase extends \Qyweixin\Model\Base
{
    /**
     * msgid	否	string	指定消息ID
     */
    public $msgid = NULL;

    /**
     * msgtype	是	string	消息类型，此时固定为：text
     */
    protected $msgtype = NULL;

    public function __construct()
    {
    }

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->touser)) {
            $params['touser'] = $this->touser;
        }
        if ($this->isNotNull($this->open_kfid)) {
            $params['open_kfid'] = $this->open_kfid;
        }
        if ($this->isNotNull($this->msgid)) {
            $params['msgid'] = $this->msgid;
        }
        if ($this->isNotNull($this->msgtype)) {
            $params['msgtype'] = $this->msgtype;
        }
        return $params;
    }
}
