<?php
namespace Mod\Origin\Excel\Properties;

use \Mod\Origin\Excel\Monstats;
use \Mod\Origin\Excel\Skills;
use \Mod\Strings\ItemModifiers;

abstract class Base {
    /**
     * @var \Mod\Origin\Excel\Skills
     */
    protected static $_skills;

    /**
     * @var \Mod\Strings\ItemModifiers
     */
    protected static $_itemModifiers;
    /**
     * @var \Mod\Origin\Excel\Monstats
     */
    protected static $_monstats;

    protected $_property;

    public function __construct($property) {
        $this->_property = $property;

        if (empty(self::$_skills)) {
            self::$_skills = new Skills(true);
        }

        if (empty(self::$_itemModifiers)) {
            self::$_itemModifiers = new ItemModifiers(true);
        }

        if (empty(self::$_monstats)) {
            self::$_monstats = new Monstats(true);
        }
    }

    abstract public function get($param, $min, $max): array;
}