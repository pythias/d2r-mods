<?php
namespace Mod\Origin\Excel;

use \Mod\Origin\Excel\SkillDesc;

class Skills extends Base {
    const KEY_DESC = "skilldesc";

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

    public function getById($id) {
        return $this->_byId[$id] ?? null;
    }

    public function getStrBy($id) {
        if (is_numeric($id)) {
            return $this->getStrById($id);
        } else {
            return $this->getStrByName($id);
        }
    }

    public function getStrById($id) {
        $skill = $this->getById($id);
        if (empty($skill)) {
            return $id;
        }

        $desc = self::$_desc->getByDesc($skill[self::KEY_DESC]);
        return $desc[SkillDesc::KEY_STR_NAME] ?? $id;
    }

    public function getStrByName($name) {
        $skill = $this->_byName[$name] ?? null;
        if (empty($skill)) {
            return $name;
        }

        $desc = self::$_desc->getByDesc($skill[self::KEY_DESC]);
        return $desc[SkillDesc::KEY_STR_NAME] ?? $name;
    }
}