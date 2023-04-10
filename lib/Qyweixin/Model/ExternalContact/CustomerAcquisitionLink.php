<?php

namespace Qyweixin\Model\ExternalContact;

/**
 * 获客链接
 */
class CustomerAcquisitionLink extends \Qyweixin\Model\Base
{

    /**
     * link_name	否	链接名称
     */
    public $link_name = NULL;

    /**
     * link_id	否	发表任务的执行者部门列表
     */
    public $link_id = NULL;

    /**
     * range 关联范围
     *
     * @var \Qyweixin\Model\ExternalContact\CustomerAcquisitionLinkRange
     */
    public $range = null;

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->link_id)) {
            $params['link_id'] = $this->link_id;
        }
        if ($this->isNotNull($this->link_name)) {
            $params['link_name'] = $this->link_name;
        }
        if ($this->isNotNull($this->range)) {
            $params['range'] = $this->range->getParams();
        }
        return $params;
    }
}
