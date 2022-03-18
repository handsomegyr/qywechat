<?php

namespace Qyweixin\Model\Kf\Msg;

/**
 * 视频消息构体
 */
class Video extends \Qyweixin\Model\Kf\Msg\MsgBase
{
    /**
     * msgtype	是	string	消息类型，此时固定为：video
     */
    protected $msgtype = 'video';
    /**
     * media_id	是	string	视频媒体文件id，可以调用上传临时素材接口获取
     */
    public $media_id = NULL;

    public function __construct()
    {
    }

    public function getParams()
    {
        $params = parent::getParams();

        if ($this->isNotNull($this->media_id)) {
            $params[$this->msgtype]['media_id'] = $this->media_id;
        }
        return $params;
    }
}
