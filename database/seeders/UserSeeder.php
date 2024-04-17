<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $us = [
            [
                'name' => 'İsmail Özkan',
                'email' => 'selambeniso@gmail.com',
                'password' => Hash::make('111')
            ],
            [
                'name' => 'User 2',
                'email' => 'test@test.com',
                'password' => Hash::make('222')
            ],
            [
                'name' => 'User 3',
                'email' => 'test2@test.com',
                'password' => Hash::make('333')
            ],
        ];

        foreach ($us as $s) {
            User::insert($s);
        }
    }
}
