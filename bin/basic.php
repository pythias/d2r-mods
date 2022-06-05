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
