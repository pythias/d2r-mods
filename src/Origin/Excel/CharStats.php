<?php

namespace Mod\Origin\Excel;

class CharStats extends Base {
    const KeyStrOnly = "StrClassOnly";

    protected $_name = "charstats";
    private $_byClass;

    protected function _load() {
        $this->_byClass = $this->_groupBy('class');
    }

    public function getByClass($class) {
        return $this->_byClass[$class] ?? null;
    }
}