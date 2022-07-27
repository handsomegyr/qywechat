<?php

namespace Qyweixin\Model\ExternalContact\GroupChat;

/**
 * 客户群进群方式构体
 */
class JoinWay extends \Qyweixin\Model\Base
{
    /**
     * config_id 是 联系方式的配置id
     */
    public $config_id = NULL;

    /**
     * scene 是	场景。1 - 群的小程序插件2 - 群的二维码插件
     */
    public $scene = NULL;

    /**
     * remark 否	联系方式的备注信息，用于助记，超过30个字符将被截断
     */
    public $remark = NULL;

    /**
     * auto_create_room	否	当群满了后，是否自动新建群。0-否；1-是。 默认为1
     */
    public $auto_create_room = NULL;

    /**
     * room_base_name	否	自动建群的群名前缀，当auto_create_room为1时有效。最长40个utf8字符
     */
    public $room_base_name = NULL;

    /**
     * room_base_id	否	自动建群的群起始序号，当auto_create_room为1时有效
     */
    public $room_base_id = NULL;

    /**
     * state	否	企业自定义的state参数，用于区分不同的入群渠道。不超过30个UTF-8字符如果有设置此参数，在调用获取客户群详情接口时会返回每个群成员对应的该参数值，详见文末附录2
     */
    public $state = NULL;

    /**
     * chat_id_list	是	使用该配置的客户群ID列表，支持5个。见客户群ID获取方法
     */
    public $chat_id_list = NULL;

    public function __construct($scene)
    {
        $this->scene = $scene;
    }

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->config_id)) {
            $params['config_id'] = $this->config_id;
        }
        if ($this->isNotNull($this->scene)) {
            $params['scene'] = $this->scene;
        }
        if ($this->isNotNull($this->remark)) {
            $params['remark'] = $this->remark;
        }
        if ($this->isNotNull($this->auto_create_room)) {
            $params['auto_create_room'] = $this->auto_create_room;
        }
        if ($this->isNotNull($this->room_base_name)) {
            $params['room_base_name'] = $this->room_base_name;
        }
        if ($this->isNotNull($this->room_base_id)) {
            $params['room_base_id'] = $this->room_base_id;
        }
        if ($this->isNotNull($this->chat_id_list)) {
            $params['chat_id_list'] = $this->chat_id_list;
        }
        if ($this->isNotNull($this->state)) {
            $params['state'] = $this->state;
        }
        return $params;
    }
}
