<?php

namespace Qyweixin\Manager;

use Qyweixin\Client;
use Qyweixin\Manager\Linkedcorp\Agent;
use Qyweixin\Manager\Linkedcorp\Department;
use Qyweixin\Manager\Linkedcorp\User;
use Qyweixin\Manager\Linkedcorp\Message;

/**
 * 互联企业
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class Linkedcorp
{
    // 接口地址
    private $_url = 'https://qyapi.weixin.qq.com/cgi-bin/linkedcorp/';

    private $_client;

    private $_request;

    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 获取应用对象
     *
     * @return \Qyweixin\Manager\Linkedcorp\Agent
     */
    public function getAgentManager()
    {
        return new Agent($this->_client);
    }

    /**
     * 获取部门对象
     *
     * @return \Qyweixin\Manager\Linkedcorp\Department
     */
    public function getDepartmentManager()
    {
        return new Department($this->_client);
    }

    /**
     * 获取部门成员对象
     *
     * @return \Qyweixin\Manager\Linkedcorp\User
     */
    public function getUserManager()
    {
        return new User($this->_client);
    }

    /**
     * 获取消息对象
     *
     * @return \Qyweixin\Manager\Linkedcorp\Message
     */
    public function getMessageManager()
    {
        return new Message($this->_client);
    }
}
