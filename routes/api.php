<?php

//use App\Http\Controllers\AutentificacionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\PruebaController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\AutentificacionController;

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

Route::get("/saludo", [ PruebaController::class, "saludo" ]);
Route::get("/calculadora", [ PruebaController::class, "calculadora" ]);
Route::get("/imc", [ PruebaController::class, "imc" ]);

Route::post("/nuevo-producto", [PruebaController::class, "nuevaInfo"] );
Route::put("/actualizar-producto",[PruebaController::class, "actualizacion"]);
Route::delete("/borrar-producto/{id}", [PruebaController::class,"borrarInfo"]);

Route::get("/categorias/listar",[CategoriaController::class,"listar"]);
Route::get("/categorias/obtener/{id}",[CategoriaController::class,"obtener"]);
Route::post("/categorias/insertar",[CategoriaController::class,"insertar"]);
Route::post("/categorias/actualizar/{id}",[CategoriaController::class,"actualizar"]);
Route::post("/categorias/eliminar/{id}",[CategoriaController::class,"eliminar"]);

Route::get("/productos/listar",[ProductoController::class,"listar"]);
Route::get("/productos/obtener/{id}",[ProductoController::class,"obtener"]);
Route::post("/productos/insertar",[ProductoController::class,"insertar"]);

Route::post("/auto/registro",[AutentificacionController::class,"registro"]);
Route::post("/auto/iniciar-sesion",[AutentificacionController::class,"iniciarSesion"]);

Route::middleware(['auth:api'])->group(function(){
    Route::get("/auto/perfil",[AutentificacionController::class,"perfil"]);
    Route::get("/auto/cerrar-sesion",[AutentificacionController::class,"cerrarSesion"]);
});