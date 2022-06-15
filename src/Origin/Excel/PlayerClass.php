<?php

namespace Mod\Origin\Excel;

class PlayerClass extends Base {
    const KEY_CLASS = "Player Class";
    const KEY_CODE = "Code";

    protected $_name = "playerclass";
    private $_byCode;

    protected function _load() {
        $this->_byCode = $this->_groupBy(self::KEY_CODE);
    }

    public function getByCode($code) {
        return $this->_byCode[$code] ?? null;
    }
}