<?php
namespace App\Http\Controllers;


use Illuminate\Support\Facades\Route;
use  App\Http\Components\ComponentController;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use App\Http\Controllers\Template\Models\TopMenuItemModel;

class PublicPageController extends BaseController
{

    public static function getAllTopMenuItems()
    {
        $array = TopMenuItemModel::$topMenuItemCollection;

        $array = ComponentController::getTopMenuItems($array);

        return $array;
    }
}