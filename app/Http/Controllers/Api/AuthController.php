<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Body;
use App\Models\User;
use App\Traits\APIHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use APIHelper;

    protected $request = Request::class;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function user()
    {
        $user = User::with("body")->find(auth()->id());
        $body = $user->body;
        $user->is_body_info_completed = $body ? $body->check_user_body : false;

        return $this->response(["user" => $user], __("User Fetched Successfully"), 200);
    }

    public function login()
    {
        $data = $this->request->validated;

        $user = User::with("body")->where("phone", $data['phone'])->first();

        if (!($data['password'] ==  $user->password)) {

            $errors =  [
                "password" => [
                    __("Password Is Not Correct")
                ]
            ];
            return $this->responseError("validation error", $errors, 422);
        }

        $body = $user->body;
        $user->is_body_info_completed = $body ? $body->check_user_body : false;

        $token = $user->createToken("New Client ID: " . $user->id, ['*']);

        $user->token = $token->plainTextToken;

        return $this->response(["user" => $user], __("Login Successfully"), 200);
    }

    public function register()
    {
        $data = $this->request->validated;
        $data['otp_code'] = 11111;
        $data['status'] = 'inactive';
        $user = User::create($data);
        $body = Body::create(["user_id" => $user->id]);
        $user = User::with("body")->find($user->id);
        $body = $user->body;
        $user->is_body_info_completed = $body ? $body->check_user_body : false;
        $token = $user->createToken("New Client ID: " . $user->id, ['*']);
        $user->token = $token->plainTextToken;
        return $this->response(["user" => $user], __("Your Account Created Successfully"), 201);
    }

    public function verify()
    {
        $data = $this->request->validated;
        $user = User::with("body")->where("phone", $data['phone'])->first();

        if ($user->otp_code == $data['otp_code']) {
            $user->otp_code = null;
            $user->status = 'active';
            $user->email_verified_at = now();
            $user->save();
            $body = $user->body;
            $user->is_body_info_completed = $body ? $body->check_user_body : false;
            return $this->response(["user" => $user], __("Your Account Verified Successfully"), 200);
        }

        return $this->response([], __("The Code Is Not Correct"), 422);
    }

    public function logout()
    {
        $this->request->user()->currentAccessToken()->delete();
        return $this->response([], __("Logout Successfully"), 200);
    }

    public function changePassword()
    {
        $data = $this->request->validated;
        $user = $this->request->user();

        if (!($user->password == $data['old_password'])) {
            return $this->response([], __("Old Password Is Not Correct"), 422);
        }

        $user->password = $data['new_password'];
        $user->save();

        return $this->response([], __("Password Changed Successfully"), 200);
    }

    public function resendSmsOtp()
    {
        $data = $this->request->validated;
        $user = User::where("phone", $data['phone'])->first();

        $user->otp_code = 11111;
        $user->save();

        return $this->response([], __("OTP Code Sent Successfully"), 200);
    }
}
