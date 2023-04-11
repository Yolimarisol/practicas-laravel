<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;
use DateTime;

class CategoriaController extends Controller
{
    public function listar(Request $request) {
        //where("estado","=",1)
   // $categorias=    Categoria::where("id",">",1)->get(array("id", "nombre"));
    $categorias = Categoria::where("estado","=",1)->select("nombre","id","fecha_registro");    
    if ($request->has('order')){
        $filtro= ($request->has('filter'))? $request->filter: "id";
        $categorias->orderBy($filtro,$request->order);
    }
    $categorias = $categorias->get();
    return response()->json($categorias);
    }
    public function obtener(Request $request, $id) {
        $categoria = Categoria::where('id','=',$id)
                            ->select("id","nombre","descripcion")
                            ->first();
        if ($categoria== null){
            $mensaje= array('error'=>'Categoria no encontrada');
            return response()->json($mensaje,404);
        }
        return response()->json($categoria);
    }
    public function insertar(Request $request) {
        $datos =array(
            "nombre"=> $request->nombre,
        "descripcion"=> $request->descripcion,
        "estado"=> 1,
        "fecha_registro" => (new DateTime())->format('Y-m-d H:i:s'),
        "fecha_actualizacion"=> (new DateTime())->format('Y-m-d H:i:s'),

        "estado"=>1,
        
        );
        $nuevaCategoria = new Categoria($datos);
        $nuevaCategoria->save();


        return response()->json($nuevaCategoria);
    }
    public function actualizar(Request $request, $id) {
        /*$categoria = Categoria::findOrfail($id);
        $datos = array(
            "nombre"=> $request->nombre,
            "descripcion"=> $request->descripcion,
            "estado"=> 1,
            "fecha_actualizacion"=> (new DateTime())->format('Y-m-d H:i:s'),
        );
        $categoria->save($datos);*/
        $categoria=Categoria::where("id",$id)->first();
        $cambios =0;
        if ($request->nombre!=null){
            $categoria->nombre=$request->nombre;
            $cambios++;
        }
        if ($request->descripcion!=null){
            $categoria->descripcion=$request->descripcion;
            $cambios++;
        }
        if ($request->estado!=null){
            $categoria->estado=$request->estado;
            $cambios++;
        }
        if ($cambios>0){
            $categoria->fecha_actualizacion = (new DateTime())->format('Y-m-d H:i:s');
        }
        
       /* $categoria->nombre = ($request->nombre==null) ? $categoria->nombre: $request->nombre;
        $categoria->descripcion = ($request->descripcion==null) ? $categoria->descripcion: $request->descripcion;
        $categoria->estado = ($request->estado==null) ? $categoria->estado: $request->estado;
        $categoria->fecha_actualizacion = (new DateTime())->format('Y-m-d H:i:s');*/
        $categoria->save();
        return response()->json($categoria);
    }

    public function eliminar(Request $request,$id) {
        $categoria = Categoria::where("id",$id)->first();
        if ($categoria==null){
            $mensaje =array(
                "error"=>"Categoria no encontrada"
            );
            return response()->json($mensaje,404);
        }
       $categoria->estado=0;
       $categoria->save();
       $borro =array(
        "eliminado"=>"Categoria eliminada"
       );
       return response()->json($borro);
    }
}
