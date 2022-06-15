<?php

namespace Mod\Origin\Excel;

class CharStats extends Base {
    const KEY_STR_ONLY = "StrClassOnly";
    const KEY_STR_TAB1 = "StrSkillTab1";
    const KEY_STR_TAB2 = "StrSkillTab2";
    const KEY_STR_TAB3 = "StrSkillTab3";
    const KEY_STR_ALL = "StrAllSkills";

    protected $_name = "charstats";
    private $_byClass;

    protected function _load() {
        $this->_byClass = $this->_groupBy('class');
    }

    public function getByClass($class) {
        return $this->_byClass[$class] ?? null;
    }
}