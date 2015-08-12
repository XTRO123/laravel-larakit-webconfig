<?php
namespace Larakit;

use Carbon\Carbon;

class WebconfigItem {
    protected $code;
    protected $group;
    protected $values;

    function __construct($code, $group) {
        $this->code = $code;
        $this->setGroup($group);
    }

    protected function _($k, $v) {
        $k                = mb_strtolower(mb_substr($k, 3));
        $this->values[$k] = $v;
        return $this;
    }

    function setGroup($value) {
        return $this->_(__FUNCTION__, $value);
    }

    function setWidget($value) {
        return $this->_(__FUNCTION__, $value);
    }

    function setOptions($value) {
        return $this->_(__FUNCTION__, $value);
    }

    function setType($value) {
        return $this->_(__FUNCTION__, $value);
    }

    function setValue($value) {
        return $this->_(__FUNCTION__, $value);
    }

    function setExample($value) {
        return $this->_(__FUNCTION__, $value);
    }

    function setDesc($value) {
        return $this->_(__FUNCTION__, $value);
    }

    function setLabel($value) {
        return $this->_(__FUNCTION__, $value);
    }

    function put() {
        Webconfig::$defaults[$this->code] = $this->values;
    }
}