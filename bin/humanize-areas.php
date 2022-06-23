<?php
require __DIR__ . '/../vendor/autoload.php';

use Mod\Sys;
use Mod\Log;

$levels = new Mod\Origin\Excel\Levels();
$level = $levels->getByName($argv[1]);
$humanized = $levels->humanize($level);
print(json_encode($humanized, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . PHP_EOL);




