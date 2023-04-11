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

    public function actualizar(Request $request){
        
    }
    public function eliminar(Request $request){
        
    }
   
}
