<?php
namespace Mod\File;

use Mod\Log;

class Text {
    public static function parse($file) {
        $rows = [];
        $content = file_get_contents($file);
        $lines = explode("\n", trim($content));
        $header = array_shift($lines);
        $columns = explode("\t", trim($header));
        foreach ($lines as $line) {
            $values = explode("\t", trim($line));
            if (count($columns) != count($values)) {
                Log::error("line invalid, content:{$line}");
                continue;
            }
            
            $rows[] = array_combine($columns, $values);
        }

        return $rows;
    }
}