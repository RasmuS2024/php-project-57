<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    private const PASSWORD = 'password';
    public function run()
    {
        $users = [
            [
                'name' => 'Матвей Иванович Ефремов',
                'email' => 'efremov@example.com',
                'password' => Hash::make(self::PASSWORD),
            ],
            [
                'name' => 'Эдуард Иванович Хохлов',
                'email' => 'khokhlov@example.com',
                'password' => Hash::make(self::PASSWORD),
            ],
            [
                'name' => 'Лидия Фёдоровна Петрова',
                'email' => 'petrova@example.com',
                'password' => Hash::make(self::PASSWORD),
            ],
            [
                'name' => 'Прохор Андреевич Жданов',
                'email' => 'zhdanov@example.com',
                'password' => Hash::make(self::PASSWORD),
            ],
            [
                'name' => 'Ирина Андреевна Бобылёва',
                'email' => 'bobyleva@example.com',
                'password' => Hash::make(self::PASSWORD),
            ],
            [
                'name' => 'Ираклий Александрович Евдокимов',
                'email' => 'evdokimov@example.com',
                'password' => Hash::make(self::PASSWORD),
            ],
            [
                'name' => 'Евгения Евгеньевна Герасимова',
                'email' => 'gerasimova@example.com',
                'password' => Hash::make(self::PASSWORD),
            ],
            [
                'name' => 'Марина Борисовна Смирнова',
                'email' => 'smirnova@example.com',
                'password' => Hash::make(self::PASSWORD),
            ],
            [
                'name' => 'Альберт Максимович Власов',
                'email' => 'vlasov@example.com',
                'password' => Hash::make(self::PASSWORD),
            ],
            [
                'name' => 'Марк Евгеньевич Аксёнов',
                'email' => 'aksenov@example.com',
                'password' => Hash::make(self::PASSWORD),
            ],
        ];

        DB::table('users')->insert($users);
    }
}
