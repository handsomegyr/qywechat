<?php

namespace Qyweixin\Model\Message\TemplateCard;

/**
 * 卡片二级垂直内容构体
 */
class VerticalContent extends \Qyweixin\Model\Message\Base
{
    /** vertical_content_list.title	是	卡片二级标题，建议不超过38个字 */
    public $title = NULL;
    /** vertical_content_list.desc	否	二级普通文本，建议不超过160个字 */
    public $desc = NULL;

    public function getParams()
    {
        $params = parent::getParams();

        if ($this->isNotNull($this->title)) {
            $params['title'] = $this->title;
        }
        if ($this->isNotNull($this->desc)) {
            $params['desc'] = $this->desc;
        }
        return $params;
    }
}
