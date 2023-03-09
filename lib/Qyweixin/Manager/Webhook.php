<?php

namespace Qyweixin\Manager;

use Qyweixin\Client;

/**
 * https://developer.work.weixin.qq.com/document/path/91770
 * 使用群机器人
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class Webhook
{
    // 接口地址
    private $_url = 'https://qyapi.weixin.qq.com/cgi-bin/webhook/';
    private $_client;
    private $_request;
    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 在终端某个群组添加机器人之后，创建者可以在机器人详情页看的该机器人特有的webhookurl。开发者可以按以下说明向这个地址发起HTTP POST 请求，即可实现给该群组发送消息。下面举个简单的例子.
     * 假设webhook是：https://qyapi.weixin.qq.com/cgi-bin/webhook/send?key=693a91f6-7xxx-4bc4-97a0-0ec2sifa5aaa
     * 特别特别要注意：一定要保护好机器人的webhook地址，避免泄漏！不要分享到github、博客等可被公开查阅的地方，否则坏人就可以用你的机器人来发垃圾消息了。
     * 以下是用curl工具往群组推送文本消息的示例（注意要将url替换成你的机器人webhook地址，content必须是utf8编码）：
     *
     * curl 'https://qyapi.weixin.qq.com/cgi-bin/webhook/send?key=693axxx6-7aoc-4bc4-97a0-0ec2sifa5aaa' \
     * -H 'Content-Type: application/json' \
     * -d '
     * {
     * "msgtype": "text",
     * "text": {
     * "content": "hello world"
     * }
     * }'
     * 当前自定义机器人支持文本（text）、markdown（markdown）、图片（image）、图文（news）四种消息类型。
     * 机器人的text/markdown类型消息支持在content中使用<@userid>扩展语法来@群成员
     */
    public function send($key, \Qyweixin\Model\RobotMsg\Base $message)
    {
        $query = array(
            'key' => $key
        );
        $params = $message->getParams();
        // $headers = array();
        // $headers['Content-Type'] = 'application/json';
        $options = array();
        // $options['headers'] = $headers;
        // $this->_request->setAccessToken("");
        // $this->_request->setAccessTokenName("");
        $rst = $this->_request->post($this->_url . "send", $params, $options, "", $query);
        return $this->_client->rst($rst);
    }

    /**
     * 文件上传接口
     * 素材上传得到media_id，该media_id仅三天内有效
     * media_id只能是对应上传文件的机器人可以使用
     * 请求方式：POST（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/webhook/upload_media?key=KEY&type=TYPE
     *
     * 使用multipart/form-data POST上传文件， 文件标识名为"media"
     * 参数说明：
     *
     * 参数 必须 说明
     * key 是 调用接口凭证, 机器人webhookurl中的key参数
     * type 是 固定传file
     * POST的请求包中，form-data中媒体文件标识，应包含有 filename、filelength、content-type等信息
     *
     * filename标识文件展示的名称。比如，使用该media_id发消息时，展示的文件名由该字段控制
     * 请求示例：
     *
     * POST https://qyapi.weixin.qq.com/cgi-bin/webhook/upload_media?key=693a91f6-7xxx-4bc4-97a0-0ec2sifa5aaa&type=file HTTP/1.1
     * Content-Type: multipart/form-data; boundary=-------------------------acebdf13572468
     * Content-Length: 220
     *
     * ---------------------------acebdf13572468
     * Content-Disposition: form-data; name="media";filename="wework.txt"; filelength=6
     * Content-Type: application/octet-stream
     *
     * mytext
     * ---------------------------acebdf13572468--
     * 返回数据：
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "type": "file",
     * "media_id": "1G6nrLmr5EC3MMb_-zK1dDdzmd0p7cNliYu9V5w7o8K0",
     * "created_at": "1380000000"
     * }
     * 参数说明：
     *
     * 参数 说明
     * type 媒体文件类型，分别有图片（image）、语音（voice）、视频（video），普通文件(file)
     * media_id 媒体文件上传后获取的唯一标识，3天内有效
     * created_at 媒体文件上传时间戳
     * 上传的文件限制：
     *
     * 要求文件大小在5B~20M之间
     */
    public function uploadMedia($key, $type, $media)
    {
        $query = array(
            'key' => $key,
            'type' => $type
        );
        $options = array(
            'fieldName' => 'media'
        );
        return $this->_request->uploadFile($this->_url . "upload_media", $media, $options, $query);
    }
}
