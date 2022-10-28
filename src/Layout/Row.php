<?php

namespace Mod\Layout;

class Row {
    const TYPE = 'TableRowWidget';

    private $_name;
    private $_values = [];

    public function addValue($value) {
        $this->_values[] = $value;
    }
}