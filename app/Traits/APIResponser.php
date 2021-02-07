<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

trait APIResponser
{
	private function successResponse($data, $code)
	{
		return response()->json($data, $code);
	}

	protected function errorResponse($data, $code)
	{
		return response()->json(['error' => $data, 'code'=> $code],$code);
	}

	protected function showAll(Collection $collection, $code = 200)
	{   
		if($collection->isEmpty())
			return $this->successResponse($collection);

		$transformer = $collection->first()->transformer;
		$collection = $this->transformData($collection, $transformer);
		 	
		return $this->successResponse(['data' => $collection], $code);
	}

	protected function showOne(Model $instance, $code = 200)
	{	
		$transformer = $instance->transformer;
		$instance = $this->transformData($collection, $transform);

		return $this->successResponse(['data' => $instance], $code);
	}

	protected function showMessage($message, $code = 200)
	{   
		return $this->successResponse(['data' => $message], $code);
	}

	protected function transformData($data, $transformer)
	{
		$transform = fractal($data, new $transformer);

		return $transform->toArray();
	}
}