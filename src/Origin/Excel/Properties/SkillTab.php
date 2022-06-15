<?php

namespace Mod\Origin\Excel\Properties;

use \Mod\Origin\Excel\CharStats;

class SkillTab extends Base {
    //[Class Skill Tab ID] = (Amazon = 0-2, Sorceress = 3-5, Necromancer = 6-8, Paladin = 9-11, Barbarian = 12-14, Druid = 15-17,  Assassin = 18-20)
    private $_classNames = [
        "Amazon",
        "Sorceress",
        "Necromancer",
        "Paladin",
        "Barbarian",
        "Druid",
        "Assassin",
    ];

    public function get($param, $min, $max) : array {
        $classIdx = floor($param / 3);
        $tabIdx = 1 + $param % 3;
        $class = self::$_charStats->getByClass($this->_classNames[$classIdx] ?? "Barbarian");
        $tabStr = $class["StrSkillTab{$tabIdx}"] ?? "StrSklTabItem11";
        $onlyStr = $class[CharStats::KEY_STR_ONLY] ?? "BarOnly";

        if ($max == $min) {
            return [sprintf("+%d @%s (@%s)", $min, $tabStr, $onlyStr)];
        }

        return [sprintf("+[%d-%d] @%s (@%s)", $min, $max, $tabStr, $onlyStr)];
    }
}