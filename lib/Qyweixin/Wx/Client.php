<?php

/**
 * 企业微信小程序客户端总调度器
 * 
 * @author guoyongrong <handsomegyr@126.com>
 *
 */

namespace Qyweixin\Wx;

class Client
{

    private $_client;

    public function __construct(\Qyweixin\Client $client)
    {
        $this->_client = $client;
    }
}
