<?php

namespace Qyweixin\Model\Kf\Knowledge\Answer;

/**
 * 回答文本
 */
class Text extends AnswerBase
{
    /**
     * answer.text	obj	回答文本
     */
    protected $answertype = 'text';

    /**
     * answers.text.content	string	回答文本内容
     */
    public $content = NULL;

    public function getParams()
    {
        $params = parent::getParams();

        if ($this->isNotNull($this->content)) {
            $params[$this->answertype]['content'] = $this->content;
        }
        return $params;
    }
}
