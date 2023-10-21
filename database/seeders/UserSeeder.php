<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Luke Skywalker', 
            'profile_picture_url' => 'https://pm1.aminoapps.com/5924/737bd84c6fb114bd64dd1910e91b3894f36aacb8_128.jpg'
        ]);
        User::factory()->create([
            'name' => 'Princess Leia Organa', 
            'profile_picture_url' => 'https://pm1.aminoapps.com/6450/508c35baab83b8e8ea9c9ee61c29ead1dfd9c118_128.jpg'
        ]);
        User::factory()->create([
            'name' => 'Han Solo', 
            'profile_picture_url' => 'https://lumiere-a.akamaihd.net/v1/images/dl-44-blaster-pistol_6f44d72b.jpeg?region=255%2C0%2C1050%2C1050'
        ]);
        User::factory()->create([
            'name' => 'Darth Vader', 
            'profile_picture_url' => 'https://www.jbhifi.com.au/cdn/shop/products/601131-Product-0-I-637980810183217329.jpg?v=1663119102'
        ]);
        User::factory()->create([
            'name' => 'Chewbacca', 
            'profile_picture_url' => 'https://pm1.aminoapps.com/5827/e8d12940426c11f92df2010bd0b579bbe97f2c9e_128.jpg'
        ]);
    }
}
