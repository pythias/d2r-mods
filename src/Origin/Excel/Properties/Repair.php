<?php

namespace Mod\Origin\Excel\Properties;

class Repair extends Base {
    public function get($param, $min, $max) : array {
        $modifier = self::$_itemModifiers->get("ModStre9u"); //ModStre9t
        $name = $modifier["zhTW"] ?? "";
        $name = str_replace("%1", 100 / $param, $name);
        $name = str_replace("%0", 1, $name);
        return [$name];
    }
}