<?php

namespace Qyweixin\Model\Kf\Knowledge\Question;

/**
 * 主问题文本
 */
class Text extends QuestionBase
{
    /**
     * question.text	obj	是	主问题文本
     */
    protected $questiontype = 'text';

    /**
     * question.text.content	string	是	主问题文本内容。不超过200个字
     */
    public $content = NULL;

    public function getParams()
    {
        $params = parent::getParams();

        if ($this->isNotNull($this->content)) {
            $params[$this->questiontype]['content'] = $this->content;
        }
        return $params;
    }
}
