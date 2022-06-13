<?php
namespace Mod\Origin\Excel;

use Mod\Log;
use Mod\Strings\ItemModifiers;

class Properties extends Base {
    protected $_name = "properties";
    private $_byCode = [];
    private $_itemModifiers;

    private $_customKeys = [
        'dmg-to-mana' => 'ModStr3w',
        'dmg-ac' => 'ModStr4d',
        'crush' => 'ModStr5c',
        'abs-mag' => 'ModStr5k',
        'openwounds' => 'ModStr3m',
        'deadly' => 'ModStr5q',
        'freeze' => 'ModStr3l',
        'rep-dur' => 'ModStre9u',
        'ethereal' => 'strethereal',
        'pierce' => 'ModStr6g',
        'abs-mag' => 'ModStr5k',
        'abs-fire' => 'ModStr5g',
        'stupidity' => 'ModStr6d',
    ];

    protected function _load() {
        $this->_byCode = $this->_groupBy('code');
        $this->_itemModifiers = new ItemModifiers(true);
    }

    public function getByCode($code) {
        return $this->_byCode[$code] ?? null;
    }

    private function _tipsToKey($tips) {
        $tips = strtolower($tips);
        $tips = str_replace('-#%', '-%d%%', $tips);
        $tips = str_replace('+#%', '%+d%%', $tips); //注意和-的不太一样
        $tips = str_replace('#%', '%d%%', $tips);
        $tips = str_replace('#/#', '', $tips);
        $tips = str_replace('+#', '%+d', $tips);
        $tips = str_replace('#-#', '%d-%d', $tips);
        $tips = str_replace('-#', '%d', $tips); //-# to Monster Defense Per Hit 特例
        $tips = str_replace('#', '%d', $tips);
        
        $tips = str_replace('[skill]', '%s', $tips);
        return $tips;
    }

    public function getProperty($code, $param, $min, $max, $lng = "zhTW") {
        $property = $this->getByCode($code);
        if (empty($property)) {
            return null;
        }
        
        $type = $property["*Parameter"];
        switch ($type) {
            case "monstats.txt hcIdx":
                break;
            case "Skill":
                break;
            case "Class Skill Tab ID":
                break;
            case "Length (Frames)":
                break;
            case "ac/lvl (8ths)":
                break;
            case "#/8 per Level":
                break;
            case "#/2 per Level":
                break;
            case "Repair Speed":
                break;
            case "Time Period for Max value":
                break;
            case "monstats.txt MonType":
                break;
            case "Skill Level":
                break;
            case "State":
                break;
            default:
                break;
        }

        $tips = $property['*Tooltip'];
        if (isset($this->_customKeys[$code])) {
            // dmg-elem 各种元素伤害
            $modifier = $this->_itemModifiers->get($this->_customKeys[$code]);
        } else {
            $tips = $this->_tipsToKey($tips);
            $modifier = $this->_itemModifiers->getByEn($tips);
        }

        if (empty($modifier)) {
            Log::error("unknown modifier: {$property['*Tooltip']}");
        }

        $name = $modifier[$lng] ?? $tips;
        $key = $modifier['Key'] ?? $tips;
        $name = str_replace('%s', $param, $name);
        $title = sprintf($name, $min, $max);

        return [
            'tip' => $property['*Tooltip'],
            'key' => $key,
            'title' => $title,
        ];
    }

    private function _normal($property, $params, $min, $max) {
        
    }

    private function _monsterIdx() {
        
    }
}