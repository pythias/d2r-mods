<?php
require __DIR__ . '/../vendor/autoload.php';

$runesByName = [];
$runes = new Mod\Origin\Excel\Runes();
$words = $runes->getValues();
foreach ($words as $id => $word) {
    $humanized = $runes->humanize($word);
    $runesByName[$humanized['name']] = $humanized;
}

$content = json_encode($runesByName, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

file_put_contents(PATH_SETTINGS . "/runes-humanized.json", $content);
