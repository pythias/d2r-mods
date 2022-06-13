<?php
require __DIR__ . '/../vendor/autoload.php';

use Mod\Sys;

$keep_ext = ['json', 'txt'];

$files = Sys::exec("find " . PATH_DATA_ORIGIN . " -type f");

foreach ($files as $file) {
    if (in_array(pathinfo($file, PATHINFO_EXTENSION), $keep_ext)) {
        continue;
    }

    shell_exec("rm -f {$file}");
}

shell_exec("find " . PATH_DATA_ORIGIN . " -type d -empty -delete");
