<?php

namespace Qyweixin\Model\ExternalContact\Conclusion;

/**
 * 文件内容构体
 */
class File extends \Qyweixin\Model\Base
{

    /**
     * file.media_id	是	文件的media_id，可以通过素材管理接口获得
     */
    public $media_id = NULL;

    protected $msgtype = "file";

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
