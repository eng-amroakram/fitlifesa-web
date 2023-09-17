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

        if ($validator->passes()) {
            $data['validated'] = $validator->validated();


            $testing = [
                "isFile" => $data['validated']['image']->file('image') ?? false,
                "name" => $data['validated']['image']->file('image')->getClientOriginalName(),
                "size" => $data['validated']['image']->file('image')->getSize(),
                "extension" => $data['validated']['image']->file('image')->getClientOriginalExtension(),
                "mime" => $data['validated']['image']->file('image')->getMimeType(),
            ];

            $request->merge($data);

            return $this->responseError("validation error", $testing, 422);
        }

        if ($validator->fails()) {
            return $this->responseError("validation error", $validator->errors(), 422);
        }


        return $next($request);
    }
}
