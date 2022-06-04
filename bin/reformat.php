<?php
include __DIR__ . "/basic.php";

if (empty($argv[1]) || !file_exists($argv[1])) {
    log_info("請選擇需要格式化的目錄");
    exit;
}

$dir = $argv[1];
$content = shell_exec("find {$dir} -type f | grep \".json\"");
$files = explode("\n", trim($content));

$count = 0;
foreach ($files as $file) {
    $c = file_get_contents($file);
    $c = strip_comments($c);
    $c = strip_comma($c);
    $c = remove_utf8_bom($c);
    $v = json_decode($c, true);
    if (empty($v)) {
        var_dump($c);
        log_error("can't decode '{$file}'");
        continue;
    }

    $nc = json_encode($v, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    if (file_put_contents($file, "\xEF\xBB\xBF" . $nc)) {
        $count++;
    }
}

log_info(sprintf("formatted %d/%d", $count, count($files)));
