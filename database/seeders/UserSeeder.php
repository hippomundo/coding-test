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
            'profile_picture_url' => '/img/lukeskywalker.jpg',
            'email' => 'Farmboy2Jedi@TheForce.net',
        ]);
        User::factory()->create([
            'name' => 'Princess Leia Organa', 
            'profile_picture_url' => '/img/princessleiaorgana.jpg',
            'email' => 'RebelLeaderInHeels@GalaxyMail.com',
        ]);
        User::factory()->create([
            'name' => 'Han Solo', 
            'profile_picture_url' => '/img/hansolo.webp',
            'email' => 'KesselRunRecordHolder@FalconMail.com',
        ]);
        User::factory()->create([
            'name' => 'Darth Vader', 
            'profile_picture_url' => '/img/darthvader.webp',
            'email' => 'BreathingIsComplicated@DarkSide.net',
        ]);
        User::factory()->create([
            'name' => 'Chewbacca', 
            'profile_picture_url' => '/img/chewbacca.jpg',
            'email' => 'HairyHero@WookieeWorld.com',
        ]);
    }
}
