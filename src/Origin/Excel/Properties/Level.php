<?php

namespace Mod\Origin\Excel\Properties;

use Mod\Origin\Excel\Properties;

class Level extends Base {
    protected $_divide = 8;

    public function get($param, $min, $max) : array {
        $tmp = explode(' (', $this->_property["*Tooltip"]);
        $key = Properties::tipsToKey($tmp[0]);
        $modifier = self::$_itemModifiers->getByEn($key);
        if (empty($modifier)) {
            $modifier = self::$_itemModifiers->getByEn(str_replace("%d%%", "%+d%%", $key));
        }
        
        $name = $modifier["zhTW"] ?? $key;
        if ($min == 0) {
            $range = sprintf("+[%0.3f-%0.3f]", 1 * $param / $this->_divide, 99 * $param / $this->_divide);
            $name = str_replace("%+d", $range, $name);
            return [sprintf("%s @ModStre9c [%0.3f * clvl]", $name, $param / $this->_divide)];
        } else {
            $range = sprintf("+[%0.3f-%0.3f]", 1 * $min / $this->_divide, 99 * $max / $this->_divide);
            $name = str_replace("%+d", $range, $name);
            return [sprintf("%s @ModStre9c", $name)];
        }
    }
}