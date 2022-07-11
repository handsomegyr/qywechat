<?php

namespace Qyweixin\Model\Message\TemplateCard;

/**
 * 下拉式的选择器构体
 */
class ButtonSelection extends \Qyweixin\Model\Message\Base
{
    /** button_selection.question_key	是	下拉式的选择器的key，用户提交选项后，会产生回调事件，回调事件会带上该key值表示该题，最长支持1024字节 */
    public $question_key = NULL;
    /** button_selection.title	否	下拉式的选择器左边的标题 */
    public $title = NULL;
    /** button_selection.selected_id	否	默认选定的id，不填或错填默认第一个 */
    public $selected_id = NULL;
    /** button_selection.option_list	是	选项列表，下拉选项不超过 10 个，最少1个 */
    /** button_selection.option_list.id	是	下拉式的选择器选项的id，用户提交后，会产生回调事件，回调事件会带上该id值表示该选项，最长支持128字节，不可重复 */
    /** button_selection.option_list.text	是	下拉式的选择器选项的文案，建议不超过16个字 */
    public $option_list = NULL;

    public function getParams()
    {
        $params = parent::getParams();

        if ($this->isNotNull($this->question_key)) {
            $params['question_key'] = $this->question_key;
        }
        if ($this->isNotNull($this->title)) {
            $params['title'] = $this->title;
        }
        if ($this->isNotNull($this->selected_id)) {
            $params['selected_id'] = $this->selected_id;
        }
        if ($this->isNotNull($this->option_list)) {
            $params['option_list'] = $this->option_list;
        }
        return $params;
    }
}
