<?php

namespace Mod\Origin\Excel\Properties;

class Charged extends Base {
    public function get($param, $min, $max) : array {
        //todo get level title
        return [sprintf("等级 %d %s", $min, $param)];
    }
}