<?php
namespace App\Http\Components\com_taskflow;

use Illuminate\Support\Facades\Route;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Models\Component;
use Illuminate\Support\Facades\DB;
use App\Vendor\Joomla\Filter\InputFilter;


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

}

?>