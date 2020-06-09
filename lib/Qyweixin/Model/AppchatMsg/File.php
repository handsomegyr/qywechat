<?php

namespace Qyweixin\Model\AppchatMsg;

/**
 * 文件消息构体
 */
class File extends \Qyweixin\Model\AppchatMsg\Base
{

    /**
     * media_id 是 文件id，可以调用上传临时素材接口获取
     */
    public $media_id = NULL;

    public function __construct($chatid, $media_id)
    {
        $this->chatid = $chatid;
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
