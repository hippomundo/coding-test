<?php

namespace Database\Seeders;

use App\Models\Phase;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PhaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Phase::factory()
            ->count(5)
            ->sequence(
                ['name' => 'Backlog'],
                ['name' => 'To Do'],
                ['name' => 'Doing'],
                ['name' => 'Done'],
                ['name' => 'Archived'],)
            ->create();
    }
}
