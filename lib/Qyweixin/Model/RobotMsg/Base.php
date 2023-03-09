<?php

namespace Qyweixin\Model\RobotMsg;

/**
 * 消息类型构体
 */
class Base extends \Qyweixin\Model\Base
{

    /**
     * msgtype 是 消息类型
     */
    protected $msgtype = NULL;

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->msgtype)) {
            $params['msgtype'] = $this->msgtype;
        }

        return $params;
    }
}
