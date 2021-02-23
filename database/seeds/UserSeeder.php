<?php

use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder{
    public function run(){
        $json = File::get("database/veriler/users.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            User::create(array(
            'name' => $obj->name,
            'email' => $obj->email,
            'about' => $obj->about,
            'social' => $obj->social,
            'resim' => $obj->resim,
            'email_verified_at' => $obj->email_verified_at,
            'password' => $obj->password,
            'remember_token' => $obj->remember_token,
            'created_at' => $obj->created_at,
            'updated_at' => $obj->updated_at
          ));
        }
    }
}
