<?php
namespace App\Http\Controllers;


use Illuminate\Support\Facades\Route;
use  App\Http\Components\ComponentController;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use App\Http\Controllers\Template\Models\TopMenuItemModel;
use App\Models\MenuItem;

class PublicPageController extends BaseController
{
    public ComponentController $components;
    public $menuItemList;

    public function __construct(){
        $this->components = new ComponentController();
        $this->menuItemList = $this->getTopMenuItems();
    }


    private function getTopMenuItems()
    {
        $ord = 0;
        $coms = [];
        $item = new MenuItem();
        $item->id = 1;
        $item->name = "TaskFlow";
        $item->route = "taskflow";
        $item->level = 0;
        $item->part_id = 1;
        $item->parent = 0;
        $item->role = 0;
        $item->icon = "";
        $item->status = 1;
        $item->orderer = $ord;
        array_push($coms, $item );
        $ord++;
        
        $item = new MenuItem();
        $item->id = 2;
        $item->name = "Index";
        $item->route = "taskflow.index";
        $item->level = 1;
        $item->parent = 1;
        $item->part_id = 1;
        $item->role = 0;
        $item->icon = "";
        $item->status = 1;
        $item->orderer = $ord;
        array_push($coms, $item );
        $ord++;
        
        $item = new MenuItem();
        $item->id = 3;
        $item->name = "TaskFlow";
        $item->route = "taskflow.calendar";
        $item->level = 1;
        $item->role = 0;
        $item->parent = 1;
        $item->part_id = 1;
        $item->icon = "";
        $item->status = 1;
        $item->orderer = $ord;
        array_push($coms, $item );
        $ord++;
        
        $item = new MenuItem();
        $item->id = 4;
        $item->name = "Boards";
        $item->route = "taskflow.boards";
        $item->level = 1;
        $item->parent = 1;
        $item->role = 0;
        $item->part_id = 1;
        $item->icon = "";
        $item->status = 1;
        $item->orderer = $ord;
        array_push($coms, $item );
        $ord++;

        $item = new MenuItem();
        $item->id = 7;
        $item->name = "Board";
        $item->route = "taskflow.board";
        $item->level = 1;
        $item->parent = 1;
        $item->role = 0;
        $item->part_id = 1;
        $item->icon = "";
        $item->status = 1;
        $item->orderer = $ord;
        array_push($coms, $item );
        $ord++;

        $item = new MenuItem();
        $item->id = 8;
        $item->name = "Settings";
        $item->route = "taskflow.settings";
        $item->level = 1;
        $item->parent = 1;
        $item->role = 0;
        $item->part_id = 1;
        $item->icon = "";
        $item->status = 1;
        $item->orderer = $ord;
        array_push($coms, $item );
        $ord++;
        
        $item = new MenuItem();
        $item->id = 5;
        $item->name = "DEMO";
        $item->route = "demo";
        $item->level = 0;
        $item->parent = 0;
        $item->role = 0;
        $item->part_id = 1;
        $item->icon = "";
        $item->status = 1;
        $item->orderer = $ord;
        array_push($coms, $item );
        $ord++;

        $item = new MenuItem();
        $item->id = 6;
        $item->name = "TEST";
        $item->route = "demo.test";
        $item->level = 1;
        $item->parent = 2;
        $item->role = 0;
        $item->part_id = 1;
        $item->icon = "";
        $item->status = 1;
        $item->orderer = $ord;
        array_push($coms, $item );
        $ord++;

        return $coms;
        // need to check all if component enabled
    }


    public function getAllTopMenuItems()
    {
        $topItems = TopMenuItemModel::$topMenuItemCollection;
        $menu = null;
        $c = 0;
        foreach ($this->menuItemList AS $item)
        {
            if ($item->route == Route::currentRouteName()){
                $item->is_active = true;
            } else {
                $item->is_active = false;
            }
            if ($c != 0 && $item->level == 0){
                array_push($topItems, $menu);
            }
            if ($item->level == 0){
                $menu = new TopMenuItemModel($item->name, $item->route, $item->is_active, $item->icon);
            } else if ($item->level == 1){
                $menu->addItem($item->name, $item->route, $item->is_active, $item->icon)  ;
            }
     
            $c++;
        }
        if ($c != 0){array_push($topItems, $menu); }

        return $topItems;
    }
}