<?php
// make specific routes defined by Installed components
namespace App\Http\Components;


use Illuminate\Support\Facades\Route;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;


class ComponentRouter extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    public static string $com_routerName = "ComRouter.php";
    public static string $com_menuName = "MenuController.php";
    public static string $com_publicFolder = "Pub";
    public static string $com_adminFolder = "Admin";

    public const VIEW_COM_PATH = "public.components";

    public static function getComponentRoutes()
    {

        // set user public routes for components

        Route::prefix('com')->group(function(){



            $folder = $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "app" . DIRECTORY_SEPARATOR . "Http" . DIRECTORY_SEPARATOR . "Components";
            $result = "";
            if ($handle = opendir($folder)) {
        
                while (false !== ($com_folder = readdir($handle))) {
        
                    if ($com_folder != "." && $com_folder != "..") {
        
                        if (is_dir($folder . DIRECTORY_SEPARATOR . $com_folder)){
        
                            if (file_exists($folder . DIRECTORY_SEPARATOR . $com_folder . DIRECTORY_SEPARATOR . self::$com_publicFolder . DIRECTORY_SEPARATOR . self::$com_routerName)){
                                // Component routes defines in [com_Folder -> ComRouter.php]
                                include $folder . DIRECTORY_SEPARATOR . $com_folder . DIRECTORY_SEPARATOR  . self::$com_publicFolder . DIRECTORY_SEPARATOR . self::$com_routerName;
                            }
                            // if (file_exists($folder . DIRECTORY_SEPARATOR . $com_folder . DIRECTORY_SEPARATOR . self::$com_publicFolder . DIRECTORY_SEPARATOR . self::$com_menuName)){
                            //     // Component routes defines in [com_Folder -> ComRouter.php]
                            //     include $folder . DIRECTORY_SEPARATOR . $com_folder . DIRECTORY_SEPARATOR  . self::$com_publicFolder . DIRECTORY_SEPARATOR . self::$com_menuName;
                            //     $men = new MenuController();
                            //     $men->build();
                            // }
                        }
                    }
                }
                closedir($handle);
            }


        }); // end of group
    }
}

//echo "$result\n</br>";
