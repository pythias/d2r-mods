<?php

namespace Mod\Origin\Excel\Properties;

use Mod\Origin\Excel\CharStats;
use \Mod\Origin\Excel\Skills;

class Skill extends Base {
    private $_classIds = [
        1 => "Amazon",
        2 => "Sorceress",
        3 => "Necromancer",
        4 => "Paladin",
        5 => "Barbarian",
        6 => "Druid",
        7 => "Assassin",
    ];

    public function get($param, $min, $max) : array {
        $class = self::$_charStats->getByClass($this->_classIds[$max] ?? "Barbarian");
        $onlyStr = $class[CharStats::KeyStrOnly] ?? "BarOnly";

        return [sprintf("+%d至@%s (@%s)", $min, self::$_skills->getStrBy($param), $onlyStr)];
    }
}