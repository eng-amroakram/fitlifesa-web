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

            // check file size to 1MB

            $file_size = $file->getSize();

            if ($file_size > 1000000) {
                return $this->response([
                    'image' => [
                        __("File size is too large")
                    ],
                    "size" => $file_size
                ],  [], __("File size is too large"),  422);
            }

            $data['image'] = $file;
            // $file_path = $file->store("mobile/images/users", 'public');
            // $data['image'] = $file_path ?? null;
        }

        $user = User::find(auth()->id());

        $user->updateModel($data, $user->id);

        $user = User::with('body')->find(auth()->id());

        return $this->response($user, __("User updated successfully"), 200);
    }
}
