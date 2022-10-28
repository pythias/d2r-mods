<?php
require __DIR__ . '/../vendor/autoload.php';

$areasByName = [];
$levels = new Mod\Origin\Excel\Levels();
$areas = $levels->getValues();
foreach ($areas as $area) {
    $humanized = $levels->humanize($area);
    $areasByName[$humanized['name']] = $humanized;
}

//$level = $levels->getByName($argv[1]);

$content = json_encode($areasByName, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

file_put_contents(PATH_SETTINGS . "/areas-level.json", $content);

