<?php
function strip_comments($text) {
    return preg_replace('![ \t]*//.*[ \t]*[\r\n]!', '', $text);
}

function remove_utf8_bom($text) {
    $bom = pack('H*','EFBBBF');
    $text = preg_replace("/^$bom/", '', $text);
    return $text;
}

function log_info($message) {
    echo date('r') . " " . $message . "\n";
}

if (empty($argv[1]) || !file_exists($argv[1])) {
    log_info("請選擇需要格式化的目錄");
    exit;
}

$dir = $argv[1];
$content = shell_exec("find {$dir} -type f | grep \".json\"");
$files = explode("\n", trim($content));

foreach ($files as $file) {
    $c = file_get_contents($file);
    $c = strip_comments($c);
    $c = remove_utf8_bom($c);
    $v = json_decode($c, true);
    if (empty($v)) {
        log_info($file);
        continue;
    }

    $nc = json_encode($v, JSON_PRETTY_PRINT);
    if (file_put_contents($file, "\xEF\xBB\xBF" . $nc)) {
        log_info("reformatted - {$file}");
    }
}
