<?php
namespace Mod\Origin\Excel;

use Mod\File\Text;

abstract class Base {
    protected $_name = "levels";
    protected $_values;

    public function __construct() {
        $this->_values = Text::parse(PATH_DATA_ORIGIN . "/global/excel/{$this->_name}.txt");

        $this->_load();
    }

    abstract protected function _load();

    public function getValues() {
        return $this->_values;
    }

    protected function _groupBy($key) {
        $items = [];
        foreach ($this->_values as $value) {
            $items[$value[$key]] = $value;
        }

        return $items;
    }
}