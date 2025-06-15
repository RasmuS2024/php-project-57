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
                'password' => Hash::make('Xk9!qP2$mL7nR5tY'),
            ],
            [
                'name' => 'Эдуард Иванович Хохлов',
                'email' => 'khokhlov@example.com',
                'password' => Hash::make('G7h#bN4@pQ1vK8wZ'),
            ],
            [
                'name' => 'Лидия Фёдоровна Петрова',
                'email' => 'petrova@example.com',
                'password' => Hash::make('T3r&cV6!sD9fX2mP'),
            ],
            [
                'name' => 'Прохор Андреевич Жданов',
                'email' => 'zhdanov@example.com',
                'password' => Hash::make('L5k@jH8#qW4eR7tU'),
            ],
            [
                'name' => 'Ирина Андреевна Бобылёва',
                'email' => 'bobyleva@example.com',
                'password' => Hash::make('B4v%nM1!kI9oL6pY'),
            ],
            [
                'name' => 'Ираклий Александрович Евдокимов',
                'email' => 'evdokimov@example.com',
                'password' => Hash::make('P8o#dF3$zX6qW9jN'),
            ],
            [
                'name' => 'Евгения Евгеньевна Герасимова',
                'email' => 'gerasimova@example.com',
                'password' => Hash::make('N2m!bV7#kL5pQ9wE'),
            ],
            [
                'name' => 'Марина Борисовна Смирнова',
                'email' => 'smirnova@example.com',
                'password' => Hash::make('R9t$yH4!uJ7iK2lO'),
            ],
            [
                'name' => 'Альберт Максимович Власов',
                'email' => 'vlasov@example.com',
                'password' => Hash::make('S5f#gH8@jK3lP6qW'),
            ],
            [
                'name' => 'Марк Евгеньевич Аксёнов',
                'email' => 'aksenov@example.com',
                'password' => Hash::make('W6e$rT2!yU9iO4pA'),
            ],
        ];

        DB::table('users')->insert($users);
    }
}
