<?php
namespace App\Http\Components\com_taskflow\Pub;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Components\com_taskflow\DataBaseController AS DBC;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Http\Components\com_taskflow\ComDefinitions;
use App\Models\Component;
use Illuminate\Support\Facades\DB;

use Joomla\Filter\InputFilter;


/**
 * Summary of ComponentController
 */
class MainController{


    public function __construct(){

    }

    public function getCalendarPage(Request $request){

        DBC::test();
        return view(ComDefinitions::getViewPath()  . '.calendar');
    }

}