<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegisterRequest;
use App\Http\Services\UserRegisterService;
use App\Models\PhoneBook;
use App\Models\User;

class RegisterController extends Controller
{
    public function register(UserRegisterRequest $request, UserRegisterService $userRegisterService) {
        $user = $userRegisterService->createUser($request->validated());

        $message = 'error';
        $code = 422;
        if ($user instanceof User) {
            $message = 'success';
            $code = 200;
        }
        return response()->json(['status' => $message], $code);
    }
}
