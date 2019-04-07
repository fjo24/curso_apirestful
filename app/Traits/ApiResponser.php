<?php
namespace App\Traits;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

trait ApiResponser
{
	//respuesta satisfactoria
	private function successResponse($data, $code)
	{
		return response()->json($data, $code);
	}
	//respuesta con error.. funcion protegida
	protected function errorResponse($message, $code)
	{
		return response()->json(['error' => $message, 'code' => $code], $code);
	}
	//ver todos los elementos
	protected function showAll(Collection $collection, $code = 200)
	{
		return $this->successResponse(['data' => $collection], $code);
	}
	//ver un elemento en especifico
	protected function showOne(Model $instance, $code = 200)
	{
		return $this->successResponse(['data' => $instance], $code);
	}
}