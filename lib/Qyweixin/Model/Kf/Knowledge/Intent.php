<?php

namespace Qyweixin\Model\Kf\Knowledge;

/**
 * 知识库问答构体
 */
class Intent extends \Qyweixin\Model\Base
{
    /**
     * intent_id string 是 问答ID
     */
    public $intent_id = NULL;

    /**
     * group_id	string	是	分组ID
     */
    public $group_id = NULL;

    /**
     * question	obj	是	主问题
     * @var \Qyweixin\Model\Kf\Knowledge\Question\QuestionBase
     */
    public $question = NULL;

    /**
     * similar_questions	obj	否	相似问题
     * @var \Qyweixin\Model\Kf\Knowledge\SimilarQuestions
     */
    public $similar_questions = NULL;

    /**
     * answers	obj[]	是	回答列表。目前仅支持1个
     * @var \Qyweixin\Model\Kf\Knowledge\Answers
     */
    public $answers = NULL;

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->intent_id)) {
            $params['intent_id'] = $this->intent_id;
        }
        if ($this->isNotNull($this->group_id)) {
            $params['group_id'] = $this->group_id;
        }
        if ($this->isNotNull($this->question)) {
            $params['question'] = $this->question->getParams();
        }
        if ($this->isNotNull($this->similar_questions)) {
            $params['similar_questions'] = $this->similar_questions->getParams();
        }
        if ($this->isNotNull($this->answers)) {
            $params['answers'] = $this->answers->getParams();
        }
        return $params;
    }
}
