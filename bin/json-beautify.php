<?php
require __DIR__ . '/../vendor/autoload.php';

use Mod\Sys;
use Mod\Log;

if (empty($argv[1]) || !file_exists($argv[1])) {
    Log::error("請選擇需要格式化的目錄");
    exit;
}

$dir = $argv[1];
$files = Sys::exec("find {$dir} -type f | grep \".json\"");

foreach ($files as $file) {
    $items = Mod\File\Json::decode($file);
    if (empty($items)) {
        continue;
    }

    if (!Mod\File\Json::encode($file, $items)) {
        Mod\Log::error("can't beautify file '{$file}'");
    }
}

Mod\Log::info(sprintf("formatted %d", count($files)));
