<?php
namespace Mod\Origin\Excel;

class Types extends Base {
    protected $_name = "itemtypes";
    private $_byCode;

    protected function _load() {
        $this->_byCode = $this->_groupBy('Code');
    }

    public function getByCode($code) {
        return $this->_byCode[$code] ?? null;
    }
}