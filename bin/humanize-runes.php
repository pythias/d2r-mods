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

$humanized = $runes->humanize($runes->getByName($argv[1]));
print(json_encode($humanized, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . PHP_EOL);


