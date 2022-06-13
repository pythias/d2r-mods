<?php
namespace Mod\Origin\Excel;

class Monstats extends Base {
    protected $_name = "monstats";
    private $_byIdx;

    protected function _load() {
        $this->_byIdx = $this->_groupBy('*hcIdx');
    }

    public function getByIdx($idx) {
        return $this->_byIdx[$idx] ?? null;
    }
}