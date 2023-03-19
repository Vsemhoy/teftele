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
    const TB_CATEGORIES = self::TB_PREFIX . "categories";
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
        $boards = DB::table(self::TB_CATEGORIES)->where('user', $user->id)->orderBy('ordered')->get();
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
}

?>