<?php
namespace Mod;

class Log {
    public static function info($message) {
        echo "\033[01;32m[INFO]\033[0m" . date('H:i:s') . " {$message}\n";
    }

    public static function error($message) {
        echo "\033[01;31m[ERROR]\033[0m" . date('H:i:s') . " {$message}\n";
    }
}