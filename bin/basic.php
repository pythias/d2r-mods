<?php
function get_exec_lines($cmd) {
    $content = shell_exec($cmd);
    return explode("\n", trim($content));
}

function strip_comments($text) {
    return preg_replace('![ \t]*//.*[ \t]*[\r\n]!', '', $text);
}

function strip_comma($text) {
    $text = preg_replace('!,[ \t\r\n]*\}!', '}', $text);
    return preg_replace('!,[ \t\r\n]*\]!', ']', $text);
}

function remove_utf8_bom($text) {
    $bom = pack('H*','EFBBBF');
    $text = preg_replace("/^$bom/", '', $text);
    return $text;
}

function decode_file($file) {
    $content = file_get_contents($file);
    $content = strip_comments($content);
    $content = remove_utf8_bom($content);
    return json_decode($content, true);
}

function encode_file($file, $value) {
    $content = json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    if (file_put_contents($file, "\xEF\xBB\xBF" . $content)) {
        log_info("saved - {$file}");
        return true;
    }

    return false;
}

function parse_txt($file) {
    $rows = [];
    $content = file_get_contents($file);
    $lines = explode("\n", trim($content));
    $header = array_shift($lines);
    $columns = explode("\t", trim($header));
    foreach ($lines as $line) {
        $values = explode("\t", trim($line));
        if (count($columns) != count($values)) {
            log_error("line invalid, content:{$line}");
            continue;
        }
        
        $rows[] = array_combine($columns, $values);
    }

    return $rows;
}

function get_names($type, $lang = "zhTW") {
    $names = [];
    $rows = decode_file(ORIGIN_PATH . "/local/lng/strings/{$type}.json");
    foreach ($rows as $row) {
        $names[$row['Key']] = $row[$lang];
    }

    return $names;
}

function is_i18n_conf($conf) {
    return isset($conf["zhCN"]) && isset($conf["zhTW"]);
}

function log_info($message) {
    echo "\033[01;32m[INFO]\033[0m" . date('H:i:s') . " {$message}\n";
}

function log_error($message) {
    echo "\033[01;31m[ERROR]\033[0m" . date('H:i:s') . " {$message}\n";
}

define("ORIGIN_PATH", __DIR__ . "/../data/origin");
define("MY_PATH", __DIR__ . "/../data/my");
define("SETTINGS_PATH", __DIR__ . "/../data/settings");

class ItemNames {
    private $_byId = [];
    public function __construct() {
        $items = decode_file(MY_PATH . "/local/lng/strings/item-names.json");
        foreach ($items as $item) {
            $this->_byId[$item['id']] = $item;
        }
    }

    public function add($item) {
        $this->_byId[$item['id']] = $item;
    }

    public function save() {
        encode_file(MY_PATH . "/local/lng/strings/item-names.json", array_values($this->_byId));
    }
}

class Table {
    private $_name = "Default Table";
    private $_type = "TableWidget";
    private $_width = 1700;
    private $_height = 100;
    private $_fields = [
        "columns" => [],
        "rowHeight" => "\$ModTableRowHeightSmall"
    ];
    private $_rows = [];

    public function addColumn($width, $ah = 'fit', $av = 'fix') {
        $this->_fields['columns'] = [
            'width' => intval($width),
            'alignment' => [
                'h' => $ah,
                'v' => $av
            ],
        ];
    }

    public function setRowHeight($height) {
        $this->_fields["rowHeight"] = $height;
    }

    public function setTitleRow($title) {
        $this->_fields["rowHeight"] = $height;
    }

    public function gen() {
        return [
            'name' => $this->_name,
            'type' => $this->_type,
            'fields' => [
                'rect' => [
                    'width' => $this->_width,
                    'height' => $this->_height,
                ]
            ],
            'children' => [
                
            ],
        ];
    }
}

class TableRow {
    private $_name = "Default Table";
    private $_type = "TableRowWidget";
    private $_width = 1700;
    private $_height = 100;
    private $_chilrens = [];

    public function gen() {
        return [
            'name' => $this->_name,
            'type' => $this->_type,
            'fields' => [
                'rect' => [
                    'width' => $this->_width,
                    'height' => $this->_height,
                ]
            ],
            'children' => [
                
            ],
        ];
    }
}

class TablePanel {
    private $_path = "";
    private $_config;
    private $_tables = [];
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