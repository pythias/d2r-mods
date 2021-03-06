<?php
namespace Mod\Origin\Excel;

use \Mod\Origin\Excel\SkillDesc;

class Skills extends Base {
    const KEY_DESC = "skilldesc";
    const KEY_CHAR_CLASS = "charclass";

    protected $_name = "skills";
    private $_byId;
    private $_byName;

    private static $_desc;

    protected function _load() {
        $this->_byId = $this->_groupBy('*Id');
        $this->_byName = $this->_groupBy('skill');

        if (empty(self::$_desc)) {
            self::$_desc = new SkillDesc(true);
        }
    }

    public function getBy($id) {
        if (is_numeric($id)) {
            return $this->getById($id);
        } else {
            return $this->getByName($id);
        }
    }

    public function getById($id) {
        return $this->_byId[$id] ?? null;
    }

    public function getByName($name) {
        return $this->_byName[$name] ?? null;
    }

    public function getStrBy($id) {
        $skill = $this->getBy($id);
        if (empty($skill)) {
            return $id;
        }

        $desc = self::$_desc->getByDesc($skill[self::KEY_DESC]);
        return $desc[SkillDesc::KEY_STR_NAME] ?? $id;
    }
}