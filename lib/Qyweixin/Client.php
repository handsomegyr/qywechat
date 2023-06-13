<?php

/**
 * 企业微信客户端总调度器
 * 
 * @author guoyongrong <handsomegyr@126.com>
 *
 */

namespace Qyweixin;

use Qyweixin\Manager\Ip;
use Qyweixin\Manager\Kf;
use Qyweixin\Manager\Oa;
use Qyweixin\Manager\Tag;
use Qyweixin\Manager\Card;
use Qyweixin\Manager\Corp;
use Qyweixin\Manager\Dial;
use Qyweixin\Manager\Menu;
use Qyweixin\Manager\User;
use Qyweixin\Model\Config;
use Qyweixin\Manager\Agent;
use Qyweixin\Manager\Batch;
use Qyweixin\Manager\Media;
use Qyweixin\Manager\Reply;
use Qyweixin\Manager\Export;
use Qyweixin\Manager\Health;
use Qyweixin\Manager\Living;
use Qyweixin\Manager\Appchat;
use Qyweixin\Manager\Checkin;
use Qyweixin\Manager\License;
use Qyweixin\Manager\Message;
use Qyweixin\Manager\Webhook;
use Qyweixin\Manager\MsgAudit;
use Qyweixin\Manager\Idconvert;
use Qyweixin\Manager\Department;
use Qyweixin\Manager\Linkedcorp;
use Qyweixin\Manager\ExternalContact;

class Client
{

    private $_from;
    private $_to;

    private $_corpId;

    private $_corpSecret;

    private $_request = null;

    private $_accessToken = null;

    private $_config = null;

    public function __construct($corpId, $corpSecret, Config $conf = null)
    {
        $this->_corpId = $corpId;
        $this->_corpSecret = $corpSecret;
        $this->_config = $conf;
    }

    public function getConfig()
    {
        return $this->_config;
    }

    public function setConfig(Config $conf)
    {
        $this->_config = $conf;
        return $this;
    }

    public function getCorpId()
    {
        return $this->_corpId;
    }

    public function getCorpSecret()
    {
        return $this->_corpSecret;
    }

    /**
     * 获取服务端的accessToken
     *
     * @throws Exception
     */
    public function getAccessToken()
    {
        if (empty($this->_accessToken)) {
            throw new \Exception("请设定access_token");
        }
        return $this->_accessToken;
    }

    /**
     * 设定服务端的access token
     *
     * @param string $accessToken            
     */
    public function setAccessToken($accessToken)
    {
        $this->_accessToken = $accessToken;
        return $this;
    }

    /**
     * 获取来源用户
     *
     * @throws Exception
     */
    public function getFromUserName()
    {
        if (empty($this->_from))
            throw new \Exception('请设定FromUserName');
        return $this->_from;
    }

    /**
     * 获取目标用户
     *
     * @throws Exception
     */
    public function getToUserName()
    {
        if (empty($this->_to))
            throw new \Exception('请设定ToUserName');
        return $this->_to;
    }

    /**
     * 设定来源和目标用户
     *
     * @param string $fromUserName            
     * @param string $toUserName            
     */
    public function setFromAndTo($fromUserName, $toUserName)
    {
        $this->_from = $toUserName;
        $this->_to = $fromUserName;
        return $this;
    }

    /**
     * 初始化认证的http请求对象
     */
    private function initRequest()
    {
        $this->_request = new \Qyweixin\Http\Request($this->getAccessToken());
        $this->_request->setClient($this);
    }

    /**
     * 获取请求对象
     *
     * @return \Qyweixin\Http\Request
     */
    public function getRequest()
    {
        if (empty($this->_request)) {
            $this->initRequest();
        }
        return $this->_request;
    }

    /**
     * 获取应用管理
     *
     * @return \Qyweixin\Manager\Agent
     */
    public function getAgentManager()
    {
        return new Agent($this);
    }

    /**
     * 获取发送消息到群聊会话管理器
     *
     * @return \Qyweixin\Manager\Appchat
     */
    public function getAppchatManager()
    {
        return new Appchat($this);
    }

    /**
     * 获取批量管理器
     *
     * @return \Qyweixin\Manager\Batch
     */
    public function getBatchManager()
    {
        return new Batch($this);
    }

    /**
     * 获取卡管理器
     *
     * @return \Qyweixin\Manager\Card
     */
    public function getCardManager()
    {
        return new Card($this);
    }

    /**
     * 获取企业微信打卡应用管理器
     *
     * @return \Qyweixin\Manager\Checkin
     */
    public function getCheckinManager()
    {
        return new Checkin($this);
    }


    /**
     * 获取部门管理器
     *
     * @return \Qyweixin\Manager\Department
     */
    public function getDepartmentManager()
    {
        return new Department($this);
    }


    /**
     * 获取企业微信公费电话管理器
     *
     * @return \Qyweixin\Manager\Dial
     */
    public function getDialManager()
    {
        return new Dial($this);
    }


