<?php

namespace Qyweixin\Model\Kf\Customer;

/**
 * 群聊会话构体
 */
class UpgradeService extends \Qyweixin\Model\Base
{
    /**
     * type	是	表示是升级到专员服务还是客户群服务。1:专员服务。2:客户群服务
     */
    public $type = NULL;

    /**
     * member	否	推荐的服务专员，type等于1时有效
     * @var \Qyweixin\Model\Kf\Customer\Member
     */
    public $member = NULL;

    /**
     * groupchat	否	推荐的客户群，type等于2时有效
     * @var \Qyweixin\Model\Kf\Customer\Groupchat
     */
    public $groupchat = NULL;

    public function __construct()
    {
    }

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->type)) {
            $params['type'] = $this->type;
        }
        if ($this->type == 1 && $this->isNotNull($this->member)) {
            $params['member'] = $this->member->getParams();
        }
        if ($this->type == 2 && $this->isNotNull($this->groupchat)) {
            $params['groupchat'] = $this->groupchat->getParams();
        }
        return $params;
    }
}
