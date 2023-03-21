<?php
namespace App\Http\Components\com_taskflow;

use Illuminate\Support\Facades\Route;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Models\Component;
use Illuminate\Support\Facades\DB;
use App\Vendor\Joomla\Filter\InputFilter;
use App\Http\Components\com_taskflow\ComDefinitions;


/**
 * Summary of ComponentController
 */
class DataBaseController
{

    public function __construct(){

    }

    const TB_PREFIX = "com_taskflow_";
    const TB_BOARDS = self::TB_PREFIX . "boards";
    const TB_GROUPS = self::TB_PREFIX . "groups";
    const TB_PROJECTS = self::TB_PREFIX . "projects";
    const TB_TYPES = self::TB_PREFIX . "types";
    const TB_AGENTS = self::TB_PREFIX . "agents";
    const TB_TASKS = self::TB_PREFIX . "tasks";
    const TB_SOLUTIONS = self::TB_PREFIX . "solutions";


    public static function test(){

        $val = "jkfsajkdjfj dfasdklfj34j53k 534jk";
        $filter = new InputFilter();
        $val = $filter->clean($val, "int");

        return $val;
    }


    public static function getAllUserBoards($user)
    {
        $boards = DB::table(self::TB_BOARDS)->where('user', $user->id)->orderBy('ordered')->get();
        return $boards;
    }
    public static function getBoard($user, $board_id = 0)
    {
        $board = null;
        if ($board_id == 0){
            $board = DB::table(self::TB_BOARDS)->where('user', $user->id)->orderBy('ordered')->first();
        } else {
            $board = DB::table(self::TB_BOARDS)->where('user', $user->id)->where('id', $board_id)->orderBy('ordered')->first();
        }
        return $board;
    }

    public static function getAllUserCategories($user)
    {
        $boards = DB::table(self::TB_PROJECTS)->where('user', $user->id)->orderBy('ordered')->get();
        return $boards;
    }

    public static function getAllUserGroups($user)
    {
        $boards = DB::table(self::TB_GROUPS)->where('user', $user->id)->orderBy('ordered')->get();
        return $boards;
    }

    public static function getAllUserTypes($user)
    {
        $boards = DB::table(self::TB_TYPES)->where('user', $user->id)->orderBy('ordered')->get();
        return $boards;
    }



    public static function createNewTask($object, $user)
    {
        $fil = new InputFilter();
        $val = $fil->clean($object, "int");


        $data = array(
            'name'              => $fil->clean($object->name, 'string'),
            'description'       => $fil->clean($object->description, 'string'),
            'result'            => $fil->clean($object->result, 'string'),
            'status'            => $fil->clean($object->status, 'string'),
            'board'             => $fil->clean($object->board, 'int'),
            'type'              => $fil->clean($object->type, 'int'),
            'group'             => $fil->clean($object->group, 'int'),
            'project'           => $fil->clean($object->project, 'int'),
            'tags'              => $fil->clean($object->tags, 'int'),
            'planned_time'      => $fil->clean($object->planned_time, 'int'),
            'setter'            => $fil->clean($object->setter, 'int'),    
            'executor'          => $fil->clean($object->executor, 'int'),
            'schedule'          => stripcslashes($object->schedule),
            'steps'             => stripcslashes($object->steps),
            'solutions'         => stripcslashes($object->solutions),
            'checklist'         => stripcslashes($object->checklist),
            'total_duration'    => $fil->clean($object->total_duration, 'int'),
            'checks_total'      => $fil->clean($object->checks_total, 'int'),
            'checks_checked'    => $fil->clean($object->checks_checked, 'int'),
            'checks_percent'    => $fil->clean($object->checks_percent, 'int'),
            'visual_state'      => $fil->clean($object->visual_state, 'int'),
            'date_set'          => $fil->clean($object->date_set, 'int'),
            'date_start_real'   => $fil->clean($object->date_start_real, 'int'),
            'date_finish_real'  => $fil->clean($object->date_finish_real, 'int'),
            'date_start_plan'   => $fil->clean($object->date_start_plan, 'int'),
            'date_finish_plan'  => $fil->clean($object->date_finish_plan, 'int'),
            'duration'          => $fil->clean($object->duration, 'int')
        );
        $id = DB::table(self::TB_TASKS)->insertGetId($data);
        $object->id = $id;
        return $object;
    }

    public static function updateCalendarTask($object, $user)
    {
        $fil = new InputFilter();
        $val = $fil->clean($object, "int");

        $data = array(

        );
        $id = DB::table(self::TB_TASKS)->insertGetId($data);
        $object->id = $id;
        return $object;
    }
    

}

?>