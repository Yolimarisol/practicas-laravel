<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    protected $table = 'productos';
    //desactivamos fechas automaticas
    public $timestamps =false;
    protected $fillable =[
        "producto",
        "descripcion",
        "precio_unitario",
        "categorias_id",
        "estado",
        "fecha_registro",
        "fecha_actualizacion",];
}
