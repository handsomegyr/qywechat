<?php

namespace Qyweixin\Model\Kf\Knowledge;

/**
 * 回答列表构体
 */
class Answer extends \Qyweixin\Model\Base
{
    /**
     * answers[].text	obj	是	回答文本
     * @var \Qyweixin\Model\Kf\Knowledge\Answer\AnswerBase
     */
    public $text = NULL;

    /**
     * answers[].attachments	obj[]	否	回答附件列表。最多支持4个
     */
    public $attachments = NULL;

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->text)) {
            $params = array_merge($params, $this->text->getParams());
        }
        if (!empty($this->attachments)) {
            foreach ($this->attachments as $info) {
                $params['attachments'][] = $info->getParams();
            }
        }
        return $params;
    }
}
