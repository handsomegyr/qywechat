<?php

namespace Qyweixin\Model\Kf\Msg;

/**
 * 地理位置消息构体
 */
class Location extends \Qyweixin\Model\Kf\Msg\MsgBase
{
    /**
     * msgtype	是	string	消息类型，此时固定为：location
     */
    protected $msgtype = 'location';
    /**
     * name	否	string	位置名
     */
    public $name = NULL;
    /**
     * address	否	string	地址详情说明
     */
    public $address = NULL;
    /**
     * latitude	是	float	纬度，浮点数，范围为90 ~ -90
     */
    public $latitude = NULL;
    /**
     * longitude	是	float	经度，浮点数，范围为180 ~ -180
     */
    public $longitude = NULL;

    public function __construct()
    {
    }

    public function getParams()
    {
        $params = parent::getParams();

        if ($this->isNotNull($this->name)) {
            $params[$this->msgtype]['name'] = $this->name;
        }
        if ($this->isNotNull($this->address)) {
            $params[$this->msgtype]['address'] = $this->address;
        }
        if ($this->isNotNull($this->latitude)) {
            $params[$this->msgtype]['latitude'] = $this->latitude;
        }
        if ($this->isNotNull($this->longitude)) {
            $params[$this->msgtype]['longitude'] = $this->longitude;
        }
        return $params;
    }
}
