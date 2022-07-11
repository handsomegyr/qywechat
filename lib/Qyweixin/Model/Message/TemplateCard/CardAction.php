<?php

namespace Qyweixin\Model\Message\TemplateCard;

/**
 * 整体卡片的点击跳转事件构体
 */
class CardAction extends \Qyweixin\Model\Message\Base
{
    /** card_action.type	是	跳转事件类型，1 代表跳转url，2 代表打开小程序。text_notice卡片模版中该字段取值范围为[1,2] */
    public $type = NULL;
    /** card_action.url	否	跳转事件的url，card_action.type是1时必填 */
    public $url = NULL;
    /** card_action.appid	否	跳转事件的小程序的appid，必须是与当前应用关联的小程序，card_action.type是2时必填 */
    public $appid = NULL;
    /** card_action.pagepath	否	跳转事件的小程序的pagepath，card_action.type是2时选填 */
    public $pagepath = NULL;

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
        return $params;
    }
}
