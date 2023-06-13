<?php

namespace Qyweixin\Model;

/**
 * 配置文件
 */
class Config
{

    /**
     * 是否使用代理
     */
    private $_isProxyUsed = true;

    /**
     * 代理URL
     */
    private $_proxyUrl = "";

    public function setIsProxyUsed($isProxyUsed)
    {
        $this->_isProxyUsed = $isProxyUsed;
    }

    public function getIsProxyUsed()
    {
        return $this->_isProxyUsed;
    }

    public function setProxyUrl($proxyUrl)
    {
        $this->_proxyUrl = $proxyUrl;
    }

    public function getProxyUrl()
    {
        return $this->_proxyUrl;
    }
}
