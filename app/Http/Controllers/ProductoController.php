<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;
use DateTime;
use App\Http\Requests\NuevoProductoRequest;

class ProductoController extends Controller
{
    public function listar(Request $request){
        $producto =Producto::where("productos.estado","=",1)->select("productos.id", "productos.producto", "productos.descripcion","productos.precio_unitario","categorias.nombre AS categoria")->join("categorias","productos.categorias_id","=","categorias.id");
        $producto=$producto->get();
        return response()->json($producto);
    }
    public function obtener(Request $request, $id){
        $producto =Producto::where('productos.id','=',$id)
                            ->select("productos.id",
                             "productos.producto", 
                             "productos.descripcion",
                             "productos.precio_unitario",
                             "categorias.nombre AS categoria",
                            "productos.fecha_registro")
                              ->join("categorias","productos.categorias_id","=","categorias.id");
        $producto= $producto->first();
        if ($producto== null){
            $mensaje= array('error'=>'Producto no encontrado');
            return response()->json($mensaje,404);
        }
        return response()->json($producto);
    }

    public function insertar(NuevoProductoRequest $request){
        $request->validated();

        $categoria = Categoria::where("id", "=", $request->categorias_id)->first();
        
        if ($categoria==null){
            $mensaje =array(
                "error"=>"Categoria no encontrada"
            );
        
            return response()->json($mensaje,404);
        }

        $datos =array(
            "producto" => $request->producto,
            "descripcion" => $request->descripcion,
            "precio_unitario" => $request->precio_unitario,
            "categorias_id" => $request->categorias_id,
            "estado" => 1,
            "fecha_registro" => (new DateTime())->format('Y-m-d H:i:s'),
            "fecha_actualizacion" => (new DateTime())->format('Y-m-d H:i:s'),
        );

        $nuevoProducto= new Producto($datos);
        $nuevoProducto->save();

        return response()->json($nuevoProducto);
    }

    public function actualizar(Request $request, $id)
    {
        /*Se solicitarán los datos de nombre, descripcion y fecha de actualización para hacer 
        la consulta*/
        $producto=Producto::where("id", $id)->first();
        $producto->producto = $request->producto;
        $producto->descripcion = $request->descripcion;
        $producto->precio_unitario = $request->precio_unitario;
        $producto->categoria_id= $request->categoria_id;
        $producto->fecha_actualizacion = (new DateTime())->format("Y-m-d H:i:s");

        $producto->save(); //Guarda los datos

        return response()->json($producto); //Devuelve los datos de la variable $categoria
    }
    public function eliminar(Request $request, $id)
    {
        $producto=Producto::where("id",$id)->first();
        //Validando que el registro exista
             if($producto == null){
                    $mensaje=array(
                    'error'=>"Producto no encontrado."
              );
             //Respuesta para categoria no encontrada -404
             return response()->json($mensaje, 404);
            }
            $producto-> estado = 0;
            $producto->save();
       
            $borrado=array(
             'Exito'=> "Producto borrado exitosamente"
            );  
       return response()->json($borrado);
    }
   
}
