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
                "isFile" => $data['validated']['image'],
                "check-image" => $request->hasFile('image'),
                "file-image" => $request->file('image'),
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
