<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class APISeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('api_keys')->insert(
            [
                [
                    'id'=>Uuid::uuid3(Uuid::NAMESPACE_DNS, 'apikey')->toString(),
                    'name'=>env('API_KEY')
                ],

            ],
        );
    }
}
