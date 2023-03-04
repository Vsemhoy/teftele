<?php
use Illuminate\Support\Facades\Route;
use App\Http\Components\com_demo\ComDefinitions;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;



Route::prefix(ComDefinitions::$com_name)->group(function(){

    Route::get('/', function () {
        //return view('welcome');
        
        return view(ComDefinitions::getViewPath() . '.index');
    })->name(ComDefinitions::$com_name);

    Route::get('/index', function () {
        //return view('welcome');
        
        return view(ComDefinitions::getViewPath() . '.index');
    })->name(ComDefinitions::$com_name . ".index");

    Route::get('/test', function () {
        //return view('welcome');
        return view(ComDefinitions::getViewPath()  . '.test');
    })->name(ComDefinitions::$com_name . ".test");
    
    
    Route::get('/boards', function () {
        return view(ComDefinitions::getViewPath()  . '.boards');
    })->name(ComDefinitions::$com_name . ".boards");

});
