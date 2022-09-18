<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=1;$i<15;$i++){
            DB::table('vehicles')->insert([
                [
                    'id'=>Uuid::uuid3(Uuid::NAMESPACE_DNS, $i)->toString(),
                    'name' => fake()->name(),
                    'model' => fake()->name(),
                    'registration_number'=> fake()->numerify('####'),
                    'chassis_no'=> fake()->numerify('#####'),
                    'engine_no'=> fake()->numerify('#####'),
                    'manufactured_by'=> fake()->company(),
                    'registration_expiry_date'=> now()->toFormattedDate(),
                    'status'=> 'inactive',
                ]
            ]);
        }
    }
}
