<?php

namespace Qyweixin\Model;

/**
 * 信息
 */
abstract class Base
{

    public function getParams()
    {
        $params = array();
        return $params;
    }

    protected function isNotNull($var)
    {
        return !is_null($var);
    }
}
