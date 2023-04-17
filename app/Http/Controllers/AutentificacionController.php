<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use DateTime;
use Auth;
use Carbon\Carbon;
//Libreria para formatear texto
use illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class AutentificacionController extends Controller
{
    public function registro(Request $request){
    
        $actual = new DateTime();
    
        //Aqui se almacena la imagen
        $imagen=$request->file('foto');
        //Obtenemos la extension de la imagen 
        $extension=$imagen->extension();
    
        //Ejemplo: Victor Jose Lòpez(victor-jose-lopez)
        $nombreImagen =Str::slug($request->usuario) .".".$extension;
        //Slug:cadena unica para identificar un registro
    
                $data = array(
                'usuario' => $request->usuario,
                'foto_perfil'=>$nombreImagen,
                'correo' => $request->correo,
                'password' => bcrypt($request->password),
                'estado'=>1,
                'fecha_creacion'=>$actual,
                'fecha_actualizacion'=>$actual,
            );
            //Moviendo iamgen a carpeta store
            $imagen->storeAS('fotos-perfil/',$nombreImagen);
    
            $nuevoUsuario = new User($data);
            $nuevoUsuario->save();
            $mensaje = array(
                'mensaje' =>"Usuario registrado exitosamente."
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

    public function verFotoPerfil($nombreimagen)
    {
        $ruta = storage_path('app/fotos-perfil'. $nombreimagen);
        if(file_exists($ruta) == false){
            abort(404);
        }
    }
    //obtenemos el archivo de imagen
    $imagen = File::get($ruta);
    $tipo = File::mimeType($ruta);
    $respuesta=Response::make($imagen,200);
    $respuesta->header("Content-Type", $tipo);
    return $respuesta;
}
