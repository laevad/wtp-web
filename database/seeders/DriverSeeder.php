<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class DriverSeeder extends GlobalSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1;$i<10;$i++){
            $fName = fake()->name();
            DB::table('users')->insert([
                [
                    'id'=>Uuid::uuid4()->toString(),
                   'name' => $fName,
                    'email' => fake()->safeEmail(),
                    'email_verified_at' => now(),
                    'password' => bcrypt('1234'), // password
                    'remember_token' => Str::random(10),
                    'role_id'=>User::ROLE_DRIVER,
                    'mobile'=> fake()->numerify('###########'),
                    'date_of_birth'=> now()->toFormattedDate(),
                    'age'=> 18,
                    'license_number'=> fake()->numerify('####'),
                    'total_experience'=> fake()->numerify('#'),
                    'license_expiry_date'=> now()->toFormattedDate(),
                    'date_of_joining'=> now()->toFormattedDate(),
                    'status_id'=> 1,
                    'address'=>'CDO',
                    'avatar' => $this->setInitialPhoto($fName[0]),
                ]
            ]);
        }
    }
}
