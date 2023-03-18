<?php
// make specific routes defined by Installed components
namespace App\Http\Components\com_taskflow\Pub;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use App\Http\Components\com_taskflow\Ext\PostResult;
use Illuminate\Routing\Controller as BaseController;

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

        if ($code == 300 && $this->user->role > 0){
            $result = new PostResult($this->user->id);
            $result->message =  "I hear YOu, my boy!";
            $result->code = 0;
            $result->item_id = 2;
            return json_encode($result);
        }

        if ($code == 400 && $this->user->role > 0){
            $result = new PostResult($this->user->id);
            $result->message =  "I hear YOu, my bro!";
            $result->code = 0;
            $result->item_id = $object->id;
            return json_encode($result);
        }
    }
}
