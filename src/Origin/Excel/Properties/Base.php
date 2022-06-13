<?php
namespace Mod\Origin\Excel\Properties;

use Mod\File\Text;

abstract class Base {
    protected $_property;

    public function __construct($property) {
        $this->_property = $property;
    }

    abstract public function get($param, $min, $max);
}