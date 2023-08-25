<?php

namespace Qyweixin\Model\Kf\Knowledge\Question;

/**
 * 问题构体
 */
class QuestionBase extends \Qyweixin\Model\Base
{
    /**
     * questiontype	是	string	消息类型，此时固定为：text
     */
    protected $questiontype = NULL;

    public function getParams()
    {
        $params = array();
        return $params;
    }
}
