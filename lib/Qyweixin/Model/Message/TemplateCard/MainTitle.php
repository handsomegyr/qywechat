<?php

namespace Qyweixin\Model\Message\TemplateCard;

/**
 * 一级标题构体
 */
class MainTitle extends \Qyweixin\Model\Message\Base
{
    /** main_title.title	否	一级标题，建议不超过36个字，文本通知型卡片本字段非必填，但不可本字段和sub_title_text都不填，（支持id转译） */
    public $title = NULL;
    /** main_title.desc	否	标题辅助信息，建议不超过44个字，（支持id转译） */
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
