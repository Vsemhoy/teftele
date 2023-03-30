<?php
use Illuminate\Support\Facades\Route;
use App\Http\Components\com_taskflow\ComDefinitions;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Http\Components\com_taskflow\Pub\MainController;
use App\Http\Components\com_taskflow\Pub\PostController;
use Illuminate\Http\Request;


Route::prefix(ComDefinitions::$com_name)->group(function(){

    Route::get('/', function () {
        //return view('welcome');
        
        return view(ComDefinitions::getViewPath() . '.index');
    })->name(ComDefinitions::$com_name );

    Route::get('/index', function () {
        //return view('welcome');
        
        return view(ComDefinitions::getViewPath() . '.index');
    })->name(ComDefinitions::$com_name . ".index");

    Route::get('/calendar/{board}', [MainController::class, 'getCalendarPage'])->name(ComDefinitions::$com_name . ".calendar_board");
    Route::get('/calendar/', [MainController::class, 'getCalendarPageDefault'])->name(ComDefinitions::$com_name . ".calendar");

    // Route::get('/calendar', function () {
    //     //return view('welcome');
    //     return view(ComDefinitions::getViewPath()  . '.calendar');
    // })->name(ComDefinitions::$com_name . ".calendar");
    
    
    // Route::get('/boards', function () {
    //     return view(ComDefinitions::getViewPath()  . '.boards');
    // })->name(ComDefinitions::$com_name . ".boards");getBoardsManager

    Route::get('/boards/', [MainController::class, 'getBoardsManager'])->name(ComDefinitions::$com_name . ".boards");

    Route::get('/board', function () {
        return view(ComDefinitions::getViewPath()  . '.board');
    })->name(ComDefinitions::$com_name . ".board");


    Route::get('/settings', function () {
        return view(ComDefinitions::getViewPath()  . '.settings');
    })->name(ComDefinitions::$com_name . ".settings");

    Route::post('/post/{code}', [PostController::class, 'catchRequest']);
    

});
