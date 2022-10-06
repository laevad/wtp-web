<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehicleStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('vehicle_statuses')->insert(
            [
                ['id'=>1,'name'=>'active'],
                ['id'=>2,'name'=>'inactive'],
                ['id'=>3,'name'=>'maintenance'],
            ],
        );
    }
}
