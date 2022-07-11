<?php

namespace Qyweixin\Model\Message\TemplateCard;

/**
 * 左图右文样式构体
 */
class ImageTextArea extends \Qyweixin\Model\Message\Base
{
    /** image_text_area.type	否	左图右文样式区域点击事件，0或不填代表没有点击事件，1 代表跳转url，2 代表跳转小程序 */
    public $type = NULL;
    /** image_text_area.url	否	点击跳转的url，image_text_area.type是1时必填 */
    public $url = NULL;
    /** image_text_area.appid	否	点击跳转的小程序的appid，必须是与当前应用关联的小程序，image_text_area.type是2时必填 */
    public $appid = NULL;
    /** image_text_area.pagepath	否	点击跳转的小程序的pagepath，image_text_area.type是2时选填 */
    public $pagepath = NULL;
    /** image_text_area.title	否	左图右文样式的标题 */
    public $title = NULL;
    /** image_text_area.desc	否	左图右文样式的描述 */
    public $desc = NULL;
    /** image_text_area.image_url	是	左图右文样式的图片url */
    public $image_url = NULL;

    public function getParams()
    {
        $params = parent::getParams();

        if ($this->isNotNull($this->type)) {
            $params['type'] = $this->type;
        }
        if ($this->isNotNull($this->url)) {
            $params['url'] = $this->url;
        }
        if ($this->isNotNull($this->appid)) {
            $params['appid'] = $this->appid;
        }
        if ($this->isNotNull($this->pagepath)) {
            $params['pagepath'] = $this->pagepath;
        }
        if ($this->isNotNull($this->title)) {
            $params['title'] = $this->title;
        }
        if ($this->isNotNull($this->desc)) {
            $params['desc'] = $this->desc;
        }
        if ($this->isNotNull($this->image_url)) {
            $params['image_url'] = $this->image_url;
        }
        return $params;
    }
}
