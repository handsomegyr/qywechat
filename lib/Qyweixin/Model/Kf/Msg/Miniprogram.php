<?php

namespace Qyweixin\Model\Kf\Msg;

/**
 * 小程序消息构体
 */
class Miniprogram extends \Qyweixin\Model\Kf\Msg\MsgBase
{
    /**
     * msgtype	是	string	消息类型，此时固定为：miniprogram
     */
    protected $msgtype = 'miniprogram';
    /**
     * appid	是	string	小程序appid
     */
    public $appid = NULL;
    /**
     * title	否	string	小程序消息标题，最多64个字节，超过会自动截断
     */
    public $title = NULL;
    /**
     * thumb_media_id	是	string	小程序消息封面的mediaid，封面图建议尺寸为520*416
     */
    public $thumb_media_id = NULL;
    /**
     * pagepath	是	string	点击消息卡片后进入的小程序页面路径。注意路径要以.html为后缀，否则在微信中打开会提示找不到页面
     */
    public $pagepath = NULL;

    public function __construct()
    {
    }

    public function getParams()
    {
        $params = parent::getParams();

        if ($this->isNotNull($this->appid)) {
            $params[$this->msgtype]['appid'] = $this->appid;
        }
        if ($this->isNotNull($this->title)) {
            $params[$this->msgtype]['title'] = $this->title;
        }
        if ($this->isNotNull($this->thumb_media_id)) {
            $params[$this->msgtype]['thumb_media_id'] = $this->thumb_media_id;
        }
        if ($this->isNotNull($this->pagepath)) {
            $params[$this->msgtype]['pagepath'] = $this->pagepath;
        }
        return $params;
    }
}
