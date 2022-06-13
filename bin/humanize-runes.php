<?php
require __DIR__ . '/../vendor/autoload.php';

use Mod\Sys;
use Mod\Log;

$runes = new Mod\Origin\Excel\Runes();
$types = new Mod\Origin\Excel\Types();
$words = $runes->getValues();
foreach ($words as $id => $word) {
    //$v = $runes->humanize($word);
}

Log::info(json_encode($runes->humanize($words[$argv[1]]), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));


