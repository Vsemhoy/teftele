<?php
// make specific routes defined by Installed components
namespace App\Http\Components\com_taskflow;


use App\Http\Components\ComponentRouter;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;


class ComDefinitions extends BaseController
{
    public static string $com_folder = 'com_taskflow';
    /// used as prefix in routes
    public static string $com_name = 'taskflow';

    public const PAGES = ['index', 'calendar', 'boards'];

    public static function getViewPath(){
        return ComponentRouter::VIEW_COM_PATH . "." . self::$com_folder ;
    }

    public static function getReferencePath(){
        return "/" . ComponentRouter::COM_REFER . "/" . self::$com_name . "/";
    }
}