<?php

namespace Mod\Origin\Excel\Properties;

class Returned extends Base {
    public function get($param, $min, $max) : array {
        //%0%% 機率將目標復生為：%1
        //reanimate, 1, 10, 10
        //10% 機率將目標復生為：返世亡靈
        $modifier = self::$_itemModifiers->get("Moditemreanimas");
        $monster = self::$_monStats->getByIdx($param);
        $monsterName = $monster['NameStr'] ?? $param;

        $name = $modifier["zhTW"] ?? "";
        if ($min == $max) {
            $name = str_replace("%0", $min, $name);
        } else {
            $name = str_replace("%0", "[{$min}-{$max}]", $name);
        }
        
        $name = str_replace("%1", "@{$monsterName}", $name);
        $name = str_replace("%%", "%", $name);
        return [$name];
    }
}