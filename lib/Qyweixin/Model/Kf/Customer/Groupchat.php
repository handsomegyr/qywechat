<?php

namespace Qyweixin\Model\Kf\Customer;

/**
 * 推荐的客户群构体
 */
class Groupchat extends \Qyweixin\Model\Base
{
    /**
     * chat_id	是	客户群id
     */
    public $chat_id = NULL;

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

        if ($this->isNotNull($this->chat_id)) {
            $params['chat_id'] = $this->chat_id;
        }
        if ($this->isNotNull($this->wording)) {
            $params['wording'] = $this->wording;
        }
        return $params;
    }
}
