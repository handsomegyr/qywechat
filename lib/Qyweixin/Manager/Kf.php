<?php

namespace Qyweixin\Manager;

use Qyweixin\Client;

use Qyweixin\Manager\Kf\Account;
use Qyweixin\Manager\Kf\Servicer;
use Qyweixin\Manager\Kf\ServiceState;
use Qyweixin\Manager\Kf\Msg;
use Qyweixin\Manager\Kf\Customer;

/**
 * 微信客服
 * https://developer.work.weixin.qq.com/document/path/94683
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class Kf
{

    // 接口地址
    private $_url = 'https://qyapi.weixin.qq.com/cgi-bin/kf/';

    private $_client;

    private $_request;

    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 获取客服帐号管理对象
     *
     * @return \Qyweixin\Manager\Kf\Account
     */
    public function getAccountManager()
    {
        return new Account($this->_client);
    }

    /**
     * 获取接待人员管理对象
     *
     * @return \Qyweixin\Manager\Kf\Servicer
     */
    public function getServicerManager()
    {
        return new Servicer($this->_client);
    }

    /**
     * 获取会话状态管理对象
     *
     * @return \Qyweixin\Manager\Kf\ServiceState
     */
    public function getServiceStateManager()
    {
        return new ServiceState($this->_client);
    }

    /**
     * 获取消息和事件管理对象
     *
     * @return \Qyweixin\Manager\Kf\Msg
     */
    public function getMsgManager()
    {
        return new Msg($this->_client);
    }

    /**
     * 获取客户管理对象
     *
     * @return \Qyweixin\Manager\Kf\Customer
     */
    public function getCustomerManager()
    {
        return new Customer($this->_client);
    }
}
