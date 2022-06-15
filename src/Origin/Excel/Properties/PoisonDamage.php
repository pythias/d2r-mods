<?php

namespace Mod\Origin\Excel\Properties;

class PoisonDamage {
    public function get($param, $min, $max) : array {
        //todo get level title
        return [sprintf("+[%d-%d] 毒素傷害，時效 %d 秒", $min, $max, $param / 25)];
    }
}