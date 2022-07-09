<?php

namespace Qyweixin\Model\ExternalContact\CustomerStrategy;

/**
 * 规则组的管理范围节点类型构体
 */
class Range extends \Qyweixin\Model\Base
{

    /**
     * type	是	规则组的管理范围节点类型 1-成员 2-部门
     */
    public $type = NULL;

    /**
     * userid	否	规则组的管理成员id
     */
    public $userid = NULL;

    /**
     * partyid	否	规则组的管理部门id
     */
    public $partyid = NULL;

    public function __construct($type)
    {
        $this->type = $type;
    }

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->type)) {
            $params['type'] = $this->type;
        }
        if ($this->isNotNull($this->userid)) {
            $params['userid'] = $this->userid;
        }
        if ($this->isNotNull($this->partyid)) {
            $params['partyid'] = $this->partyid;
        }
        return $params;
    }
}
