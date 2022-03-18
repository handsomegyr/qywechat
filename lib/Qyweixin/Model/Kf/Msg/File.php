<?php

namespace Qyweixin\Model\Kf\Msg;

/**
 * 文件消息构体
 */
class File extends \Qyweixin\Model\Kf\Msg\MsgBase
{
    /**
     * 是	string	消息类型，此时固定为：file
     */
    protected $msgtype = 'file';
    /**
     * media_id	是	string	文件id，可以调用上传临时素材接口获取
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
