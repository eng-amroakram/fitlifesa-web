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
        return $this->responseError("validation error", $request->file('image'), 422);

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
