<?php
namespace Mod\Origin\Excel;

class SkillDesc extends Base {
    const KEY_DESC = "skilldesc";
    const KEY_STR_NAME = "str name";

    protected $_name = "skilldesc";
    private $_byDesc;

    protected function _load() {
        $this->_byDesc = $this->_groupBy(self::KEY_DESC);
    }

    public function getByDesc($desc) {
        return $this->_byDesc[$desc] ?? null;
    }
}