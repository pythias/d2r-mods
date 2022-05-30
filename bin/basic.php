<?php
function get_exec_lines($cmd) {
    $content = shell_exec($cmd);
    return explode("\n", trim($content));
}

function strip_comments($text) {
    return preg_replace('![ \t]*//.*[ \t]*[\r\n]!', '', $text);
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

function log_info($message) {
    echo date('r') . " " . $message . "\n";
}

