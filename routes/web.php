<?php

use Illuminate\Support\Facades\Route;
use App\Http\Components\ComponentRouter;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\AuthController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('login', [AuthController::class, 'index'])->name('login');
Route::get('forget', [AuthController::class, 'forget'])->name('forget');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post'); 
Route::get('registration', [AuthController::class, 'registration'])->name('register');
Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post'); 
Route::get('logout', [AuthController::class, 'logout'])->name('logout');


Route::get('/', function () {
    //return view('welcome');
    return view('public.index');
});

Route::get('/components/taskflow', function () {
    //return view('welcome');
    return view('public.components.com_taskflow.index');
});


Route::get('/session/relogin/{user_id}/{old_token}/', function (Request $request, $user_id, $old_token) {
    $result = (object) array();
    $result->message = "OK";
    $result->token = csrf_token();
    $result->old = $old_token;
    return json_encode($result);
})->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);


ComponentRouter::getComponentRoutes();