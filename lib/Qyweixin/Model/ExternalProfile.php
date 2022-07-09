<?php

namespace Qyweixin\Model;

/**
 * 成员对外属性构体
 */
class ExternalProfile extends \Qyweixin\Model\Base
{

    /**
     * external_attr 属性列表，目前支持文本、网页、小程序三种类型 是
     */
    public $external_attr = NULL;

    /**
     * external_corp_name 企业对外简称，需从已认证的企业简称中选填。可在“我的企业”页中查看企业简称认证状态。 否
     */
    public $external_corp_name = NULL;

    /**
     * wechat_channels	视频号属性。须从企业绑定到企业微信的视频号中选择，可在“我的企业”页中查看绑定的视频号。第三方仅通讯录应用可获取；对于非第三方创建的成员，第三方通讯录应用也不可获取。注意：externalcontact/get
     * @var \Qyweixin\Model\WechatChannels
     */
    public $wechat_channels = NULL;

    public function __construct(array $external_attr)
    {
        $this->external_attr = $external_attr;
    }

    public function getParams()
    {
        $params = array();

        if (!empty($this->external_attr)) {
            foreach ($this->external_attr as $item) {
                $params['external_attr'][] = $item->getParams();
            }
        }

        if ($this->isNotNull($this->external_corp_name)) {
            $params['external_corp_name'] = $this->external_corp_name;
        }
        if ($this->isNotNull($this->wechat_channels)) {
            $params['wechat_channels'] = $this->wechat_channels->getParams();
        }
        return $params;
    }
}
