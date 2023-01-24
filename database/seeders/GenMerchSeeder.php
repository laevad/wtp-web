<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GenMerchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*add multiple name */
        $names = [
            'del monte products',
            'kopiko products',
            'Nissin products','Nestle products'
        ];

        foreach ($names as $name){
            \App\Models\GenMerch::create([
                'name' => $name
            ]);
        }

    }
}
