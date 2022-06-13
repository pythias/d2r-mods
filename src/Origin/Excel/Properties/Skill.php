<?php

namespace Mod\Origin\Excel\Properties;

use \Mod\Origin\Excel\Skills;

class Skill extends Base {
    public function get($param, $min, $max) : array {
        return [sprintf("等級 %d %s", $min, "@" . self::$_skills->getStrByName($param))];
    }
}