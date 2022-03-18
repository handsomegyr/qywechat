<?php

namespace Qyweixin\Model\Kf\Customer;

/**
 * 推荐的服务专员构体
 */
class Member extends \Qyweixin\Model\Base
{
    /**
     * userid 是	服务专员的userid
     */
    public $userid = NULL;

    /**
     * wording	否	推荐语
     */
    public $wording = NULL;

    public function __construct()
    {
    }

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->userid)) {
            $params['userid'] = $this->userid;
        }
        if ($this->isNotNull($this->wording)) {
            $params['wording'] = $this->wording;
        }
        return $params;
    }
}
