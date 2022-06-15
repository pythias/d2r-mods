<?php

namespace Mod\Origin\Excel\Properties;

class ElementDamages extends Base {
    public function get($param, $min, $max) : array {
        return [
            sprintf("附加 %d - %d 電擊傷害", $min, $max),
            sprintf("附加 %d - %d 火焰傷害", $min, $max),
            sprintf("附加 %d - %d 冰寒傷害", $min, $max),
        ];
    }
}