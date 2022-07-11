<?php

namespace Qyweixin\Model\Message;

/**
 * 模板卡片消息构体
 */
class TemplateCard extends \Qyweixin\Model\Message\Base
{
    /**
     * msgtype 是 消息类型，此时固定为：template_card
     */
    protected $msgtype = 'template_card';

    /** card_type	是	模板卡片类型，文本通知型卡片填写 "text_notice" */
    public $card_type = NULL;
    /** 
     * source	否	卡片来源样式信息，不需要来源样式可不填写
     * @var \Qyweixin\Model\Message\TemplateCard\Source
     */
    public $source = NULL;

    /** 
     * action_menu	否	卡片右上角更多操作按钮
     * @var \Qyweixin\Model\Message\TemplateCard\ActionMenu
     */
    public $action_menu = NULL;

    /** 
     * main_title一级标题
     * @var \Qyweixin\Model\Message\TemplateCard\MainTitle
     */
    public $main_title = NULL;

    /** quote_area	否	引用文献样式
     * @var \Qyweixin\Model\Message\TemplateCard\QuoteArea
     */
    public $quote_area = NULL;

    /** emphasis_content	否	关键数据样式
     * @var \Qyweixin\Model\Message\TemplateCard\EmphasisContent
     */
    public $emphasis_content = NULL;

    /** sub_title_text	否	二级普通文本，建议不超过160个字，（支持id转译） */
    public $sub_title_text = NULL;
    /** 
     * horizontal_content_list	否	二级标题+文本列表，该字段可为空数组，但有数据的话需确认对应字段是否必填，列表长度不超过6 
     * @var array(\Qyweixin\Model\Message\TemplateCard\HorizontalContentList)
     */
    public $horizontal_content_list = NULL;

    /** 
     * jump_list	否	跳转指引样式的列表，该字段可为空数组，但有数据的话需确认对应字段是否必填，列表长度不超过3  
     * @var array(\Qyweixin\Model\Message\TemplateCard\Jump)
     */
    public $jump_list = NULL;
    /** 
     * card_action	是	整体卡片的点击跳转事件，text_notice必填本字段 
     * @var \Qyweixin\Model\Message\TemplateCard\CardAction
     */
    public $card_action = NULL;

    /** task_id	否	任务id，同一个应用任务id不能重复，只能由数字、字母和“_-@”组成，最长128字节，填了action_menu字段的话本字段必填 */
    public $task_id = NULL;

    /** 
     * image_text_area	否	左图右文样式，news_notice类型的卡片，card_image和image_text_area两者必填一个字段，不可都不填 
     * @var \Qyweixin\Model\Message\TemplateCard\ImageTextArea
     */
    public $image_text_area = NULL;

    /** 
     * card_image	否	图片样式，news_notice类型的卡片，card_image和image_text_area两者必填一个字段，不可都不填 
     * @var \Qyweixin\Model\Message\TemplateCard\CardImage
     */
    public $card_image = NULL;

    /** 
     * vertical_content_list	否	卡片二级垂直内容，该字段可为空数组，但有数据的话需确认对应字段是否必填，列表长度不超过4 
     * @var array(\Qyweixin\Model\Message\TemplateCard\VerticalContent)
     */
    public $vertical_content_list = NULL;

    /** 
     * button_selection	是	下拉式的选择器
     * @var \Qyweixin\Model\Message\TemplateCard\ButtonSelection
     */
    public $button_selection = NULL;

    /** 
     * button_list	是	按钮列表，列表长度不超过6
     * @var array(\Qyweixin\Model\Message\TemplateCard\Button)
     */
    public $button_list = NULL;

    /** 
     * checkbox	否	选择题样式
     * @var \Qyweixin\Model\Message\TemplateCard\Checkbox
     */
    public $checkbox = NULL;

    /** 
     * submit_button	否	提交按钮样式
     * @var \Qyweixin\Model\Message\TemplateCard\SubmitButton
     */
    public $submit_button = NULL;

    /** 
     * select_list	是	下拉式的选择器列表，multiple_interaction类型的卡片该字段不可为空，一个消息最多支持 3 个选择器
     * @var array(\Qyweixin\Model\Message\TemplateCard\Button)
     */
    public $select_list = NULL;
    public function getParams()
    {
        $params = parent::getParams();

        if ($this->isNotNull($this->card_type)) {
            $params[$this->msgtype]['card_type'] = $this->card_type;
        }
        if ($this->isNotNull($this->source)) {
            $params[$this->msgtype]['source'] = $this->source->getParams();
        }
        if ($this->isNotNull($this->action_menu)) {
            $params[$this->msgtype]['action_menu'] = $this->action_menu->getParams();
        }
        if ($this->isNotNull($this->main_title)) {
            $params[$this->msgtype]['main_title'] = $this->main_title->getParams();
        }
        if ($this->isNotNull($this->quote_area)) {
            $params[$this->msgtype]['quote_area'] = $this->quote_area->getParams();
        }
        if ($this->isNotNull($this->emphasis_content)) {
            $params[$this->msgtype]['emphasis_content'] = $this->emphasis_content->getParams();
        }
        if ($this->isNotNull($this->sub_title_text)) {
            $params[$this->msgtype]['sub_title_text'] = $this->sub_title_text;
        }
        if ($this->isNotNull($this->horizontal_content_list)) {
            foreach ($this->horizontal_content_list as $horizontalContentInfo) {
                $params[$this->msgtype]['horizontal_content_list'][] = $horizontalContentInfo->getParams();
            }
        }
        if ($this->isNotNull($this->jump_list)) {
            foreach ($this->jump_list as $jumpInfo) {
                $params[$this->msgtype]['jump_list'][] = $jumpInfo->getParams();
            }
        }
        if ($this->isNotNull($this->card_action)) {
            $params[$this->msgtype]['card_action'] = $this->card_action->getParams();
        }
        if ($this->isNotNull($this->task_id)) {
            $params[$this->msgtype]['task_id'] = $this->task_id;
        }
        if ($this->isNotNull($this->vertical_content_list)) {
            foreach ($this->vertical_content_list as $verticalContentInfo) {
                $params[$this->msgtype]['vertical_content_list'][] = $verticalContentInfo->getParams();
            }
        }
        if ($this->isNotNull($this->button_selection)) {
            $params[$this->msgtype]['button_selection'] = $this->button_selection->getParams();
        }
        if ($this->isNotNull($this->button_list)) {
            foreach ($this->button_list as $buttonInfo) {
                $params[$this->msgtype]['button_list'][] = $buttonInfo->getParams();
            }
        }
        if ($this->isNotNull($this->checkbox)) {
            $params[$this->msgtype]['checkbox'] = $this->checkbox->getParams();
        }
        if ($this->isNotNull($this->submit_button)) {
            $params[$this->msgtype]['submit_button'] = $this->submit_button->getParams();
        }
        if ($this->isNotNull($this->select_list)) {
            foreach ($this->select_list as $selectInfo) {
                $params[$this->msgtype]['select_list'][] = $selectInfo->getParams();
            }
        }
        return $params;
    }
}
