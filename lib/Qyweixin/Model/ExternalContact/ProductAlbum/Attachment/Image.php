<?php

namespace Qyweixin\Model\ExternalContact\ProductAlbum\Attachment;

/**
 * 图片内容构体
 */
class Image extends \Qyweixin\Model\Base
{

    /**
     * image.media_id 图片的media_id
     */
    public $media_id = NULL;

    protected $type = "image";

    public function __construct($media_id)
    {
        $this->media_id = $media_id;
    }

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->type)) {
            $params['type'] = $this->type;
        }

        if ($this->isNotNull($this->media_id)) {
            $params[$this->type]['media_id'] = $this->media_id;
        }
        return $params;
    }
}
