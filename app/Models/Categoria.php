<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;
    protected $table = 'categorias';
    //desactivamos fechas automaticas
    public $timestamps =false;
    protected $fillable =[
        "nombre",
        "descripcion",
        "estado",
        "fecha_registro",
        "fecha_actualizacion",];
}
