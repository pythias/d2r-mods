<?php
include __DIR__ . "/basic.php";

$dir = __DIR__ . "/../data/origin";
$content = shell_exec("find {$dir} -type f | grep -v \"\.json$\"");
$files = explode("\n", trim($content));

foreach ($files as $file) {
    shell_exec("rm -f {$file}");
}

shell_exec("find {$dir} -type d -empty -delete");
