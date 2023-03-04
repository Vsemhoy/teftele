<?php
// make specific routes defined by Installed components
namespace App\Http\Components\com_taskflow\Pub;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class PostController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

}
