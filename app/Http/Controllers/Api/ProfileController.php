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

    public function update()
    {
        $data = $this->request->validated;

        if ($this->request->hasFile('image')) {
            $file = $this->request->file('image');

            $file_size = $file->getSize();

            if ($file_size > 1000000) {
                return $this->responseError(__("File size must be less than 1MB"), [
                    'image' => __("File size must be less than 1MB"),
                    'file_size' => $file_size
                ], 422);
            }

            $data['image'] = $file;
        }

        $user = User::find(auth()->id());

        $user->updateModel($data, $user->id);

        $user = User::with('body')->find(auth()->id());

        return $this->response($user, __("User updated successfully"), 200);
    }
}
