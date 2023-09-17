<?php


namespace App\Traits;

use App\Http\Controllers\Services\Services;
use Illuminate\Support\Facades\Validator;

trait APIHelper
{
    public function makeAPIValidation($request, $service_name)
    {
        $validator = Validator::make($request->all(), apiRules($service_name, auth()->id()), apiRulesMessages($service_name));
        return $validator;
    }

    public function response($data, $message = "", $status = 200)
    {
        return response()->json([
            "data" => $data,
            "message" => $message,
            "status" => $status,
        ], $status);
    }

    public function responseError($message, $errors, $status = 400)
    {
        return response()->json([
            "message" => $message,
            "errors" => $errors,
            "status" => $status,
        ], $status);
    }

    public function responseSuccess($message, $status = 200)
    {
        return response()->json([
            "message" => $message,
            "status" => $status,
        ], $status);
    }

    public function responseWithPagination($data, $message = "", $status = 200)
    {
        return response()->json([
            "data" => $data->items(),
            "total" => $data->total(),
            "message" => $message,
            "status" => $status,
        ], $status);
    }
}
