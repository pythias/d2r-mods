<?php
include __DIR__ . "/basic.php";

$root_dir = __DIR__ . "/../data/origin/hd/items";
$main_parts = ["armor", "misc", "weapon"];
foreach ($main_parts as $main_part) {
    $items = get_exec_lines("cd {$root_dir}/{$main_part} && find . -type f | grep -v -E '\.$'");
    foreach ($items as $item) {
        $names = explode("/", substr($item, 2));
    }
}

$item_settings = __DIR__ . "/../data/origin/hd/items/items.json";
$items = decode_file($item_settings);
$item_by_part = [];
foreach ($items as $item) {
    $key = array_keys($item)[0];
    $path = $item[$key]['asset'];
    $names = explode("/", $path);
    if (empty($item_by_part[$names[0]])) {
        $item_by_part[$names[0]] = [];
    }

    $item_by_part[$names[0]][] = $key;
}

encode_file(__DIR__ . "/../data/settings/parts.json", $item_by_part);
