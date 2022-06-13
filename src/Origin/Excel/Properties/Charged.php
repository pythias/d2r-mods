<?php

namespace Mod\Origin\Excel\Properties;

class Charged extends Base {
    public function get($param, $min, $max) : array {
        $skillStr = "@" . self::$_skills->getStrBy($param);
        if ($max > 0) {
            return [sprintf("等級 %d %s (%d 次)", $max, $skillStr, $min)];
        }

        return [sprintf("等級 %d %s", $min, $skillStr)];
    }
}