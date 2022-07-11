<?php

namespace Qyweixin\Model\Message\TemplateCard;

/**
 * 引用文献样式构体
 */
class QuoteArea extends \Qyweixin\Model\Message\Base
{
    /** quote_area.type	否	引用文献样式区域点击事件，0或不填代表没有点击事件，1 代表跳转url，2 代表跳转小程序 */
    public $type = NULL;
    /** quote_area.url	否	点击跳转的url，quote_area.type是1时必填 */
    public $url = NULL;
    /** quote_area.appid	否	点击跳转的小程序的appid，必须是与当前应用关联的小程序，quote_area.type是2时必填 */
    public $appid = NULL;
    /** quote_area.pagepath	否	点击跳转的小程序的pagepath，quote_area.type是2时选填 */
    public $pagepath = NULL;
    /** quote_area.title	否	引用文献样式的标题 */
    public $title = NULL;
    /** quote_area.quote_text	否	引用文献样式的引用文案 */
    public $quote_text = NULL;

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
        if ($this->isNotNull($this->quote_text)) {
            $params['quote_text'] = $this->quote_text;
        }
        return $params;
    }
}
