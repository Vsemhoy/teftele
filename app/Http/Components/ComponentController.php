<?php
namespace App\Http\Components;

use Illuminate\Support\Facades\Route;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Components\ComponentRouter AS CR;


/* MANUALLY LOAD CONTROLLERS CAUSE AUTOLOAD STILL NOT WORK */
/*AUTOLOAD*/
use App\Http\Components\com_taskflow\Pub\MenuController AS CTF;
/*AUTOLOAD_END*/

class ComponentController extends BaseController
{


    /// returns source +one Item with sub-items
    public static function getTopMenuItems(&$items, int $role = null)
    {
        $folder = $_SERVER["DOCUMENT_ROOT"] . "app" . DIRECTORY_SEPARATOR . "Http" . DIRECTORY_SEPARATOR . "Components";
        $result = "";
        if ($handle = opendir($folder)) {
    
            while (false !== ($com_folder = readdir($handle))) {
    
                if ($com_folder != "." && $com_folder != "..") {
    
                    if (is_dir($folder . DIRECTORY_SEPARATOR . $com_folder)){
    
                        
                        if (file_exists($folder . DIRECTORY_SEPARATOR . $com_folder . DIRECTORY_SEPARATOR . CR::$com_publicFolder . DIRECTORY_SEPARATOR . CR::$com_menuName)){

                            $men = new CTF();
                            array_push($items, $men->getMainMenuItem($role));

                        }

                    }
                }
            }
            closedir($handle);
        }
        return $items;
    }
}