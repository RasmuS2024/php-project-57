<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'name' => 'Матвей Иванович Ефремов',
                'email' => 'efremov@example.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Эдуард Иванович Хохлов',
                'email' => 'khokhlov@example.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Лидия Фёдоровна Петрова',
                'email' => 'petrova@example.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Прохор Андреевич Жданов',
                'email' => 'zhdanov@example.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Ирина Андреевна Бобылёва',
                'email' => 'bobyleva@example.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Ираклий Александрович Евдокимов',
                'email' => 'evdokimov@example.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Евгения Евгеньевна Герасимова',
                'email' => 'gerasimova@example.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Марина Борисовна Смирнова',
                'email' => 'smirnova@example.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Альберт Максимович Власов',
                'email' => 'vlasov@example.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Марк Евгеньевич Аксёнов',
                'email' => 'aksenov@example.com',
                'password' => Hash::make('password'),
            ],
        ];

        DB::table('users')->insert($users);
    }
}
