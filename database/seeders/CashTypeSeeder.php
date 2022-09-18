<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CashTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cash_types')->insert(
            [
                ['id'=>1,'name'=>'Expense'],
                ['id'=>2,'name'=>'Incentive'],
            ],
        );
    }
}
