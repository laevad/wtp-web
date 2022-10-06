<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class ClientSeeder extends GlobalSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i<10; $i++){
            $fName = fake()->name();
            DB::table('users')->insert([
                [
                    'id'=>Uuid::uuid3(Uuid::NAMESPACE_DNS, $i)->toString(),
                    'name' => $fName,
                    'email' => fake()->safeEmail(),
                    'email_verified_at' => null,
                    'password' => bcrypt('1234'), // password
                    'remember_token' => Str::random(10),
                    'created_at'=>now(),
                    'role_id'=> User::ROLE_CLIENT,
                    'mobile' =>fake()->numerify('###########'),
                    'status_id'=> 1,
                    'avatar' => $this->setInitialPhoto($fName[0]),
                ]
            ]);
        }
    }


}
