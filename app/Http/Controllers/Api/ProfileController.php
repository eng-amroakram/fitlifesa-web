<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\APIHelper;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    use APIHelper;

    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function user()
    {
        $user = User::with('body')->find(auth()->id());
        return $this->response($user, __("User fetched successfully"), 200);
    }


}
