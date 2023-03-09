<?php

namespace Qyweixin\Model\RobotMsg;

/**
 * 文件消息构体
 */
class File extends \Qyweixin\Model\RobotMsg\Base
{
    /**
     * msgtype 是 消息类型，此时固定为：file
     */
    protected $msgtype = 'file';

    /**
     * media_id 是 文件id，通过下文的文件上传接口获取
     */
    public $media_id = NULL;

    public function __construct($media_id)
    {
        $this->media_id = $media_id;
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
