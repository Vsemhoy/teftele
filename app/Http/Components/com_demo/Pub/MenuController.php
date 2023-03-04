<?php
namespace App\Http\Components\com_taskflow\Pub;
use Illuminate\Support\Facades\Route;
use App\Http\Components\com_taskflow\ComDefinitions;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;


use App\Http\Controllers\Template\Models\TopMenuItemModel;

/**
 * Summary of MenuController
 */
class MenuController{

    public function build(){
        echo "HER";
    }

    /**
     * Summary of getMainMenuItem
     * @param mixed $role
     * @return void
     */
    public function getMainMenuItem($role = null){
        $menu = new TopMenuItemModel("DemoCom");
        
        $menu->addItem('Main page', ComDefinitions::$com_name . '.index');
        $menu->addItem('Calendar', ComDefinitions::$com_name . '.calendar');
        $menu->addItem('Board', ComDefinitions::$com_name . '.boards');
        return $menu;
    }
}

