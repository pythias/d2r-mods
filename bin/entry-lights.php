<?php
require __DIR__ . '/../vendor/autoload.php';

use Mod\Sys;
use Mod\Log;

$files = Sys::exec("find " . PATH_DATA_MY . "/hd/roomtiles/ -type f | grep \".json\"");
$defaultFile = PATH_DATA_MY . "/hd/roomtiles/entry_default.json";
$template = Mod\File\Json::decode($defaultFile);

foreach ($files as $file) {
    $name = pathinfo($file, PATHINFO_FILENAME);
    if (strpos($name, "entry_") !== false) {
        continue;
    }

    $template['name'] = $name;

    if (!Mod\File\Json::encode($file, $template)) {
        Log::error("can't merge file '{$file}'");
    }
}
