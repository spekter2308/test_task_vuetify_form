<?php

namespace App\Http\Services;

use App\Models\PhoneBook;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;

class UserRegisterService
{
    public function createUser(array $data): User | Trowable
    {
        DB::beginTransaction();
        try {
            $user = User::create($data);
            $user->countries()->sync([
                $data['country_id']
            ]);
            PhoneBook::create([
                'phone' => $data['phone'],
                'user_id' => $user->id
            ]);
            DB::commit();
            event(new Registered($user));
        } catch (\Throwable $tr) {
            DB::rollBack();
            return throw $tr;
        }
        return $user;
    }
}
