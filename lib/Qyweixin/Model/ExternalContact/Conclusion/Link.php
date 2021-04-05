<?php

namespace Qyweixin\Model\ExternalContact\Conclusion;

/**
 * 图文消息构体
 */
class Link extends \Qyweixin\Model\Base
{

    /**
     * link.title 图文消息标题，最长为128字节
     */
    public $title = NULL;

    /**
     * link.picurl 图文消息封面的url
     */
    public $picurl = NULL;

    /**
     * link.desc 图文消息的描述，最长为512字节
     */
    public $desc = NULL;

    /**
     * link.url 图文消息的链接
     */
    public $url = NULL;

    protected $msgtype = "link";

    public function __construct($title, $picurl, $desc, $url)
    {
        $this->title = $title;
        $this->picurl = $picurl;
        $this->desc = $desc;
        $this->url = $url;
    }

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->msgtype)) {
            $params['msgtype'] = $this->msgtype;
        }

        if ($this->isNotNull($this->title)) {
            $params[$this->msgtype]['title'] = $this->title;
        }
        if ($this->isNotNull($this->picurl)) {
            $params[$this->msgtype]['picurl'] = $this->picurl;
        }
        if ($this->isNotNull($this->desc)) {
            $params[$this->msgtype]['desc'] = $this->desc;
        }
        if ($this->isNotNull($this->url)) {
            $params[$this->msgtype]['url'] = $this->url;
        }
        return $params;
    }
}
