<?php

namespace Qyweixin\Model\ExternalContact\MomentStrategy;

/**
 * 基础权限构体
 */
class Privilege extends \Qyweixin\Model\Base
{

    /** view_moment_list	否	允许查看成员的全部客户朋友圈发表，默认为true */
    public $view_moment_list = NULL;
    /** send_moment	否	允许成员发表客户朋友圈，默认为true */
    public $send_moment = NULL;
    /** manage_moment_cover_and_sign	否	配置封面和签名，默认为true */
    public $manage_moment_cover_and_sign = NULL;

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->view_moment_list)) {
            $params['view_moment_list'] = $this->view_moment_list;
        }
        if ($this->isNotNull($this->send_moment)) {
            $params['send_moment'] = $this->send_moment;
        }
        if ($this->isNotNull($this->manage_moment_cover_and_sign)) {
            $params['manage_moment_cover_and_sign'] = $this->manage_moment_cover_and_sign;
        }
        return $params;
    }
}
