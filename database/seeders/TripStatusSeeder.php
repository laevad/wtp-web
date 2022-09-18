<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TripStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('trip_statuses')->insert(
            [
                ['id'=>1,'name'=>'Yet to Start'],
                ['id'=>2,'name'=>'Completed'],
                ['id'=>3,'name'=>'Ongoing'],
                ['id'=>4,'name'=>'Cancelled'],

            ],
        );
    }
}
