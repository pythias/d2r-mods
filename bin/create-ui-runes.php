<?php
include __DIR__ . "/basic.php";

function type_by_code($type_items) {
    $types_by_code = [];
    foreach ($type_items as $item) {
        $types_by_code[$item['Code']] = $item;
    }

    return $types_by_code;
}

function get_rune_word_types($word, $type_items) {
    $values = [];
    for ($i = 1; $i <= 6; $i++) {
        if (empty($word["itype{$i}"])) {
            break;
        }

        $code = $word["itype{$i}"];
        if (empty($type_items[$code])) {
            continue;
        }
        
        $values[$code] = $type_items[$code]['ItemType'];
    }

    return $values;
}

function get_rune_word_runes($word, $cn_names, $en_names) {
    $values = [];
    for ($i=1; $i <= 6; $i++) { 
        if (empty($word["Rune{$i}"])) {
            break;
        }

        $key = $word["Rune{$i}"];
        $title_cn = $cn_names["{$key}L"] ?? '';
        $title_en = $en_names[$key] ?? '';
        $num = intval(substr($key, 1));
        $values[$num] = [$title_cn, $title_en];
    }

    return $values;
}

function create_rune_panel($simplify_rune_words, $rune_cn_names, $rune_en_names, $num) {
    $name = "ModRune{$num}Panel";
    $base_config = decode_file(MY_PATH . "/global/ui/layouts/ModRuneBasehb.json");
    $items_config = $base_config['children'][0]['children'][1]['children'][4]['children'][0]['children'];
    $base_item = array_pop($items_config);
    
    foreach ($simplify_rune_words as $rune_word) {
        if (empty($rune_word['runes'][$num])) {
            continue;
        }
    
        $item_config = $base_item;
    
        $word_item_types = array_values($rune_word['types']);
        $item_config['children'][0]['fields']['text'] = sprintf("%s(%s)", $rune_word['title'], $rune_word['name']);
        $item_config['children'][1]['fields']['text'] = sprintf("%dS %s", count($rune_word['runes']), implode(",",  $word_item_types));
        $item_config['children'][2]['fields']['text'] = implode(", ", array_keys($rune_word['runes']));
        $item_config['children'][3]['fields']['tooltipString'] = $rune_word['descript'];
    
        $items_config[] = $item_config;
    }
    
    $rune_key = sprintf("r%02dL", $num);
    $base_config['children'][0]['children'][1]['children'][1]['fields']['text'] = sprintf("%s %s #%d", $rune_cn_names[$rune_key], $rune_en_names[$rune_key], $num);
    $base_config['children'][0]['children'][1]['children'][2]['fields']['onClickMessage'] = "PanelManager:ClosePanel:{$name}";
    $base_config['name'] = $name;
    $base_config['children'][0]['children'][1]['children'][4]['children'][0]['children'] = $items_config;
    
    encode_file(MY_PATH . "/global/ui/layouts/ModRune{$num}Panelhd.json", $base_config);
}

$rune_words = parse_txt(ORIGIN_PATH . "/global/excel/runes.txt");
$rune_descripts = decode_file(SETTINGS_PATH . "/runes.json");
$rune_cn_names = get_names("item-runes");
$rune_en_names = get_names("item-runes", "enUS");
$item_names = get_names("item-names");
$item_types = type_by_code(parse_txt(ORIGIN_PATH . "/global/excel/itemtypes.txt"));
$simplify_rune_words = [];

foreach ($rune_words as $rune_word) {
    $name = $rune_word['*Rune Name'];
    if (empty($rune_cn_names[$rune_word["Name"]])) {
        log_error("empty title, {$name}");
        continue;
    }

    $title = $rune_cn_names[$rune_word["Name"]];
    if (empty($rune_descripts[$name])) {
        log_error("empty descript, {$title}, {$name}");
        continue;
    }

    $types = get_rune_word_types($rune_word, $item_types);
    $runes = get_rune_word_runes($rune_word, $rune_cn_names, $rune_en_names);

    $simplify_rune_words[] = [
        'name' => $name,
        'title' => $title,
        'types' => $types,
        'runes' => $runes,
        'descript' => $rune_descripts[$name],
    ];
}

for ($i = 1; $i <= 33; $i++) { 
    create_rune_panel($simplify_rune_words, $rune_cn_names, $rune_en_names, $i);
}

$rune_panel = decode_file(MY_PATH . "/global/ui/layouts/ModRecipesPanelhd.json");

for ($i = 0; $i < 33; $i++) {
    $num = $i + 1;
    $index = ceil($num / 11);
    $pi = $i % 11;
    $part = $rune_panel['children'][1]['children'][0]['children'][$index];
    $part['children'][$pi]['fields']['rect']['x'] = $pi * 150;
    $part['children'][$pi]['fields']['onClickMessage'] = "PanelManager:OpenPanel:ModRune{$num}Panel";
    $rune_panel['children'][1]['children'][0]['children'][$index] = $part;
}

encode_file(MY_PATH . "/global/ui/layouts/ModRecipesPanelhd.json", $rune_panel);