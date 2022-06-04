<?php
include __DIR__ . "/basic.php";

$config = '{
    "type": "TableRowWidget",
    "name": "MRItem",
    "children": [
      {
        "type": "TextBoxWidget",
        "name": "MRName",
        "fields": {
          "text": "ACT %s - %s",
          "style": "$StyleRWName"
        }
      },
      {
        "type": "TextBoxWidget",
        "name": "MRNormal",
        "fields": {
          "text": "%s",
          "style": "$StyleRWBase"
        }
      },
      {
        "type": "TextBoxWidget",
        "name": "MRNightmare",
        "fields": {
          "text": "%s",
          "style": "$StyleRWBase"
        }
      },
      {
        "type": "TextBoxWidget",
        "name": "MRHell",
        "fields": {
          "text": "%s",
          "style": "%s"
        }
      }
    ]
}';

function get_area_names($lang = "zhTW") {
    $names = [];
    $rows = decode_file(ORIGIN_PATH . "/local/lng/strings/levels.json");
    foreach ($rows as $row) {
        $names[$row['Key']] = $row[$lang];
    }

    return $names;
}

$area_levels = parse_txt(ORIGIN_PATH . "global/excel/levels.txt");
$names = get_area_names();
$areas = [];
$areas_85 = [];
foreach ($area_levels as $area) {
    $areas[] = sprintf($config, 
        $area['Act'] + 1, $names[$area['LevelName']] ?? $area['LevelName'], 
        $area['MonLvlEx'], $area['MonLvlEx(N)'], $area['MonLvlEx(H)'], 
        $area['MonLvlEx(H)'] >= 85 ? "\$StyleRWRune" : "\$StyleRWBase"
    );

    if ($area['MonLvlEx(H)'] >= 85) {
        var_dump(json_encode($area, JSON_PRETTY_PRINT));
        $areas_85[] = sprintf($config, 
            $area['Act'] + 1, $names[$area['LevelName']] ?? $area['LevelName'], 
            "", "", "", "\$StyleRWBase"
        );
    }
}

file_put_contents(__DIR__ . "/tmp/areas.json", implode(",\n", $areas));
file_put_contents(__DIR__ . "/tmp/areas_85.json", implode(",\n", $areas_85));

