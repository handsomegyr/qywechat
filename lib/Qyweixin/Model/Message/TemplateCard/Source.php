<?php

namespace Qyweixin\Model\Message\TemplateCard;

/**
 * 卡片来源样式信息构体
 */
class Source extends \Qyweixin\Model\Message\Base
{
    /** source.icon_url	否	来源图片的url，来源图片的尺寸建议为72*72 */
    protected $icon_url = NULL;
    /** source.desc	否	来源图片的描述，建议不超过20个字，（支持id转译） */
    protected $desc = NULL;
    /** source.desc_color	否	来源文字的颜色，目前支持：0(默认) 灰色，1 黑色，2 红色，3 绿色 */
    protected $desc_color = NULL;

    public function getParams()
    {
        $params = parent::getParams();

        if ($this->isNotNull($this->icon_url)) {
            $params['icon_url'] = $this->icon_url;
        }
        if ($this->isNotNull($this->desc)) {
            $params['desc'] = $this->desc;
        }
        if ($this->isNotNull($this->desc_color)) {
            $params['desc_color'] = $this->desc_color;
        }
        return $params;
    }
}
