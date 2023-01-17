<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class IncentiseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*multiple insert*/
        \App\Models\Incentise::insert([
            [
                'id'=>Uuid::uuid3(Uuid::NAMESPACE_DNS, "in.1")->toString(),
                'name' => 'Davao',
                'amount' => 300
            ],
            [
                'id'=>Uuid::uuid3(Uuid::NAMESPACE_DNS, "in.2")->toString(),
                'name' => 'Koronadal',
                'amount' => 320
            ],
            [
                'id'=>Uuid::uuid3(Uuid::NAMESPACE_DNS, "in.3")->toString(),
                'name' => 'Gensan',
                'amount' => 350
            ],
            [
                'id'=>Uuid::uuid3(Uuid::NAMESPACE_DNS, "in.4")->toString(),
                'name' => 'Surigao',
                'amount' => 360
            ],
            [
                'id'=>Uuid::uuid3(Uuid::NAMESPACE_DNS, "in.5")->toString(),
                'name' => 'Tandag',
                'amount' => 400
            ],
            [
                'id'=>Uuid::uuid3(Uuid::NAMESPACE_DNS, "in.6")->toString(),
                'name' => 'Prosperidad',
                'amount' => 410
            ],
            [
                'id'=>Uuid::uuid3(Uuid::NAMESPACE_DNS, "in.7")->toString(),
                'name' => 'Bad-as',
                'amount' => 415
            ],
            [
                'id'=>Uuid::uuid3(Uuid::NAMESPACE_DNS, "in.8")->toString(),
                'name' => 'Bislig',
                'amount' => 415
            ],
            [
                'id'=>Uuid::uuid3(Uuid::NAMESPACE_DNS, "in.9")->toString(),
                'name' => 'Ipil',
                'amount' => 350
            ],
            [
                'id'=>Uuid::uuid3(Uuid::NAMESPACE_DNS, "in.10")->toString(),
                'name' => 'Dipolog',
                'amount' => 300
            ],
            [
                'id'=>Uuid::uuid3(Uuid::NAMESPACE_DNS, "in.11")->toString(),
                'name' => 'Sindangan',
                'amount' => 300
            ],
            [
                'id'=>Uuid::uuid3(Uuid::NAMESPACE_DNS, "in.12")->toString(),
                'name' => 'Dapitan',
                'amount' => 275
            ],
            [
                'id'=>Uuid::uuid3(Uuid::NAMESPACE_DNS, "in.13")->toString(),
                'name' => 'Ozamis',
                'amount' => 300
            ],
            [
                'id'=>Uuid::uuid3(Uuid::NAMESPACE_DNS, "in.14")->toString(),
                'name' => 'Tangub',
                'amount' => 310
            ],
            [
                'id'=>Uuid::uuid3(Uuid::NAMESPACE_DNS, "in.15")->toString(),
                'name' => 'Butuan',
                'amount' => 300
            ],
            [
                'id'=>Uuid::uuid3(Uuid::NAMESPACE_DNS, "in.16")->toString(),
                'name' => 'Cabadbaran',
                'amount' => 320
            ],
            [
                'id'=>Uuid::uuid3(Uuid::NAMESPACE_DNS, "in.17")->toString(),
                'name' => 'Bayugan',
                'amount' => 300
            ],
            [
                'id'=>Uuid::uuid3(Uuid::NAMESPACE_DNS, "in.18")->toString(),
                'name' => 'Buenavista',
                'amount' => 340
            ],
            [
                'id'=>Uuid::uuid3(Uuid::NAMESPACE_DNS, "in.19")->toString(),
                'name' => 'Zamboanga',
                'amount' => 500
            ],
            [
                'id'=>Uuid::uuid3(Uuid::NAMESPACE_DNS, "in.20")->toString(),
                'name' => 'Valencia',
                'amount' => 250
            ],
            [
                'id'=>Uuid::uuid4()->toString(),
                'name' => 'Iligan',
                'amount' => 200
            ],
            [
                'id'=>Uuid::uuid4()->toString(),
                'name' => 'Gingoog',
                'amount' => 250
            ],
            [
                'id'=>Uuid::uuid4()->toString(),
                'name' => 'Balingasag',
                'amount' => 250
            ],
            [
                'id'=>Uuid::uuid4()->toString(),
                'name' => 'Manolo',
                'amount' => 200
            ],
            [
                'id'=>Uuid::uuid4()->toString(),
                'name' => 'Kapatagan',
                'amount' => 300
            ]
        ]);
    }
}
