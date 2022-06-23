<?php
namespace Mod\Origin\Excel;

use mod\File\Text;

class Levels extends Base {
    protected $_name = "levels";
    private $_byName = [];

    protected function _load() {
        $this->_byName = $this->_groupBy("LevelName");
    }

    public function getByName($name) {
        return $this->_byName[$name] ?? null;
    }

    public function humanize($level) {
        return [
            'name' => $level['LevelName'],
            'waypoint' => $level['Waypoint'],
            'entry' => $level['LevelEntry'],
            'level-normal' => $level['MonLvlEx'],
            'level-nightmare' => $level['MonLvlEx(N)'],
            'level-hell' => $level['MonLvlEx(H)'],
            //MonLvlEx	MonLvlEx(N)	MonLvlEx(H)
        ];
    }
}