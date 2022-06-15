<?php

namespace Mod\Origin\Excel\Properties;

use \Mod\Origin\Excel\CharStats;
use \Mod\Origin\Excel\Skills;
use \Mod\Origin\Excel\PlayerClass;

class Skill extends Base {
    public function get($param, $min, $max) : array {
        $skill = self::$_skills->getBy($param);
        $charClass = $this->_getCharClass($skill[Skills::KEY_CHAR_CLASS] ?? null);
        $onlyStr = $charClass[CharStats::KEY_STR_ONLY] ?? false;

        if ($min == $max) {
            return [sprintf("+%d至@%s (@%s)", $min, self::$_skills->getStrBy($param), $onlyStr)];
        } else {
            return [sprintf("+[%d-%d]至@%s (@%s)", $min, $max, self::$_skills->getStrBy($param), $onlyStr)];
        }
    }
}