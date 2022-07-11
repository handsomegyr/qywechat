<?php

namespace Qyweixin\Model\Message\TemplateCard;

/**
 * 卡片右上角更多操作按钮构体
 */
class ActionMenu extends \Qyweixin\Model\Message\Base
{
    /** action_menu.desc	否	更多操作界面的描述 */
    public $desc = NULL;
    /** action_menu.action_list	是	操作列表，列表长度取值范围为 [1, 3] */
    /** action_menu.action_list.text	是	操作的描述文案 */
    /** action_menu.action_list.key	是	操作key值，用户点击后，会产生回调事件将本参数作为EventKey返回，回调事件会带上该key值，最长支持1024字节，不可重复 */
    public $action_list = NULL;

    public function getParams()
    {
        $params = parent::getParams();

        if ($this->isNotNull($this->desc)) {
            $params['desc'] = $this->desc;
        }
        if ($this->isNotNull($this->action_list)) {
            $params['action_list'] = $this->action_list;
        }
        return $params;
    }
}
