<?php

namespace Mod;

class Sys {
    public static function exec($cmd) {
        $content = shell_exec($cmd);
        return explode("\n", trim($content));
    }
}