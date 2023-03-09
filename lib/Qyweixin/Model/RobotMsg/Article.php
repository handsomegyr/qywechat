<?php

namespace Qyweixin\Model\RobotMsg;

use Weixin\Model\Base;

/**
 * 草稿结构体信息
 */
class Article extends Base
{
    // title	是	标题，不超过128个字节，超过会自动截断
    public $title = NULL;
    // description	否	描述，不超过512个字节，超过会自动截断
    public $description = NULL;
    // url	是	点击后跳转的链接。
    public $url = NULL;
    // picurl	否	图文消息的图片链接，支持JPG、PNG格式，较好的效果为大图 1068*455，小图150*150。
    public $picurl = NULL;

    public function __construct($title, $description, $url, $picurl)
    {
        $this->title = $title;
        $this->description = $description;
        $this->url = $url;
        $this->picurl = $picurl;
    }
    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->title)) {
            $params['title'] = $this->title;
        }
        if ($this->isNotNull($this->description)) {
            $params['description'] = $this->description;
        }
        if ($this->isNotNull($this->url)) {
            $params['url'] = $this->url;
        }
        if ($this->isNotNull($this->picurl)) {
            $params['picurl'] = $this->picurl;
        }
        return $params;
    }
}
