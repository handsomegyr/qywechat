<?php

namespace Qyweixin\Model\Kf\Knowledge\Answer;

/**
 * 	主问题构体
 */
class AnswerBase extends \Qyweixin\Model\Base
{
    /**
     * answertype	是	string	消息类型，此时固定为：text
     */
    protected $answertype = NULL;

    public function getParams()
    {
        $params = array();
        return $params;
    }
}
