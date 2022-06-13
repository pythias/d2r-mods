<?php
namespace Mod\File;
use Mod\Log;

class Json {
    private static function _stripComments($text) {
        return preg_replace('![ \t]*//.*[ \t]*[\r\n]!', '', $text);
    }

    private static function _stripComma($text) {
        $text = preg_replace('!,[ \t\r\n]*\}!', '}', $text);
        return preg_replace('!,[ \t\r\n]*\]!', ']', $text);
    }

    private static function _removeBom($text) {
        $bom = pack('H*','EFBBBF');
        $text = preg_replace("/^$bom/", '', $text);
        return $text;
    }

    public static function decode($file) {
        $content = file_get_contents($file);
        $content = self::_removeBom($content);
        $content = self::_stripComments($content);
        $content = self::_stripComma($content);
        return json_decode($content, true);
    }

    public static function encode($file, $value) {
        $content = json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        if (file_put_contents($file, "\xEF\xBB\xBF" . $content)) {
            Log::info("saved - {$file}");
            return true;
        }

        return false;
    }

    public static function getNames($type, $lang = "zhTW") {
        $names = [];
        $rows = self::decode(ORIGIN_PATH . "/local/lng/strings/{$type}.json");
        foreach ($rows as $row) {
            $names[$row['Key']] = $row[$lang];
        }

        return $names;
    }

    public static function isI18n($items) {
        return isset($items[0]) && isset($items[0]["id"]) && isset($items[0]["zhTW"]) && isset($items[0]["Key"]);
    }
}