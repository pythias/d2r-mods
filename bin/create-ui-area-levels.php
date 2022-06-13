<?php
include __DIR__ . "/basic.php";

class MfAreas {
    private $_path = "";
    private $_config;
    private $_table85 = [];
    private $_tableAll = [];
    public function __construct() {
        $this->_path = MY_PATH . "/global/ui/layouts/ModMFPanelhd.json";
        $this->_config = decode_file($this->_path);
        
        $row85 = $this->_config['children'][1]['children'][0]['children'][0];
        $rows85 = $row85['children'][0]['children'];
        $name85 = $rows85[0];
        $head85 = $rows85[1];

        $rootAll = $this->_config['children'][1]['children'][0]['children'][2];
        $rowsAll = $row85['children'][0]['children'];
        $nameAll = $rows85[0];
        $headAll = $rows85[1];
    }

    public function add($item) {
        $this->_byId[$item['id']] = $item;
    }

    public function save() {
        encode_file($this->_path, array_values($this->_config));
    }
}

$config = '{
    "type": "TableRowWidget",
    "name": "MRItem",
    "children": [
      {
        "type": "TextBoxWidget",
        "name": "MRName",
        "fields": {
          "text": "Act%s %s",
          "style": "$StyleModGold"
        }
      },
      {
        "type": "TextBoxWidget",
        "name": "MRNormal",
        "fields": {
          "text": "%s",
          "style": "$StyleModWhite"
        }
      },
      {
        "type": "TextBoxWidget",
        "name": "MRNightmare",
        "fields": {
          "text": "%s",
          "style": "$StyleModWhite"
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

$config85 = '{
    "type": "TableRowWidget",
    "name": "MRItem",
    "children": [
      {
        "type": "TextBoxWidget",
        "name": "MRName",
        "fields": {
          "text": "Act%s %s",
          "style": "$StyleModGold"
        }
      },
      {
        "type": "TextBoxWidget",
        "name": "MRLocation",
        "fields": {
          "text": "%s",
          "style": "$StyleModWhite"
        }
      },
      {
          "type": "FocusableWidget",
          "name": "MRTips",
          "fields": {
              "fitToParent": true,
              "tooltipString": "ÿc4%s\nÿc3位於 %s",
              "tooltipStyle": {
                  "fontStyle": {
                      "options": {
                          "newlineHandling": "standard"
                      }
                  }
              }
          }
      }
    ]
}';

$a = new MfAreas();
exit;

function get_area_names($lang = "zhTW") {
    $names = [];
    $rows = decode_file(ORIGIN_PATH . "/local/lng/strings/levels.json");
    foreach ($rows as $row) {
        $names[$row['Key']] = $row[$lang];
    }

    return $names;
}

$area_levels = parse_txt(ORIGIN_PATH . "/global/excel/levels.txt");
$names = get_area_names();
$areas = [];
$areas_85 = [];
foreach ($area_levels as $area) {
    if (empty($area['MonLvlEx'])) {
        continue;
    }

    $act = $area['Act'] + 1;
    $name = $names[$area['LevelName']] ?? $area['LevelName'];

    $areas[] = sprintf($config, 
        $act, $name, 
        $area['MonLvlEx'], $area['MonLvlEx(N)'], $area['MonLvlEx(H)'], 
        $area['MonLvlEx(H)'] >= 85 ? "\$StyleModSet" : "\$StyleModWhite"
    );

    if ($area['MonLvlEx(H)'] >= 85) {
        $areas_85[] = sprintf($config85, 
            $area['Act'] + 1, $name, $act, $name, $act,
        );
    }
}

file_put_contents(__DIR__ . "/tmp/areas.json", implode(",\n", $areas));
file_put_contents(__DIR__ . "/tmp/areas_85.json", implode(",\n", $areas_85));

