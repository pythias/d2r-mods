<?php

namespace Mod\Origin\Excel\Properties;

class ElementDamages extends Base {
    public function get($param, $min, $max) : array {
        return [sprintf("等级 %d %s", $min, $param)];
    }
}