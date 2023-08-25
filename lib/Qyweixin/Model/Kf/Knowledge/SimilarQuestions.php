<?php

namespace Qyweixin\Model\Kf\Knowledge;

/**
 * 相似问题构体
 */
class SimilarQuestions extends \Qyweixin\Model\Base
{
    /**
     * similar_questions.items	obj[]	否	相似问题列表。最多支持100个
     */
    public $items = NULL;

    public function getParams()
    {
        $params = array();

        if (!empty($this->items)) {
            foreach ($this->items as $info) {
                $params['items'][] = $info->getParams();
            }
        }
        return $params;
    }
}
