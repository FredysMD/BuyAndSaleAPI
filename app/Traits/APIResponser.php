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
		
		$collection = $this->filterData($collection, $transformer);
		$collection = $this->sortData($collection, $transformer);
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

	protected function filterData(Collection $collection, $transformer)
	{
		
		foreach(request()->query() as $query => $value){
			
			$attribute = $transformer::originalAttribute($query);
			
			if(isset($attribute, $value)) {
				$collection = $collection->where($attribute, $value);
				
			}
		} 
		return $collection;
	}

	protected function transformData($data, $transformer)
	{
		$transform = fractal($data, new $transformer);

		return $transform->toArray();
	}

	protected function sortData(Collection $collection, $transformer)
	{	
		if(request()->has('sort_by')){
			$attribute = $transformer::originalAttribute(request()->sort_by);
			$collection = $collection->sortBy->{$attribute};
		}

		return $collection;
	}
}