<?php

namespace Qyweixin\Model\ExternalContact\Moment;

/**
 * 图片内容构体
 */
class Image extends \Qyweixin\Model\Base
{

    /**
     * image.media_id 图片的素材id，长边不超过10800像素，短边不超过1080像素。可通过上传附件资源接口获得
     */
    public $media_id = NULL;

    protected $msgtype = "image";

    public function __construct($media_id)
    {
        $this->media_id = $media_id;
    }

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->msgtype)) {
            $params['msgtype'] = $this->msgtype;
        }

        if ($this->isNotNull($this->media_id)) {
            $params[$this->msgtype]['media_id'] = $this->media_id;
        }
        return $params;
    }
}
