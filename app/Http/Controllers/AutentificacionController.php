<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use DateTime;
use Auth;
use Carbon\Carbon;

class AutentificacionController extends Controller
{
    public function registro(Request $request){
        $actual = new DateTime();
        $data = array(
            'usuario'=> $request->usuario,
            'correo'=> $request->correo,
            'password'=> bcrypt($request->password),
            "fecha_registro" =>$actual,
        "fecha_actualizacion"=>$actual,
        "estado"=>1
        );
        $nuevoUsuario =new User($data);
        $nuevoUsuario->save();
        $mensaje =array(
            'mensaje'=> "usuario registrado con exito"
        );

        return response()->json($mensaje);
    }
    public function iniciarSesion(Request $request){
        $credenciales = request([ 'correo', 'password']);
        if (Auth::attempt($credenciales) == false){
            $mensaje = array(
                'mensaje' => 'Verifique sus credenciales'
            );
            return response()->json($mensaje, 401);
        }
        $usuario =$request->user();
        $generarToken = $usuario->createToken('User Access Token');
        $token = $generarToken->token;
        $token->save();

        $respuesta = array(
            'token_acceso'=> $generarToken->accessToken,
            'tipo_token' => 'Bearer',
            'fecha_expiracion' => $generarToken->token-> mnexpires_at
        );
        return response()->json($respuesta);
    }
    public function perfil(Request $request){
        $informacion = $request->user();
        
        return response()->json($informacion);
    }
    public function cerrarSesion(Request $request){
        $informacion = $request->user();
        $informacion->token()->revoke();
        $mensaje = [
            'mensaje'=> 'Cierre de sesion exitoso'
        ];
        return response()->json($mensaje);
    }
    //
}
