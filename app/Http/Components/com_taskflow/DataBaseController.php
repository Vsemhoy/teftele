<?php
namespace App\Http\Components\com_taskflow;

use Illuminate\Support\Facades\Route;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Models\Component;
use Illuminate\Support\Facades\DB;
use App\Vendor\Joomla\Filter\src\InputFilter;
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

    private static function normalizeDate($date){
        $mytime = strtotime($date);
        $newDate = date('Y-m-d', $mytime);
        return $newDate;
    }

    public static function test(){

        $val = "jkfsajkdjfj dfasdklfj34j53k 534jk";
        $filter = new InputFilter();
        $val = $filter->clean($val, "int");

        return $val;
    }


    public static function loadCalendarTasks($object, $user)
    {
        $fil = new InputFilter();
        $startDate = self::normalizeDate($object->startdate);
        $finDate = self::normalizeDate($object->findate);
        $boards = [];
        if (is_array($object->boards))
        {
            foreach ($object->boards AS $brd)
            {
                array_push($boards, $fil->clean($brd, 'int'));
            }
        } else {
            array_push($boards, $fil->clean($object->boards, 'int'));
        }
        $boards = DB::table(self::TB_TASKS)->where('user', $user->id)->whereDate('date_set', '>=', $startDate)->whereDate('date_set', '<=', $finDate)->whereIn('board_id',  $boards )->get();
        $object->boards = $boards;
        return $object;
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
        $schedule  = $object->schedule;
        $steps     = $object->steps;
        $solutions = $object->solutions;
        $checklist = $object->checklist;
        if (is_array($schedule)){ $schedule = json_encode($schedule);} else {$schedule = "[]";};
        //if (is_array($steps)){ $steps = json_encode($steps);} else {$steps = "[]";};
        if (is_array($solutions)){ $solutions = json_encode($solutions);} else {$solutions = "[]";};
        if (is_array($checklist)){ $checklist = json_encode($checklist);} else {$checklist = "[]";};

        $newDate = self::normalizeDate($object->date_set);
        $dsr = null;
        $dfr = null;
        if ($object->date_start_real != null){
            $dsr = self::normalizeDate($object->date_start_real);
        }
        if ($object->date_finish_real != null){
            $dsr = self::normalizeDate($object->date_start_real);
        }

        $data = array(
            'user'              => $user->id,
            'name'              => $fil->clean($object->name, 'string', 200),
            'description'       => $fil->clean($object->description, 'string', 990),
            'result'            => $fil->clean($object->result, 'string', 990),
            'status'            => $fil->clean($object->status, 'int'),
            'board_id'          => $fil->clean($object->board, 'int'),
            'type_id'           => $fil->clean($object->type, 'int'),
            'group_id'          => $fil->clean($object->group, 'int'),
            'project_id'        => $fil->clean($object->project, 'int'),
            'tags'              => $fil->clean($object->tags, 'string', 190),
            'duration_planned'  => $fil->clean($object->duration_planned, 'int'),
            'duration_real'     => $fil->clean($object->duration_real, 'int'),
            'setter'            => $fil->clean($object->setter, 'int'),    
            'executor'          => $fil->clean($object->executor, 'int'),
            'schedule'          => stripcslashes($schedule),
            'steps'             => json_encode($steps),
            'solutions'         => stripcslashes($solutions),
            'checklist'         => stripcslashes($checklist),
  //          'duration_real'     => $fil->clean($object->duration_real, 'int'),
            'checks_total'      => $fil->clean($object->checks_total, 'int'),
            'checks_checked'    => $fil->clean($object->checks_checked, 'int'),
            'visual_state'      => $fil->clean($object->visual_state, 'int'),
            'date_set'          => $newDate,
            'date_start_real'   => $dsr,
            'date_finish_real'  => $dfr,
            'date_start_plan'   => $fil->clean($object->date_start_plan, 'int'),
            'date_finish_plan'  => $fil->clean($object->date_finish_plan, 'int'),
        );
        $id = DB::table(self::TB_TASKS)->insertGetId($data);
        $object->id = $id;
        return $object;
    }

    public static function updateCalendarTask($object, $user)
    {
        $fil = new InputFilter();
        $schedule  = $object->schedule;
        $steps     = $object->steps;
        $solutions = $object->solutions;
        $checklist = $object->checklist;
        if (is_array($schedule)){ $schedule = json_encode($schedule);} else {$schedule = "[]";};
        if (!is_array($steps)){$steps = "";} else { $steps = json_encode($steps);};
        if (is_array($solutions)){ $solutions = json_encode($solutions);} else {$solutions = "[]";};
        if (is_array($checklist)){ $checklist = json_encode($checklist);} else {$checklist = "[]";};

        $newDate = self::normalizeDate($object->date_set);
        $dsr = null;
        $dfr = null;
        if ($object->date_start_real != null){
            $dsr = self::normalizeDate($object->date_start_real);
        }
        if ($object->date_finish_real != null){
            $dsr = self::normalizeDate($object->date_start_real);
        }

        $data = array(
            'name'              => $fil->clean($object->name, 'string', 200),
            'description'       => $fil->clean($object->description, 'string', 990),
            'result'            => $fil->clean($object->result, 'string', 990),
            'status'            => $fil->clean($object->status, 'int'),
            'board_id'          => $fil->clean($object->board, 'int'),
            'type_id'           => $fil->clean($object->type, 'int'),
            'group_id'          => $fil->clean($object->group, 'int'),
            'project_id'        => $fil->clean($object->project, 'int'),
            'tags'              => $fil->clean($object->tags, 'string', 190),
            'duration_planned'  => $fil->clean($object->duration_planned, 'int'),
            'duration_real'     => $fil->clean($object->duration_real, 'int'),
            'setter'            => $fil->clean($object->setter, 'int'),    
            'executor'          => $fil->clean($object->executor, 'int'),
            'schedule'          => stripcslashes($schedule),
            'steps'             => $steps,
            'solutions'         => stripcslashes($solutions),
            'checklist'         => stripcslashes($checklist),
  //          'duration_real'     => $fil->clean($object->duration_real, 'int'),
            'checks_total'      => $fil->clean($object->checks_total, 'int'),
            'checks_checked'    => $fil->clean($object->checks_checked, 'int'),
            'visual_state'      => $fil->clean($object->visual_state, 'int'),
            'date_set'          => $newDate,
            'date_start_real'   => $dsr,
            'date_finish_real'  => $dfr,
            'date_start_plan'   => $fil->clean($object->date_start_plan, 'int'),
            'date_finish_plan'  => $fil->clean($object->date_finish_plan, 'int'),
        );
        $taskid = $fil->clean($object->id, "int");

        $affected = DB::table(self::TB_TASKS)
        ->where("id", $taskid)
        ->update($data);
        return $object;
    }
    

    public static function deleteTaskFromCalendar($object, $user)
    {
        $fil = new InputFilter();
        $id = $fil->clean($object->id, 'int');
        $affected = DB::table(self::TB_TASKS)->where('user', $user->id)->where('id', $id)->delete();
        return $object;
    }
}

?>