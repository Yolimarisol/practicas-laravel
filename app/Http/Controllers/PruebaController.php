<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PruebaController extends Controller
{
    public function saludo(Request $request){
        $nombre = $request->nombre;
        $apellido =$request->apellido;
        $edad = $request->edad;
        $datos = array (
            'nombre'=> $nombre,
            'apellido' =>$apellido,
            'edad'=>$edad
        );
        if ($edad>=18){
            $datos['mayorEdad']= true;
        }else {
            $datos['mayorEdad']= false;
        }
        return response()->json($datos);
    }
    public function despedida(){
        $nombre = "Marisol";
        return "Adios " . $nombre;
    }
    public function calculadora(Request $request){
        $n1=$request->n1;
        $n2=$request->n2;
        $suma= $n1+$n2;
       // $suma = "$n1 + $n2 = $suma";
        $resta= $n1-$n2;
       // $resta= "$n1 - $n2 = $resta";
        $divicion= ($n2==0)? "Error de sytaxis": $n1/$n2;
       // $divicion= "$n1 / $n2 = $divicion";
        $multiplicacion= $n1*$n2;
       // $multiplicacion= "$n1 * $n2 = $multiplicacion";
        $operacion = array (
            'numero1'=> $n1,
            'numero2'=> $n2,
            'suma'=>$suma,
            'resta'=>$resta,
            'division'=>$divicion,
            'multiplicacion'=>$multiplicacion
        );
        return response()->json($operacion);

    }

    public function imc(Request $request){
        $peso = $request->peso;
        $altura = $request->altura;
        $calculo =($altura==0)? "ingrese altura": $peso/($altura*$altura);
        $imc= 0;
        if ($calculo<20){
            $imc= -1;
        }elseif ($calculo>=20 && $calculo<=25){
            $imc= 0;
        }elseif ($calculo>25){
            $imc= 1;
        }
        $estado="El estado de tu peso es: ";
        if ($imc==-1){
            $estado= "$estado Desnutrición";
        }elseif ($imc==0){
            $estado= "$estado Peso adecuado";
        }elseif ($imc==1){
            $estado= "$estado Sobrepeso";
        }
        $datos= array(
            'peso' => $peso,
            'altura'=>$altura,
            'calculoIMC'=>$calculo,
            'IMC'=>$imc,
            'estado'=>$estado
        );
        return response()->json($datos);
    }

    public function nuevaInfo(Request $request){
        $errores =array();
        if ($request->producto == null){
            $errores['producto']= "El producto es requerido";
          /*  $error = array(
                "Error"=>"El producto es requerido"
            );
            return response()->json($error,400);*/
        }
        if ($request->descripcion == null){
            $errores['descripcion']= "La descripcion es requerida";
           /* $error = array(
                "Error"=>"La descripcion es requerida"
            );
            return response()->json($error,400);*/
        }
        if ($request->precio == null|| $request->precio <=0){
            $errores['precio']= "El precio es requerido y debe ser mayor que cero";
            /*$error = array(
                "Error"=>"El precio es requerido y debe ser mayor que cero"
            );
            return response()->json($error,400);*/
        }
        if (count($errores)>0){
            return response()->json($errores,400);
        }
        $datos = array(
            'producto'=> $request->producto,
            'descripcion'=> $request->descripcion,
            'precio'=> $request->precio,
        );
        return response()->json($datos);

    }

    public function actualizacion(Request $request){
        $datos = array(
            'producto'=> "Manzanas",
            'descripcion'=> "Calidad superior",
            'precio'=> 0.50,
        );
        if ($request->producto != null){
            $datos['producto']=$request->producto;
        }
        if ($request->precio != null&& $request->precio >0.10){
            $datos['precio']= $request->precio;}
        return response()->json($datos);}
    

    public function borrarInfo(Request $request,$id){
        $listado = array(
            array(
                "producto"=>"Manzana",
                "precio"=>0.5
            ),
            array(
                "producto"=>"Guineo",
                "precio"=>0.15
            ),
            array(
                "producto"=>"Pera",
                "precio"=>0.6
            )
        );
        for ($i=0; $i < count($listado) ; $i++) { 
            $position = $i+1;
            if ($id==$position){
               // unset($listado[$i]);
               array_splice($listado,$i,1);
            }
        }
        return response()->json($listado);

    }

}