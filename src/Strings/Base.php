<?php
namespace Mod\Strings;
use Mod\File\Json;

abstract class Base {
    protected $_path;
    protected $_name;
    private $_byId = [];

    public function __construct($origin = false) {
        if ($origin) {
            $this->_path = PATH_DATA_ORIGIN . "/local/lng/strings/{$this->_name}.json";
        } else {
            $this->_path = PATH_DATA_MY . "/local/lng/strings/{$this->_name}.json";
        }

        $items = Json::decode($this->_path);
        foreach ($items as $item) {
            $this->_byId[$item['Key']] = $item;
        }

        $this->_load();
    }

    abstract protected function _load();

    protected function _groupBy($key, $ignoreCase = false) {
        $items = [];
        foreach ($this->_byId as $id => $value) {
            $k = $ignoreCase ? strtolower($value[$key]) : $value[$key];
            $items[$k] = $value;
        }

        return $items;
    }

    public function add($item) {
        $this->_byId[$item['Key']] = $item;
    }

    public function get($key) {
        return $this->_byId[$key] ?? null;
    }

    public function save() {
        Json::encode($this->_path, array_values($this->_byId));
    }
}