<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name'=>'adriana','email'=>'ejemplo@gmail.com','password' => bcrypt('12345678')],
            ['name'=>'david','email'=>'ejemplo1@gmail.com','password' => bcrypt('1234567')],
            ['name'=>'michell','email'=>'ejemplo2@gmail.com','password' => bcrypt('123456')],
            ['name'=>'jairo','email'=>'ejemplo3@gmail.com','password' => bcrypt('12345')],
            ['name'=>'kevin','email'=>'ejemplo4@gmail.com','password' => bcrypt('1234')],
        ];

       foreach ($users as $user) {
    User::create($user);
}
    }
}
