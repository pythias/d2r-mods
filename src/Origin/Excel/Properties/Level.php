<?php

namespace Mod\Origin\Excel\Properties;

class Level extends Base {
    public function get($param, $min, $max) : array {
        return [sprintf("等级 %d %s", $min, $param)];
    }
}