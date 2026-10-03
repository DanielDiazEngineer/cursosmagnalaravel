<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
#use Symfony\Component\Console\Output\ConsoleOutput;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Curso;

class UserController extends Controller {
    public function login()
    {
        try {
            $credentials = request(['email', 'password']);
            if (!Auth::attempt($credentials)) {
                return response()->json([
                  'status' => 'error',
                  'mensaje' => 'Las credenciales no son válidas',
                 'data' => []]);
            }

            $user = Auth::user();

            $curso = Curso::where('idalumno', '=', $user->id)->first();
            $currentcurso = optional($curso)->currentcurso;

            return response()->json([
                'status' => 'success',
                'mensaje' => 'Usuario logeado con èxito',
               'data' => [
                'id' => $user->id, // user's id
                'name' => $user->name, // user's name
                'type' => $user->type, // user's type

                'currentcurso'=>$currentcurso
            ]
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'mensaje' => 'Error interno al iniciar sesión',
                'data' => $e->getMessage()
            ]);
        }
    }

    public function store(Request $request) 
    { 


  try{

        $email = $request->input('email');

if (User::where('email', $email)->exists()) {
    return response()->json([
        'status' => 'error',
        'message' => "Error al registrar, el correo ya existe",
    ]);
}
  $postArray = $request->all();                                                   //lav5.4
  $postArray['password'] = bcrypt($postArray['password']);      //withoutthis auth faileeeed1!!

   $user = User::create($postArray);

   
   if($user['type'] == 'user'){
    
    Curso::create([
      'idalumno' => $user->id,
      'nombrealumno' => $user->name,
      //'currentcurso' => -1, //migration override
      'time1' => null,
      'time2' => null,
      'time3' => null,
      'time4' => null,
      'time5' => null,
      'time6' => null,
      'time7' => null,
      'time8' => null,
      'time9' => null,
    ]);

   }
  
   
  return response()->json([
    'status' => 'success',
    'mensaje' => 'Usuario registrado con exito',
    'data' => $user,
  ]); 



 }catch(\Throwable $e){

   return response()->json([
     'status' => 'error',
     'message' => "Error al registrar, el correo ya existe",
     'data' => $e->getMessage()
   ]); 
 }
}


    //invalidate token?
public function logout(Request $request)
{
   //JWTAuth::invalidate($token) ; //!!!!!!

  //auth()->logout();   //?
//if(Auth)
/*
 if(Auth::check()){

   $user =auth()->user();
   //Auth::user()->apitoken =
   $user->apitoken = null;
 }*/
 $headertoken = $request->header('Authorization');
 $token = null;
 $token = substr($headertoken,13); 

 $api = User::where('apitoken', '=', $token)->first();

   $api->apitoken  = null;
   $api->save();
   //Auth::logout();

  return response()->json(['status'=> 'success']);// 'Cerró sesión con éxito']);
}

public function showalltesters()
{
    //

    $users = User::where('type', '=', 'user') ->select('id', 'name', 'email','created_at')->orderBy('created_at', 'desc')->get();
    return response()->json([
        'status' => 'success',
        'mensaje' => 'Lista testers recuperada con èxito',
        'data' =>  $users
    ]);
  
}








}


  

