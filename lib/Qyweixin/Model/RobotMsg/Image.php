<?php

namespace Qyweixin\Model\RobotMsg;

/**
 * 图片消息构体
 */
class Image extends \Qyweixin\Model\RobotMsg\Base
{

    /**
     * msgtype 是 消息类型，此时固定为：image
     */
    protected $msgtype = 'image';

    /**
     * base64	是	图片内容的base64编码
     */
    public $base64 = NULL;
    /**
     * md5	是	图片内容（base64编码前）的md5值
     */
    public $md5 = NULL;

    public function __construct($base64, $md5)
    {
        $this->base64 = $base64;
        $this->md5 = $md5;
    }

    public function getParams()
    {
        $params = parent::getParams();

        if ($this->isNotNull($this->base64)) {
            $params[$this->msgtype]['base64'] = $this->base64;
        }
        if ($this->isNotNull($this->md5)) {
            $params[$this->msgtype]['md5'] = $this->md5;
        }
        return $params;
    }
}
