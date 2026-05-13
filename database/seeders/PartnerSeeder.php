<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        $partners = [];

        for ($i = 0; $i < 5; $i++) {
            $partners[] = [
                'name' => $faker->company(),
                'logo_url' => 'https://placehold.co/200x200?text=' . urlencode($faker->word()),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('partners')->insert($partners);
    }
}
