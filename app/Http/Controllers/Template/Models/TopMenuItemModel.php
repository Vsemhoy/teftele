<?php
namespace App\Http\Controllers\Template\Models;

class TopMenuItemModel 
{
    public static $topMenuItemCollection = [];

    public string $name;
    public string $icon;
    public string $route;
    public bool $is_active;
    public string $class;
    public $itemList = [];

    public function __construct(string $name, string $route = "", bool $is_active = false, string $icon = "", string $class = ""){
        $this->name = $name;
        $this->route = $route;
        $this->icon = $icon;
        $this->is_active = $is_active;
        $this->class = $class;
    }

    /// Only 2 incude levels
    public function addItem(string $name, $route, $is_active = false, $icon = "", $class = ""){
        $item = (object) array();
        $item->name = $name;
        $item->icon = $icon;
        $item->class = $class;
        $item->route = $route;
        $item->is_active = $is_active;
        $item->subItems = [];
        array_push($this->itemList, $item);
    }

    public function addSubItem(string $name, $route, bool $is_active = false, $icon = "", $index = null, $class = ""){
        if (count($this->itemList) > 0){
            $i = 0;
            if ($index == null && !is_numeric($index) && $index < count($this->itemList) && $index > -1){
                $i = count($this->itemList) - 1;
            } else {
                $i = $index;
            };
            $item = (object) array();
            $item->name = $name;
            $item->icon = $icon;
            $item->class = $class;
            $item->route = $route;
            $item->is_active = $is_active;
            $item->subItems = [];

            array_push($this->itemList[$i], $item);
        }
    }
}