<?php

namespace App\Traits;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;

trait ApiResponse
{
    public function jsonResponse($data=null,$meta=null,$message="success",$status=Response::HTTP_OK): JsonResponse
    {
      $content=array_filter(compact('status','message','data','meta'));
      
      return response()->json(Arr::where($content,function ($value){
        return !empty($value);
      }),$status);
    }
  
    public function error($message="error",$status=400): JsonResponse
    {
      return response()->json([
        "status"=>$status,
        "message"=>$message
      ],$status);
    }
}
