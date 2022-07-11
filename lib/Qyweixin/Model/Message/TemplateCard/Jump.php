<?php

namespace Qyweixin\Model\Message\TemplateCard;

/**
 * 跳转指引样式的列表构体
 */
class Jump extends \Qyweixin\Model\Message\Base
{
    /** jump_list.type	否	跳转链接类型，0或不填代表不是链接，1 代表跳转url，2 代表跳转小程序 */
    public $type = NULL;
    /** jump_list.title	是	跳转链接样式的文案内容，建议不超过18个字 */
    public $title = NULL;
    /** jump_list.url	否	跳转链接的url，jump_list.type是1时必填 */
    public $url = NULL;
    /** jump_list.appid	否	跳转链接的小程序的appid，必须是与当前应用关联的小程序，jump_list.type是2时必填 */
    public $appid = NULL;
    /** jump_list.pagepath	否	跳转链接的小程序的pagepath，jump_list.type是2时选填 */
    public $pagepath = NULL;

    public function getParams()
    {
        $params = parent::getParams();

        if ($this->isNotNull($this->type)) {
            $params['type'] = $this->type;
        }
        if ($this->isNotNull($this->title)) {
            $params['title'] = $this->title;
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
