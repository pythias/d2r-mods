<?php
namespace Mod\Origin\Excel;

use Mod\Log;
use Mod\File\Text;
use Mod\Origin\Excel\Types;
use Mod\Origin\Excel\Properties;

class Runes extends Base {
    protected $_name = "runes";

    /**
     * @var $_properties \Mod\Origin\Excel\Types
     */
    private $_itemTypes = null;

    /**
     * @var $_properties \Mod\Origin\Excel\Properties
     */
    private $_properties = null;

    protected function _load() {
        $this->_itemTypes = new Types();
        $this->_properties = new Properties();
    }

    public function humanize($word) {
        return [
            'name' => $word['*Rune Name'],
            'release' => $word['*Patch Release'],
            'completed' => $word['complete'],
            'ladder' => $word['server'],
            'types' => $this->_getTypes($word),
            'runes' => $this->_getRunes($word),
            'effects' => $this->_getEffects($word),
        ];
    }

    private function _getTypes($word) {
        $types = [];
        for ($i = 1; $i <= 6; $i++) {
            if (empty($word["itype{$i}"])) {
                break;
            }
    
            $code = $word["itype{$i}"];
            $item = $this->_itemTypes->getByCode($code);
            if (empty($item)) {
                continue;
            }

            $types[$code] = $item['ItemType'];
        }

        return $types;
    }

    private function _getRunes($word) {
        $runes = [];
        for ($i = 1; $i <= 6; $i++) { 
            if (empty($word["Rune{$i}"])) {
                break;
            }

            $key = $word["Rune{$i}"];
            $num = intval(substr($key, 1));
            $runes[] = $num;
        }

        return $runes;
    }

    private function _getEffects($word) {
        $effects = [];
        for ($i = 1; $i <= 7; $i++) { 
            if (empty($word["T1Code{$i}"])) {
                break;
            }

            $code = $word["T1Code{$i}"];
            $param = $word["T1Param{$i}"];
            $min = $word["T1Min{$i}"];
            $max = $word["T1Max{$i}"];
            $property = $this->_properties->getProperty($code, $param, $min, $max);
            if (is_array($property)) {
                $effects = array_merge($effects, $property);
            } else {
                $effects[] = $property;
            }
        }

        return $effects;
    }
}