<?php
namespace App\Http\Components;

use Illuminate\Support\Facades\Route;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Components\ComponentRouter AS CR;
use App\Models\Component;


/* MANUALLY LOAD CONTROLLERS CAUSE AUTOLOAD STILL NOT WORK */
/*AUTOLOAD*/
use App\Http\Components\com_taskflow\Pub\MenuController AS CTF;
use App\Http\Components\com_demo\Pub\MenuController AS DEM;
/*AUTOLOAD_END*/

/**
 * Summary of ComponentController
 */
class ComponentController extends BaseController
{
    public $componentList;

    public string $componentsPath;
    public string $viewsPath;

    public function __construct(){
        $this->componentsPath = $_SERVER["DOCUMENT_ROOT"] . "app" . DIRECTORY_SEPARATOR . "Http" . DIRECTORY_SEPARATOR . "Components";
        $this->viewsPath = $_SERVER["DOCUMENT_ROOT"] . "resources" . DIRECTORY_SEPARATOR . "views" . DIRECTORY_SEPARATOR . "public" . DIRECTORY_SEPARATOR . "components";
        $this->componentList = $this->getPublicComponents();
        
    }

    /**
     * Summary of getPublicComponents
     * Get from db all installed components array
     * @return void
     */
    private function getPublicComponents()
    {
        $coms = [];
        $com = new Component();
        $com->id = 1;
        $com->name = "TaskFlow";
        $com->com_name = "com_taskflow";
        $com->status = 1;
        $com->public_role = 0;
        array_push($coms, $com );

        $com = new Component();
        $com->id = 2;
        $com->name = "DemoN";
        $com->com_name = "com_demo";
        $com->status = 1;
        $com->public_role = 0;
        array_push($coms, $com );

        return $coms;
    }




    /// returns source +one Item with sub-items
    public function getTopMenuItems(&$items, int $role = null)
    {
        
        foreach($this->componentList AS $component)
        {
            // check if component folder exists
            $cc = file_exists($this->componentsPath . DIRECTORY_SEPARATOR . $component->com_name);
            $cv = file_exists($this->viewsPath . DIRECTORY_SEPARATOR . $component->com_name);
            if ($cc && $cv){

                

                if (is_dir($this->componentsPath . DIRECTORY_SEPARATOR . $component->com_name)){
    
                        
                    if (file_exists($this->componentsPath . DIRECTORY_SEPARATOR . $component->com_name . DIRECTORY_SEPARATOR . CR::$com_publicFolder . DIRECTORY_SEPARATOR . CR::$com_menuName)){

                        $men = new CTF();
                        array_push($items, $men->getMainMenuItem($role));

                    }

                }

            }


        }

        return $items;
    }

    // public function getTopMenuItems(&$items, int $role = null)
    // {
    //     $folder = $_SERVER["DOCUMENT_ROOT"] . "app" . DIRECTORY_SEPARATOR . "Http" . DIRECTORY_SEPARATOR . "Components";
    //     $result = "";
    //     if ($handle = opendir($folder)) {
    
    //         while (false !== ($com_folder = readdir($handle))) {
    
    //             if ($com_folder != "." && $com_folder != "..") {
    
    //                 if (is_dir($folder . DIRECTORY_SEPARATOR . $com_folder)){
    
                        
    //                     if (file_exists($folder . DIRECTORY_SEPARATOR . $com_folder . DIRECTORY_SEPARATOR . CR::$com_publicFolder . DIRECTORY_SEPARATOR . CR::$com_menuName)){

    //                         $men = new CTF();
    //                         array_push($items, $men->getMainMenuItem($role));

    //                     }

    //                 }
    //             }
    //         }
    //         closedir($handle);
    //     }
    //     return $items;
    // }
}