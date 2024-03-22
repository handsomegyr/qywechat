<?php

namespace Qyweixin\Model\ExternalContact\Moment;

/**
 * 视频内容构体
 */
class Video extends \Qyweixin\Model\Base
{

    /**
     * video.media_id	视频的素材id，未填写报错"invalid msg"。可通过上传附件资源接口获得
     */
    public $media_id = NULL;

    protected $msgtype = "video";

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
