<?php

// Seeder para poblar la tabla de usuarios en la base de datos
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    // Método que se ejecuta para insertar datos en la tabla de usuarios
    public function run(): void
    {
        // Array de usuarios a ser creados
        $users = [
            ['name'=>'adriana','email'=>'ejemplo@gmail.com','password' => bcrypt('12345678')],
            ['name'=>'david','email'=>'ejemplo1@gmail.com','password' => bcrypt('1234567')],
            ['name'=>'michell','email'=>'ejemplo2@gmail.com','password' => bcrypt('123456')],
            ['name'=>'jairo','email'=>'ejemplo3@gmail.com','password' => bcrypt('12345')],
            ['name'=>'kevin','email'=>'ejemplo4@gmail.com','password' => bcrypt('1234')],
        ];

        // Itera sobre el array de usuarios y los crea en la base de datos
        foreach ($users as $user) {
            User::create($user);
        }
    }
}
