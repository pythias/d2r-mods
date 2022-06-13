<?php
require __DIR__ . '/../vendor/autoload.php';

use Mod\Sys;
use Mod\Log;

$runes = new Mod\Origin\Excel\Runes();
$types = new Mod\Origin\Excel\Types();
$words = $runes->getValues();
foreach ($words as $id => $word) {
    try {
        //Log::info("word:{$word['*Rune Name']}");
        $runes->humanize($word);
        var_dump($runes->humanize($word));
    } catch (Exception $e) {
        Log::error("{$word['*Rune Name']} error:{$e->getMessage()}");
    }
}

Mod\Log::info(sprintf("runes %d", count($runes->getValues())));

