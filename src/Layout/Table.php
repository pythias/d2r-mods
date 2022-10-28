<?php
namespace Mod\Layout;

class Table {
    private $_rect;
    private $_name;
    private $_type;
    private $_rowHeight;
    private $_cellPadding;
    private $_rows = [];
    private $_columns = [];

    public function addColumn($column) {
        $this->_columns[] = $column;
    }

    public function addRow($row) {
        $this->_rows[] = $row;
    }
}