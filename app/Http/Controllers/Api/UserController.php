<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\UserStoreRequest;
use App\Http\Requests\Api\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Mail\NotifyUserMailable;
use App\Models\User;
use App\Services\Uploaders\UserImgUploader;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends BaseController
{
    public function __construct()
    {
        parent::__construct(User::class, UserResource::class);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request)
    {

        try {
            $img_uploader = new UserImgUploader($request, 'profile_picture');
            $img_uploader->checkAndUpload();
        } catch (\Throwable $th) {
            return $this->sendError('creation not completed.', ['profile_picture' => 'error while uploading photo']);
        }

        $user   =   User::create([
                        'user_name' => $request->user_name,
                        'email' => $request->email,
                        'phone' => $request->phone,
                        'password' => bcrypt($request->password),
                        'profile_picture'   => $img_uploader->getuploadedPath()
                    ]);


        if ($request->has('note_title')) {
            $user->note()->create([
                'title' => $request->note_title,
                'body' => $request->note_body
            ]);
        }

        return $this->sendResponse('user successfully created', new $this->resource($user));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, int $id)
    {
        try {
            $img_uploader = new UserImgUploader($request, 'profile_picture');
            $img_uploader->checkAndUpload();
        } catch (\Throwable $th) {
            return $this->sendError('creation not completed.', ['profile_picture' => 'error while uploading photo']);
        }

        $user = User::find($id);

        UserImgUploader::clean($user->profile_picture);

        $this->checkPasswordChanging($user, $request);

        $user->update([
                        'user_name' => $request->user_name,
                        'email' => $request->email,
                        'phone' => $request->phone,
                        'password' => bcrypt($request->password),
                        'profile_picture'   => $img_uploader->getuploadedPath()
                    ]);

        if ($request->has('note_title')) {
            if ($user->note) {
                $user->note()->update([
                    'title' => $request->note_title,
                    'body' => $request->note_body
                ]);
            } else {
                $user->note()->create([
                    'title' => $request->note_title,
                    'body' => $request->note_body
                ]);
            }
        }

        return $this->sendResponse('user successfully updated', new $this->resource($user));
    }

    protected function checkPasswordChanging($user, $request)
    {
        if(! Hash::check($request->password, $user->password))
        {
            Mail::to($user->email)->send(new NotifyUserMailable());
        }
    }
}
