<?php

namespace Qyweixin\Model\ExternalContact\Moment;

/**
 * 朋友圈任务
 */
class Task extends \Qyweixin\Model\Base
{
    /**
     * text	否	文本消息
     * @var \Qyweixin\Model\ExternalContact\Moment\Text
     */
    public $text = NULL;

    /**
     * attachments	否	附件，不能与text.content同时为空，最多支持9个图片类型，或者1个视频，或者1个链接。类型只能三选一，若传了不同类型，报错'invalid attachments msgtype'
     */
    public $attachments = NULL;

    /**
     * visible_range	否	指定的发表范围；若未指定，则表示执行者为应用可见范围内所有成员
     *
     * @var \Qyweixin\Model\ExternalContact\VisibleRange
     */
    public $visible_range = NULL;

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->text)) {
            $params['text'] = $this->text->getParams();
        }
        if ($this->isNotNull($this->attachments)) {
            foreach ($this->attachments as $attachment) {
                $params['attachments'][] = $attachment->getParams();
            }
        }
        if ($this->isNotNull($this->visible_range)) {
            $params['visible_range'] = $this->visible_range->getParams();
        }
        return $params;
    }
}
