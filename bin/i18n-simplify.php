<?php
include __DIR__ . "/basic.php";

if (empty($argv[1]) || !file_exists($argv[1])) {
    log_info("請選擇需要格式化的目錄");
    exit;
}

$empty_langs = [
    "deDE" => "",
    "esES" => "",
    "frFR" => "",
    "itIT" => "",
    "koKR" => "",
    "plPL" => "",
    "esMX" => "",
    "jaJP" => "",
    "ptBR" => "",
    "ruRU" => "",
];

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

    $simplified = [];
    foreach ($v as $item) {
        if (!is_i18n_conf($item)) {
            continue 2;
        }

        //$simplified[] = array_merge($item, $empty_langs);
        $simplified[] = array_diff_key($item, $empty_langs);
    }

    $nc = json_encode($simplified, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    if (file_put_contents($file, "\xEF\xBB\xBF" . $nc)) {
        log_info("reformatted - {$file}");
    }
}
