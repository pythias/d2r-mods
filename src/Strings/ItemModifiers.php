<?php
namespace Mod\Strings;

class ItemModifiers extends Base {
    protected $_name = "item-modifiers";
    protected $_byEnUS = [];

    protected function _load() {
        $this->_byEnUS = $this->_groupBy('enUS', true);
    }

    public function getByEn($en) {
        return $this->_byEnUS[strtolower($en)] ?? null;
    }
}