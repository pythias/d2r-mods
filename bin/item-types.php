<?php
include __DIR__ . "/basic.php";

$file = __DIR__ . "/../data/origin/local/lng/strings/metadata/metadata-comments-item-names.json";
$dev_comments = decode_file($file);
$by_types = [];
$by_ids = [];
foreach ($dev_comments as $key => $value) {
    if (empty($by_types[$value['DevComment']])) {
        $by_types[$value['DevComment']] = [];
    }

    $by_types[$value['DevComment']][] = $value['id'];
    $by_ids[$value['id']] = $value['DevComment'];
}

encode_file(__DIR__ . "/../data/settings/ids.json", $by_ids);
encode_file(__DIR__ . "/../data/settings/types.json", $by_types);

