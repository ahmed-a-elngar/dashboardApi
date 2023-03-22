<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Requests\Api\UserStoreRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\Uploaders\UserImgUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseController
{
    public function register(UserStoreRequest $request)
    {

        try {
            $img_uploader = new UserImgUploader($request, 'profile_picture');
            $img_uploader->checkAndUpload();
        } catch (\Throwable $th) {
            return $this->sendError('registeration not completed.', ['profile_picture' => 'error while uploading photo']);
        }

        $inputs               =   $request->validated();
        $inputs['password']   =   bcrypt($inputs['password']);
        $inputs['profile_picture']   =   $img_uploader->getuploadedPath();
        $user                =   User::create($inputs);

        $user['token'] = $user->createToken('accessToken')->plainTextToken;

        return $this->sendResponse('User register successfully.', new UserResource($user));
    }

    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            auth()->user()->tokens()->delete();

            $user['token']   =   $user->createToken('accessToken')->plainTextToken;

            return $this->sendResponse('User login successfully.', new UserResource($user));
        } else {
            return $this->sendError('Unauthorized.', ['error' => 'Unauthorized']);
        }
    }
}
