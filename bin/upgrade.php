<?php
require __DIR__ . '/../vendor/autoload.php';

use Mod\Sys;
use Mod\Log;

$files = Sys::exec("find " . PATH_DATA_MY . "/local/lng/strings/ -type f | grep \".json\"");

foreach ($files as $file) {
    $name = pathinfo($file, PATHINFO_FILENAME);
    $items = Mod\File\Json::decode($file);
    if (empty($items)) {
        continue;
    }

    $originFile = PATH_DATA_ORIGIN . "/local/lng/strings/{$name}.json";
    $originItems = Mod\File\Json::decode($originFile);
    if (empty($originItems)) {
        continue;
    }

    if (!Mod\File\Json::isI18n($items) || !Mod\File\Json::isI18n($originItems)) {
        continue;
    }

    $itemsById = [];
    foreach ($items as $item) {
        $itemsById[$item['id']] = $item;
    }

    $originItemsById = [];
    foreach ($originItems as $item) {
        $originItemsById[$item['id']] = $item;
    }

    foreach ($originItemsById as $id => $item) {
        if (empty($itemsById[$id])) {
            $items[] = $item;
        }
    }

    if (!Mod\File\Json::encode($file, $items)) {
        Log::error("can't merge file '{$file}'");
    }
}
