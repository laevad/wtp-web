<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(
            [
                'id'=>Uuid::uuid3(Uuid::NAMESPACE_DNS, 'example.com')->toString(),
                'name'=>'Admin',
                'email'=>'a@a.a',
                'password'=> bcrypt('1234'),
                'created_at'=>now(),
                'email_verified_at'=>now(),
                'role_id'=>'1',

            ],
        );
    }
}
