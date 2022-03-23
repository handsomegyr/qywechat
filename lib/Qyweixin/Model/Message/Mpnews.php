<?php

namespace Qyweixin\Model\Message;

/**
 * 图文消息构体
 */
class Mpnews extends \Qyweixin\Model\Message\Base
{

    /**
     * msgtype 是 消息类型，此时固定为：mpnews
     */
    protected $msgtype = 'mpnews';

    /**
     * articles 是 图文消息，一个图文消息支持1到8条图文
     */
    public $articles = NULL;

    public function __construct($agentid, array $articles, $touser = '@all')
    {
        $this->agentid = $agentid;
        $this->articles = $articles;
        $this->touser = $touser;
    }

    public function getParams()
    {
        $params = parent::getParams();

        if (!empty($this->articles)) {
            foreach ($this->articles as $article) {
                $params[$this->msgtype]['articles'][] = $article;
            }
        }

        return $params;
    }
}