    /**
     * 获取外部企业的联系人管理器
     *
     * @return \Qyweixin\Manager\ExternalContact
     */
    public function getExternalContactManager()
    {
        return new ExternalContact($this);
    }


    /**
     * 获取企业微信服务器IP地址管理器
     *
     * @return \Qyweixin\Manager\Ip
     */
    public function getIpManager()
    {
        return new Ip($this);
    }

    /**
     * 获取互联企业管理器
     *
     * @return \Qyweixin\Manager\Linkedcorp
     */
    public function getLinkedcorpManager()
    {
        return new Linkedcorp($this);
    }

    /**
     * 获取素材管理器
     *
     * @return \Qyweixin\Manager\Media
     */
    public function getMediaManager()
    {
        return new Media($this);
    }

    /**
     * 获取菜单管理器
     *
     * @return \Qyweixin\Manager\Menu
     */
    public function getMenuManager()
    {
        return new Menu($this);
    }

    /**
     * 获取主动发送消息器
     *
     * @return \Qyweixin\Manager\Message
     */
    public function getMessageManager()
    {
        return new Message($this);
    }

    /**
     * 获取企业微信审批应用管理器
     *
     * @return \Qyweixin\Manager\Oa
     */
    public function getOaManager()
    {
        return new Oa($this);
    }

    /**
     * 获取被动回复发送器
     *
     * @return \Qyweixin\Manager\Reply
     */
    public function getReplyManager()
    {
        return new Reply($this);
    }

    /**
     * 获取标签管理器
     *
     * @return \Qyweixin\Manager\Tag
     */
    public function getTagManager()
    {
        return new Tag($this);
    }

    /**
     * 获取成员管理器
     *
     * @return \Qyweixin\Manager\User
     */
    public function getUserManager()
    {
        return new User($this);
    }

    /**
     * 获取会话内容存档管理器
     *
     * @return \Qyweixin\Manager\MsgAudit
     */
    public function getMsgAuditManager()
    {
        return new MsgAudit($this);
    }

    /**
     * 获取企业直播管理器
     *
     * @return \Qyweixin\Manager\Living
     */
    public function getLivingManager()
    {
        return new Living($this);
    }

    /**
     * 获取健康上报管理器
     *
     * @return \Qyweixin\Manager\Health
     */
    public function getHealthManager()
    {
        return new Health($this);
    }

    /**
     * 获取微信客服管理器
     *
     * @return \Qyweixin\Manager\Kf
     */
    public function getKfManager()
    {
        return new Kf($this);
    }

    /**
     * 获取导出管理器
     *
     * @return \Qyweixin\Manager\Export
     */
    public function getExportManager()
    {
        return new Export($this);
    }

    /**
     * 获取接口调用许可管理器
     *
     * @return \Qyweixin\Manager\License
     */
    public function getLicenseManager()
    {
        return new License($this);
    }

    /**
     * 获取ID转换接口管理器
     *
     * @return \Qyweixin\Manager\Idconvert
     */
    public function getIdconvertManager()
    {
        return new Idconvert($this);
    }

    /**
     * 获取Corp管理器
     *
     * @return \Qyweixin\Manager\Corp
     */
    public function getCorpManager()
    {
        return new Corp($this);
    }

    /**
     * 获取Webhook管理器
     *
     * @return \Qyweixin\Manager\Webhook
     */
    public function getWebhookManager()
    {
        return new Webhook($this);
    }

    /**
     * 签名校验
     * 
     * @param string $token            
     * @param string $encodingAesKey            
     * @return array
     */
    public function checkSignature($token, $encodingAesKey = "")
    {
        $token = trim($token);
        $signature = isset($_GET['msg_signature']) ? trim($_GET['msg_signature']) : '';
        $timestamp = isset($_GET['timestamp']) ? trim($_GET['timestamp']) : '';
        $nonce = isset($_GET['nonce']) ? trim($_GET['nonce']) : '';
        $echostr = isset($_GET['echostr']) ? trim($_GET['echostr']) : '';

        // 需要返回的明文
        $sEcsReplyEchoStrhoStr = "";
        $wxcpt = new \Qyweixin\ThirdParty\MsgCrypt\WXBizMsgCrypt($token, $encodingAesKey, $this->getCorpId());
        $errCode = $wxcpt->VerifyURL($signature, $timestamp, $nonce, $echostr, $sEcsReplyEchoStrhoStr);

        if ($errCode == 0) {
            // 验证URL成功，将sEchoStr返回
            return array(
                'replyEchoStr' => $sEcsReplyEchoStrhoStr
            );
        } else {
            return false;
        }
    }

    /**
     * 有效性校验
     */
    public function verify($token, $encodingAesKey = "")
    {
        if (empty($token)) {
            throw new \Exception("请设定校验签名所需的token");
        }

        $ret = $this->checkSignature($token, $encodingAesKey);

        if (!empty($ret)) {
            exit($ret['replyEchoStr']);
        }
    }

    /**
     * 标准化处理微信的返回结果
     */
    public function rst($rst)
    {
        return $rst;
    }
}
