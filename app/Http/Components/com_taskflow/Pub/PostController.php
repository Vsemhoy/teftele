<?php
// make specific routes defined by Installed components
namespace App\Http\Components\com_taskflow\Pub;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use App\Http\Components\com_taskflow\Ext\PostResult;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use App\Http\Extensions\Logger\Logger;
use App\Http\Components\com_taskflow\DataBaseController AS DB;
use App\Http\Components\com_taskflow\ComDefinitions;

class PostController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;


    public $file;
    public $files;
    public $user;
    public $data;
    public $result;
    private $log;
    private $json;
    function __construct()
    {
        //$this->log = new Logger();
    }

    function catchRequest(Request $request, $code)
    {
        $this->user = (object) array();
        // $this->user->id = $request->session()->get('LoggedAdmin');
        // $this->user->role = $request->session()->get('admin_role');
        $this->user->id = 1;
        $this->user->role = 1;
        $this->user = Auth::user();

        // First -> try to get file from form
        if ($request->post('formdata') != null){
            $this->file = $_FILES;
            $this->json = $request->post('formdata');
            $this->data = json_decode($this->json);

            return $this->route($code, $this->data);
        }
        $this->json = $request->getContent();
        $this->data = json_decode($this->json);

        return $this->route($code, $this->data);
    }


    private function route($code, $object){
        if ($this->user == null){
            $result = new PostResult($this->user->id);
            $result->message = "You are not logger in!";
            $result->code = 1;
            $result->status = "UNLOG";
            return json_encode($result);
        }


        // Create task from calendar
        if ($code == 200 && $this->user->status > 0){
            $result = new PostResult($this->user->id);
            $result->log_action = Logger::ACTION_READ;
            $result->log_section = ComDefinitions::$com_name;
            $result->user = $this->user->id;
            $result = $this->loadTaskIntoCalendar($result, $object, $this->user);
            Logger::writeUserLog($result);
            return json_encode($result);
        }

        // Create task from calendar
        if ($code == 300 && $this->user->status > 0){
            $result = new PostResult($this->user->id);
            $result->log_action = Logger::ACTION_CREATE;
            $result->log_section = ComDefinitions::$com_name;
            $result->user = $this->user->id;
            $result = $this->createTaskFromCalendar($result, $object, $this->user);
            Logger::writeUserLog($result);
            return json_encode($result);
        }

        // Update task from calendar
        if ($code == 400 && $this->user->status > 0){
            $result = new PostResult($this->user->id);
            $result->log_action = Logger::ACTION_UPDATE;
            $result->log_section = ComDefinitions::$com_name;
            $result->user = $this->user->id;
            $result = $this->updateTaskFromCalendar($result, $object, $this->user);
            Logger::writeUserLog($result);
            return json_encode($result);
        }
    }


    private function loadTaskIntoCalendar($result, $obj, $user)
    {
        $exec = DB::loadCalendarTasks($obj, $user);
        if (!is_object($exec)){
            $result->status = "ERR";
            $result->message = $exec;
            $result->code = 1;
            $result->item_id = -1;
        } else {
            $result->status = "OK";
            $result->message = "";
            $result->code = 0;
            $result->item_id = 0;
            $result->objects = $exec->boards;
        } 
        return $result;
    }

    private function createTaskFromCalendar($result, $obj, $user)
    {
        $exec = DB::createNewTask($obj, $user);
        if (!is_object($exec)){
            $result->status = "ERR";
            $result->message = $exec;
            $result->code = 1;
            $result->item_id = -1;
        } else {
            $result->status = "OK";
            $result->message = "";
            $result->code = 0;
            $result->item_id = $exec->id;
            $result->object = $exec;
        } 
        return $result;
    }

    private function updateTaskFromCalendar($result, $obj, $user)
    {
        $exec = DB::updateCalendarTask($obj, $user);
        if (!is_object($exec)){
            $result->status = "ERR";
            $result->message = $exec;
            $result->code = 1;
            $result->item_id = -1;
        } else {
            $result->status = "OK";
            $result->message = "";
            $result->code = 0;
            $result->item_id = $exec->id;
            $result->object = $exec;
        } 
        return $result;
    }



}
