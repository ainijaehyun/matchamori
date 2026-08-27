<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Administrator',
                'email' => 'admin@gmail.com',
                'password' => bcrypt(config('app.admin_password')),
                'role' => 'admin'
            ],
            [
                'name' => 'Customer Matcha Mori',
                'email' => 'customer@gmail.com',
                'password' => bcrypt(config('app.customer_password')),
                'role' => 'customer'
            ]
        ];

         foreach ($users as $user) {
            User::firstOrCreate(
                ['email' => $user['email']],
            );
        }

        // User::firstOrCreate(
        //     [
        //         'email' => 'admin@matchamori.com'
        //     ],
        //     [
        //         'name' => 'Administrator',
        //         'password' => bcrypt('password'),
        //         'role' => 'admin'
        //     ]
        // );

        // User::firstOrCreate(
        //     [
        //         'email' => 'customer@matchamori.com'
        //     ],
        //     [
        //         'name' => 'Customer MatchaMori',
        //         'password' => bcrypt('password'),
        //         'role' => 'customer'
        //     ]
        // );
    }
}
