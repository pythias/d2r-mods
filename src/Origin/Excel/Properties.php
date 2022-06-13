<?php
namespace Mod\Origin\Excel;

use Mod\Log;
use Mod\Strings\ItemModifiers;

class Properties extends Base {
    protected $_name = "properties";
    private $_byCode = [];

    /**
     * @var $_itemModifiers \Mod\Strings\ItemModifiers
     */
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
        'abs-fire' => 'ModStr5g',
        'stupidity' => 'ModStr6d',
    ];

    private $_customPropertyProcessors = [
        "monstats.txt hcIdx" => "",
        "Class Skill Tab ID" => "",
        "Length (Frames)" => "",
        "ac/lvl (8ths)" => "LevelT",
        "#/8 per Level" => "Level8",
        "#/2 per Level" => "Level2",
        "Repair Speed" => "",
        "Time Period for Max value" => "",
        "monstats.txt MonType" => "",
        "Skill Level" => "",
        "State" => "",
        "charged" => "Charged",
        "skill" => "Skill",
        "skilltab" => "SkillTab",
        "dmg-elem" => "ElementDamages",
        "reanimate" => "Returned",
        "dmg-pois" => "PoisonDamage",
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

        return str_replace('[skill]', '%s', $tips);
    }

    /**
     * @param $code
     * @param $property
     * @return false|\Mod\Origin\Excel\Properties\Base
     */
    private function _getProcessor($code, $property) {
        $param = $property["*Parameter"];
        if (!empty($this->_customPropertyProcessors[$param])) {
            $typeClass = $this->_customPropertyProcessors[$param];
        } else if (!empty($this->_customPropertyProcessors[$code])) {
            $typeClass = $this->_customPropertyProcessors[$code];
        } else {
            return false;
        }

        $className = "\\Mod\\Origin\\Excel\\Properties\\" . $typeClass;
        return new $className($property);
    }

    public function getProperty($code, $param, $min, $max, $lng = "zhTW") {
        $property = $this->getByCode($code);
        if (empty($property)) {
            return null;
        }

        $processor = $this->_getProcessor($code, $property);
        if ($processor !== false) {
            return [
                'tip' => $property['*Tooltip'],
                'key' => $code,
                'title' => $processor->get($param, $min, $max),
            ];
        }

        $tips = $property['*Tooltip'];
        if (isset($this->_customKeys[$code])) {
            $modifier = $this->_itemModifiers->get($this->_customKeys[$code]);
        } else {
            $tips = $this->_tipsToKey($tips);
            $modifier = $this->_itemModifiers->getByEn($tips);
        }

        if (empty($modifier)) {
            Log::error("unknown modifier, code:{$code}, tips: {$property['*Tooltip']}");
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