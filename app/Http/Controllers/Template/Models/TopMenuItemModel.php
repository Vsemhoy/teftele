<?php
namespace App\Http\Controllers\Template\Models;

class TopMenuItemModel 
{
    public static $topMenuItemCollection = [];

    public string $name;
    public string $icon;
    public string $route;
    public bool $is_active;
    public $itemList = [];

    public function __construct(string $name, string $route = "", bool $is_active = false, string $icon = ""){
        $this->name = $name;
        $this->route = $route;
        $this->icon = $icon;
        $this->is_active = $is_active;
    }

    /// Only 2 incude levels
    public function addItem(string $name, $route, $icon = "", $is_active = false){
        $item = (object) array();
        $item->name = $name;
        $item->icon = $icon;
        $item->route = $route;
        $item->is_active = $is_active;
        $item->subItems = [];
        array_push($this->itemList, $item);
    }

    public function addSubItem(string $name, $route, $icon = "", bool $is_active = false, $index = null){
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
            $item->route = $route;
            $item->is_active = $is_active;
            $item->subItems = [];

            array_push($this->itemList[$i], $item);
        }
    }
}