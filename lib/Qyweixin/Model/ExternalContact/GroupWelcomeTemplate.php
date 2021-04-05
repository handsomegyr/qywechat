<?php

namespace Qyweixin\Model\ExternalContact;

/**
 * 结束语构体
 */
class GroupWelcomeTemplate extends \Qyweixin\Model\Base
{

    /**
     * text 消息文本
     *
     * @var \Qyweixin\Model\ExternalContact\Conclusion\Text
     */
    public $text = NULL;

    /**
     * image 图片
     *
     * @var \Qyweixin\Model\ExternalContact\Conclusion\Image
     */
    public $image = NULL;

    /**
     * link 图文消息
     *
     * @var \Qyweixin\Model\ExternalContact\Conclusion\Link
     */
    public $link = NULL;

    /**
     * miniprogram 小程序消息
     *
     * @var \Qyweixin\Model\ExternalContact\Conclusion\Miniprogram
     */
    public $miniprogram = NULL;

    /**
     * agentid	否	授权方安装的应用agentid。仅旧的第三方多应用套件需要填此参数
     *
     * @var string
     */
    public $agentid = NULL;

    /**
     * notify	否	是否通知成员将这条入群欢迎语应用到客户群中，0-不通知，1-通知， 不填则通知
     *
     * @var number
     */
    public $notify = NULL;

    public function __construct()
    {
    }

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->text)) {
            $params['text'] = $this->text->getParams();
        }
        if ($this->isNotNull($this->image)) {
            $imgParams = $this->image->getParams();
            $params['image'] = $imgParams[$imgParams['msgtype']];
        }
        if ($this->isNotNull($this->link)) {
            $linkParams = $this->link->getParams();
            $params['link'] = $linkParams[$linkParams['msgtype']];
        }
        if ($this->isNotNull($this->miniprogram)) {
            $miniprogramParams = $this->miniprogram->getParams();
            $params['miniprogram'] = $miniprogramParams[$miniprogramParams['msgtype']];
        }
        if ($this->isNotNull($this->agentid)) {
            $params['agentid'] = $this->agentid;
        }
        if ($this->isNotNull($this->notify)) {
            $params['notify'] = $this->notify;
        }
        return $params;
    }
}
