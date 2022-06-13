<?php

namespace Mod\Origin\Excel\Properties;

class PoisonDamage {
    public function get($param, $min, $max) : array {
        //todo get level title
        return [sprintf("Adds %d-%d Poison Damage Over %d Seconds", $min, $max, $param / 25)];
    }
}