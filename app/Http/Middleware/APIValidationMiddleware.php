<?php

namespace App\Http\Middleware;

use App\Traits\APIHelper;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class APIValidationMiddleware
{
    use APIHelper;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $service_name): Response
    {
        $validator = $this->makeAPIValidation($request, $service_name);

        $testing = [
            "isFile" => $request->file('image') ?? false,
            "name" => $request->file('image')->getClientOriginalName(),
            "size" => $request->file('image')->getSize(),
            "extension" => $request->file('image')->getClientOriginalExtension(),
            "mime" => $request->file('image')->getMimeType(),
        ];
        return $this->responseError("validation error", $testing, 422);

        if ($validator->passes()) {
            $data['validated'] = $validator->validated();
            $request->merge($data);
        }

        if ($validator->fails()) {
            return $this->responseError("validation error", $validator->errors(), 422);
        }


        return $next($request);
    }
}
