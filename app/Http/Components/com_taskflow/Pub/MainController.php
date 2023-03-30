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
use Illuminate\Support\Facades\Auth;

use Joomla\Filter\InputFilter;


/**
 * Summary of ComponentController
 */
class MainController{
    public $board_list;
    public $project_list;
    public $group_list;
    public $type_list;
    public $board;
    public $date_start;
    public $date_end;

    public $user;

    private int $get_board;
    private int $get_start;
    private int $get_end;

    public function __construct(Request $request){

    }

    private function objectConstruct()
    {
        $this->user = null;
        if (Auth::check()){
            $this->user = Auth::user();
        }
        $this->board_list = DBC::getAllUserBoards($this->user);
        $this->board = DBC::getBoard($this->user, $this->get_board);
        $this->project_list = DBC::getAllUserCategories($this->user);
        $this->group_list = DBC::getAllUserGroups($this->user);
        $this->type_list = DBC::getAllUserTypes($this->user);
    }

    
    public function getCalendarPageDefault(Request $request){
        $this->get_board = 0;
        return $this->getCalendarPage($request, 0);
    }

    public function getCalendarPage(Request $request, $board){
        $this->get_board = $board;
        $this->objectConstruct();
        
        $objectResult = (object) array();
        $objectResult->board_list = $this->board_list;
        $objectResult->group_list = $this->group_list;
        $objectResult->type_list = $this->type_list;
        $objectResult->project_list = $this->project_list;
        $objectResult->board = $this->board;
        $objectResult->user = $this->user;

        return view(ComDefinitions::getViewPath()  . '.calendar')->with('data', $objectResult);
    }

    public function getBoardsManager() {
        // local-construct
        $this->user = null;
        if (Auth::check()){
            $this->user = Auth::user();
        }
        $this->board_list = DBC::getAllUserBoards($this->user);
        // local construct end
        $objectResult = (object) array();
        $objectResult->board_list = $this->board_list;
        $objectResult->user = $this->user;
        $objectResult->route = ComDefinitions::getReferencePath();
        return view(ComDefinitions::getViewPath()  . '.boards')->with('data', $objectResult);
    }

}