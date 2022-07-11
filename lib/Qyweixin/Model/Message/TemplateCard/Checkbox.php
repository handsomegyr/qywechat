<?php

namespace Qyweixin\Model\Message\TemplateCard;

/**
 * 选择题样式构体
 */
class Checkbox extends \Qyweixin\Model\Message\Base
{
    /** checkbox.question_key	是	选择题key值，用户提交选项后，会产生回调事件，回调事件会带上该key值表示该题，最长支持1024字节 */
    public $question_key = NULL;
    /** checkbox.mode	否	选择题模式，单选：0，多选：1，不填默认0 */
    public $mode = NULL;
    /** checkbox.option_list	是	选项list，选项个数不超过 20 个，最少1个 */
    /** checkbox.option_list.id	是	选项id，用户提交选项后，会产生回调事件，回调事件会带上该id值表示该选项，最长支持128字节，不可重复 */
    /** checkbox.option_list.text	是	选项文案描述，建议不超过17个字 */
    /** checkbox.option_list.is_checked	是	该选项是否要默认选中 */
    public $option_list = NULL;

    public function getParams()
    {
        $params = parent::getParams();

        if ($this->isNotNull($this->question_key)) {
            $params['question_key'] = $this->question_key;
        }
        if ($this->isNotNull($this->mode)) {
            $params['mode'] = $this->mode;
        }
        if ($this->isNotNull($this->option_list)) {
            $params['option_list'] = $this->option_list;
        }
        return $params;
    }
}
