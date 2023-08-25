<?php

namespace Qyweixin\Model\Kf\Msg;

/**
 * 图文链接消息构体
 */
class Link extends \Qyweixin\Model\Kf\Msg\MsgBase
{
    /**
     * msgtype	是	string	消息类型，此时固定为：link
     */
    protected $msgtype = 'link';
    /**
     * title	是	string	标题，不超过128个字节，超过会自动截断
     */
    public $title = NULL;

    /**
     * desc	否	string	描述，不超过512个字节，超过会自动截断
     */
    public $desc = NULL;

    /**
     * url	是	string	点击后跳转的链接。 最长2048字节，请确保包含了协议头(http/https)
     */
    public $url = NULL;

    /**
     * thumb_media_id	是	string	缩略图的media_id, 可以通过素材管理接口获得。此处thumb_media_id即上传接口返回的media_id
     */
    public $thumb_media_id = NULL;


    /**
     * pic_url	string	否	缩略图链接
     */
    public $pic_url = NULL;

    public function __construct()
    {
    }

    public function getParams()
    {
        $params = parent::getParams();

        if ($this->isNotNull($this->title)) {
            $params[$this->msgtype]['title'] = $this->title;
        }
        if ($this->isNotNull($this->desc)) {
            $params[$this->msgtype]['desc'] = $this->desc;
        }
        if ($this->isNotNull($this->url)) {
            $params[$this->msgtype]['url'] = $this->url;
        }
        if ($this->isNotNull($this->thumb_media_id)) {
            $params[$this->msgtype]['thumb_media_id'] = $this->thumb_media_id;
        }
        if ($this->isNotNull($this->pic_url)) {
            $params[$this->msgtype]['pic_url'] = $this->pic_url;
        }
        return $params;
    }
}
