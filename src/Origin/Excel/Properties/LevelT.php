<?php

namespace Mod\Origin\Excel\Properties;

class LevelT extends Level {
    public function get($param, $min, $max) : array {
        return [sprintf("等级 %d %s", $min, $param)];
    }
}