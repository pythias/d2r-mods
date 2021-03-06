<?php
namespace Mod\Origin\Excel\Properties;

use Mod\Origin\Excel\CharStats;
use \Mod\Origin\Excel\MonStats;
use \Mod\Origin\Excel\Skills;
use \Mod\Origin\Excel\PlayerClass;
use \Mod\Strings\ItemModifiers;

abstract class Base {
    /**
     * @var Skills
     */
    protected static $_skills;

    /**
     * @var ItemModifiers
     */
    protected static $_itemModifiers;

    /**
     * @var MonStats
     */
    protected static $_monStats;

    /**
     * @var CharStats
     */
    protected static $_charStats;

    /**
     * @var PlayerClass
     */
    protected static $_playerClass;

    protected $_property;

    public function __construct($property) {
        $this->_property = $property;

        if (empty(self::$_skills)) {
            self::$_skills = new Skills(true);
        }

        if (empty(self::$_itemModifiers)) {
            self::$_itemModifiers = new ItemModifiers(true);
        }

        if (empty(self::$_monStats)) {
            self::$_monStats = new MonStats(true);
        }

        if (empty(self::$_charStats)) {
            self::$_charStats = new CharStats(true);
        }

        if (empty(self::$_playerClass)) {
            self::$_playerClass = new PlayerClass(true);
        }
    }

    abstract public function get($param, $min, $max): array;

    protected function _getCharClass($code) {
        $playerClass = self::$_playerClass->getByCode($code);
        $className = $playerClass[PlayerClass::KEY_CLASS] ?? "";
        return self::$_charStats->getByClass($className);
    }
}