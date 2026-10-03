<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Preflight;
use App\Http\Middleware\Tokenmiddleware;

use Symfony\Component\Console\Output\ConsoleOutput;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

 //TO RUN LOCALLY: php -S localhost:8000 -t public/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/*
Route::middleware('auth:api', 'verified')->group(function () {
  // Your routes here...
});*/

Route::get('/clear-cache', function() {
    
    $exitCode = Artisan::call('config:cache');
    $exitCode = Artisan::call('route:clear');
    //$exitCode = Artisan::call('view:clear');
    //$output = new ConsoleOutput();
   // $output->writeln(env('FRONTEND_URL'));

    return 'DONE'; //Return anything
  });


 // Route::post('Login', 'UserController@login')-> middleware(Preflight::class); //pref, didnt work wtff



  Route::group(['middleware' =>[Preflight::class,Tokenmiddleware::class]], function(){


   
    Route::post('password/email', 'ForgotPassword@sendResetLinkEmail')->middleware('throttle:50,5');
    Route::post('password/reset', 'ForgotPassword@reset')->middleware('throttle:50,5');
  

    Route::post('Login', 'UserController@login');
  Route::get('alumno/','UserController@showalltesters');
  Route::get('alumno/{id}','UserController@show');
  Route::post('alumno','UserController@store');
  Route::patch('alumno/{id}','AlumnoController@update');
  Route::delete('alumno/{id}','AlumnoController@destroy');

  Route::patch('curso/{idalumno}','CursoController@updatecurso');

  Route::post('quiz1','CursoController@storequiz1');
  Route::post('quiz2','CursoController@storequiz2');
  Route::post('quiz3','CursoController@storequiz3');
  Route::post('quiz4','CursoController@storequiz4');
  Route::post('quiz5','CursoController@storequiz5');
  Route::post('quiz6','CursoController@storequiz6');

  Route::get('quiz1/{idalumno}','CursoController@getquiz1');
  Route::get('quiz2/{idalumno}','CursoController@getquiz2');
  Route::get('quiz3/{idalumno}','CursoController@getquiz3');
  Route::get('quiz4/{idalumno}','CursoController@getquiz4');
  Route::get('quiz5/{idalumno}','CursoController@getquiz5');
  Route::get('quiz6/{idalumno}','CursoController@getquiz6');

  Route::get('quiz1','CursoController@showallquiz1');
  Route::get('quiz2','CursoController@showallquiz2');
  Route::get('quiz3','CursoController@showallquiz3');
  Route::get('quiz4','CursoController@showallquiz4');
  Route::get('quiz5','CursoController@showallquiz4');
  Route::get('quiz6','CursoController@showallquiz4');


  Route::get('curso/','CursoController@showall');
  Route::get('curso/{id}','CursoController@show');
  Route::post('curso','CursoController@store');
  Route::patch('curso/{id}','CursoController@update');
  Route::delete('curso/{id}','CursoController@destroy');

  Route::get('curso/alumno/{id}','CursoController@showalumno');







  });