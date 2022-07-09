<?php

namespace Qyweixin\Model;

/**
 * 视频号属性构体
 */
class WechatChannels extends \Qyweixin\Model\Base
{

    /**
     * nickname	视频号名字（设置后，成员将对外展示该视频号）	否
     */
    public $nickname = NULL;

    /**
     * status	对外展示视频号状态。0表示企业视频号已被确认，可正常使用，1表示企业视频号待确认	否
     */
    public $status = NULL;

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->nickname)) {
            $params['nickname'] = $this->nickname;
        }
        if ($this->isNotNull($this->status)) {
            $params['status'] = $this->status;
        }
        return $params;
    }
}
