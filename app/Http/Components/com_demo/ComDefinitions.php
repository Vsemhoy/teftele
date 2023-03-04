<?php
// make specific routes defined by Installed components
namespace App\Http\Components\com_demo;


use App\Http\Components\ComponentRouter;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;


class ComDefinitions extends BaseController
{
    public static string $com_folder = 'com_demo';
    /// used as prefix in routes
    public static string $com_name = 'demo';



    public static function getViewPath(){
        return ComponentRouter::VIEW_COM_PATH . "." . self::$com_folder ;
    }
}