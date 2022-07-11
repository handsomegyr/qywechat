<?php

namespace Qyweixin\Model\Message\TemplateCard;

/**
 * 关键数据样式构体
 */
class EmphasisContent extends \Qyweixin\Model\Message\Base
{
    /** emphasis_content.title	否	关键数据样式的数据内容，建议不超过14个字 */
    public $title = NULL;
    /** emphasis_content.desc	否	关键数据样式的数据描述内容，建议不超过22个字 */
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
