<?php
require __DIR__ . '/../vendor/autoload.php';

use Mod\Sys;
use Mod\Log;

if (empty($argv[1]) || !file_exists($argv[1])) {
    Log::error("請選擇需要格式化的目錄");
    exit;
}

$empty_langs = [
    "deDE" => "",
    "esES" => "",
    "frFR" => "",
    "itIT" => "",
    "koKR" => "",
    "plPL" => "",
    "esMX" => "",
    "jaJP" => "",
    "ptBR" => "",
    "ruRU" => "",
    "zhCN" => "",
];

$dir = $argv[1];
$files = Sys::exec("find {$dir} -type f | grep \".json\"");

foreach ($files as $file) {
    $items = Mod\File\Json::decode($file);
    if (empty($items)) {
        continue;
    }

    if (!Mod\File\Json::isI18n($items)) {
        continue;
    }

    $simplified = [];
    foreach ($items as $item) {
        $simplified[] = array_diff_key($item, $empty_langs);
    }

    if (!Mod\File\Json::encode($file, $simplified)) {
        Mod\Log::error("can't simplify file '{$file}'");
    }
}
