<?php

namespace Qyweixin\Model\ExternalContact\Moment;

/**
 * 图文消息构体
 */
class Link extends \Qyweixin\Model\Base
{

    /**
     * link.title 图文消息标题，最多64个字节
     */
    public $title = NULL;

    /**
     * link.url 图文消息链接
     */
    public $url = NULL;

    /**
     * link.media_id 图片链接封面，长边不超过10800像素，短边不超过1080像素，可通过上传附件资源接口获得
     */
    public $media_id = NULL;

    protected $msgtype = "link";

    public function __construct($title, $url, $media_id)
    {
        $this->title = $title;
        $this->url = $url;
        $this->media_id = $media_id;
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
        if ($this->isNotNull($this->url)) {
            $params[$this->msgtype]['url'] = $this->url;
        }
        if ($this->isNotNull($this->media_id)) {
            $params[$this->msgtype]['media_id'] = $this->media_id;
        }
        return $params;
    }
}
