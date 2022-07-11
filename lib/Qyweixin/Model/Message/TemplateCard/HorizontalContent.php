<?php

namespace Qyweixin\Model\Message\TemplateCard;

/**
 * 二级标题+文本列表构体
 */
class HorizontalContent extends \Qyweixin\Model\Message\Base
{
    /** horizontal_content_list.type	否	链接类型，0或不填代表不是链接，1 代表跳转url，2 代表下载附件，3 代表点击跳转成员详情 */
    public $type = NULL;
    /** horizontal_content_list.keyname	是	二级标题，建议不超过5个字 */
    public $keyname = NULL;
    /** horizontal_content_list.value	否	二级文本，如果horizontal_content_list.type是2，该字段代表文件名称（要包含文件类型），建议不超过30个字，（支持id转译） */
    public $value = NULL;
    /** horizontal_content_list.url	否	链接跳转的url，horizontal_content_list.type是1时必填 */
    public $url = NULL;
    /** horizontal_content_list.media_id	否	附件的media_id，horizontal_content_list.type是2时必填 */
    public $media_id = NULL;
    /** horizontal_content_list.userid	否	成员详情的userid，horizontal_content_list.type是3时必填 */
    public $userid = NULL;    

    public function getParams()
    {
        $params = parent::getParams();

        if ($this->isNotNull($this->type)) {
            $params['type'] = $this->type;
        }
        if ($this->isNotNull($this->keyname)) {
            $params['keyname'] = $this->keyname;
        }
        if ($this->isNotNull($this->value)) {
            $params['value'] = $this->value;
        }
        if ($this->isNotNull($this->url)) {
            $params['url'] = $this->url;
        }
        if ($this->isNotNull($this->media_id)) {
            $params['media_id'] = $this->media_id;
        }
        if ($this->isNotNull($this->userid)) {
            $params['userid'] = $this->userid;
        }
        return $params;
    }
}
