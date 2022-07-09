<?php

namespace Qyweixin\Model\ExternalContact\CustomerStrategy;

/**
 * 基础权限构体
 */
class Privilege extends \Qyweixin\Model\Base
{
    /** view_customer_list	否	查看客户列表，基础权限，不可取消 */
    public $view_customer_list = NULL;
    /** view_customer_data	否	查看客户统计数据，基础权限，不可取消 */
    public $view_customer_data = NULL;
    /** view_room_list	否	查看群聊列表，基础权限，不可取消 */
    public $view_room_list = NULL;
    /** contact_me	否	可使用联系我，基础权限，不可取消 */
    public $contact_me = NULL;
    /** join_room	否	可加入群聊，基础权限，不可取消 */
    public $join_room = NULL;
    /** share_customer	否	允许分享客户给其他成员，默认为true */
    public $share_customer = NULL;
    /** oper_resign_customer	否	允许分配离职成员客户，默认为true */
    public $oper_resign_customer = NULL;
    /** oper_resign_group	否	允许分配离职成员客户群，默认为true */
    public $oper_resign_group = NULL;
    /** send_customer_msg	否	允许给企业客户发送消息，默认为true */
    public $send_customer_msg = NULL;
    /** edit_welcome_msg	否	允许配置欢迎语，默认为true */
    public $edit_welcome_msg = NULL;
    /** view_behavior_data	否	允许查看成员联系客户统计，默认为true */
    public $view_behavior_data = NULL;
    /** view_room_data	否	允许查看群聊数据统计，默认为true */
    public $view_room_data = NULL;
    /** send_group_msg	否	允许发送消息到企业的客户群，默认为true */
    public $send_group_msg = NULL;
    /** room_deduplication	否	允许对企业客户群进行去重，默认为true */
    public $room_deduplication = NULL;
    /** rapid_reply	否	配置快捷回复，默认为true */
    public $rapid_reply = NULL;
    /** onjob_customer_transfer	否	转接在职成员的客户，默认为true */
    public $onjob_customer_transfer = NULL;
    /** edit_anti_spam_rule	否	编辑企业成员防骚扰规则，默认为true */
    public $media_id = NULL;
    /** export_customer_list	否	导出客户列表，默认为true */
    public $export_customer_list = NULL;
    /** export_customer_data	否	导出成员客户统计，默认为true */
    public $export_customer_data = NULL;
    /** export_customer_group_list	否	导出客户群列表，默认为true */
    public $export_customer_group_list = NULL;
    /** manage_customer_tag	否	配置企业客户标签，默认为true */
    public $manage_customer_tag = NULL;

    public function getParams()
    {
        $params = array();

        /** view_customer_list	否	查看客户列表，基础权限，不可取消 */
        if ($this->isNotNull($this->view_customer_list)) {
            $params['view_customer_list'] = $this->view_customer_list;
        }
        /** view_customer_data	否	查看客户统计数据，基础权限，不可取消 */
        if ($this->isNotNull($this->view_customer_data)) {
            $params['view_customer_data'] = $this->view_customer_data;
        }
        /** view_room_list	否	查看群聊列表，基础权限，不可取消 */
        if ($this->isNotNull($this->view_room_list)) {
            $params['view_room_list'] = $this->view_room_list;
        }
        /** contact_me	否	可使用联系我，基础权限，不可取消 */
        if ($this->isNotNull($this->contact_me)) {
            $params['contact_me'] = $this->contact_me;
        }
        /** join_room	否	可加入群聊，基础权限，不可取消 */
        if ($this->isNotNull($this->join_room)) {
            $params['join_room'] = $this->join_room;
        }
        /** share_customer	否	允许分享客户给其他成员，默认为true */
        if ($this->isNotNull($this->share_customer)) {
            $params['share_customer'] = $this->share_customer;
        }
        /** oper_resign_customer	否	允许分配离职成员客户，默认为true */
        if ($this->isNotNull($this->oper_resign_customer)) {
            $params['oper_resign_customer'] = $this->oper_resign_customer;
        }
        /** oper_resign_group	否	允许分配离职成员客户群，默认为true */
        if ($this->isNotNull($this->oper_resign_group)) {
            $params['oper_resign_group'] = $this->oper_resign_group;
        }
        /** send_customer_msg	否	允许给企业客户发送消息，默认为true */
        if ($this->isNotNull($this->send_customer_msg)) {
            $params['send_customer_msg'] = $this->send_customer_msg;
        }
        /** edit_welcome_msg	否	允许配置欢迎语，默认为true */
        if ($this->isNotNull($this->edit_welcome_msg)) {
            $params['edit_welcome_msg'] = $this->edit_welcome_msg;
        }
        /** view_behavior_data	否	允许查看成员联系客户统计，默认为true */
        if ($this->isNotNull($this->view_behavior_data)) {
            $params['view_behavior_data'] = $this->view_behavior_data;
        }
        /** view_room_data	否	允许查看群聊数据统计，默认为true */
        if ($this->isNotNull($this->view_room_data)) {
            $params['view_room_data'] = $this->view_room_data;
        }
        /** send_group_msg	否	允许发送消息到企业的客户群，默认为true */
        if ($this->isNotNull($this->send_group_msg)) {
            $params['send_group_msg'] = $this->send_group_msg;
        }
        /** room_deduplication	否	允许对企业客户群进行去重，默认为true */
        if ($this->isNotNull($this->room_deduplication)) {
            $params['room_deduplication'] = $this->room_deduplication;
        }
        /** rapid_reply	否	配置快捷回复，默认为true */
        if ($this->isNotNull($this->rapid_reply)) {
            $params['rapid_reply'] = $this->rapid_reply;
        }
        /** onjob_customer_transfer	否	转接在职成员的客户，默认为true */
        if ($this->isNotNull($this->onjob_customer_transfer)) {
            $params['onjob_customer_transfer'] = $this->onjob_customer_transfer;
        }
        /** edit_anti_spam_rule	否	编辑企业成员防骚扰规则，默认为true */
        if ($this->isNotNull($this->edit_anti_spam_rule)) {
            $params['edit_anti_spam_rule'] = $this->edit_anti_spam_rule;
        }
        /** export_customer_list	否	导出客户列表，默认为true */
        if ($this->isNotNull($this->export_customer_list)) {
            $params['export_customer_list'] = $this->export_customer_list;
        }
        /** export_customer_data	否	导出成员客户统计，默认为true */
        if ($this->isNotNull($this->export_customer_data)) {
            $params['export_customer_data'] = $this->export_customer_data;
        }
        /** export_customer_group_list	否	导出客户群列表，默认为true */
        if ($this->isNotNull($this->export_customer_group_list)) {
            $params['export_customer_group_list'] = $this->export_customer_group_list;
        }
        /** manage_customer_tag	否	配置企业客户标签，默认为true */
        if ($this->isNotNull($this->manage_customer_tag)) {
            $params['manage_customer_tag'] = $this->manage_customer_tag;
        }
        return $params;
    }
}
