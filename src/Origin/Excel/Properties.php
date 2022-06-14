<?php
namespace Mod\Origin\Excel;

use Mod\Log;
use Mod\Strings\ItemModifiers;

class Properties extends Base {
    protected $_name = "properties";
    private $_byCode = [];

    /**
     * @var \Mod\Strings\ItemModifiers
     */
    private static $_itemModifiers;

    /**
     * @var \Mod\Origin\Excel\Skills
     */
    private static $_skills;

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
        "Repair Speed" => "Repair",
    ];

    protected function _load() {
        $this->_byCode = $this->_groupBy('code');

        if (empty(self::$_itemModifiers)) {
            self::$_itemModifiers = new ItemModifiers(true);
        }

        if (empty(self::$_skills)) {
            self::$_skills = new Skills(true);
        }
    }

    public function getByCode($code) {
        return $this->_byCode[$code] ?? null;
    }

    public static function tipsToKey($tips) {
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
        
        Log::error("... $code, $param, $min, $max" . json_encode($property, JSON_UNESCAPED_UNICODE));

        $processor = $this->_getProcessor($code, $property);
        if ($processor !== false) {
            return $processor->get($param, $min, $max);
        }

        $tips = $property['*Tooltip'];
        if (isset($this->_customKeys[$code])) {
            $modifier = self::$_itemModifiers->get($this->_customKeys[$code]);
        } else {
            $tips = self::tipsToKey($tips);
            $modifier = self::$_itemModifiers->getByEn($tips);
        }

        if (empty($modifier)) {
            Log::error("unknown modifier, code:{$code}, tips: {$property['*Tooltip']}");
        }

        $name = $modifier[$lng] ?? $tips;
        $key = $modifier['Key'] ?? $tips;

        if (strpos($name, '%s')) {
            // 此處為技能，需要特別處理，太複雜，有點亂了
            $param = "@" . self::$_skills->getStrBy($param) . " ";
        }
        $name = str_replace('%s', $param, $name);
        
        return sprintf($name, $min, $max);
    }
}