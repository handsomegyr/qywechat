<?php

namespace Qyweixin\Model\Message\TemplateCard;

/**
 * 图片样式构体
 */
class CardImage extends \Qyweixin\Model\Message\Base
{
    /** card_image.url	是	图片的url */
    public $url = NULL;
    /** card_image.aspect_ratio	否	图片的宽高比，宽高比要小于2.25，大于1.3，不填该参数默认1.3 */
    public $aspect_ratio = NULL;

    public function getParams()
    {
        $params = parent::getParams();

        if ($this->isNotNull($this->url)) {
            $params['url'] = $this->url;
        }
        if ($this->isNotNull($this->aspect_ratio)) {
            $params['aspect_ratio'] = $this->aspect_ratio;
        }
        return $params;
    }
}
