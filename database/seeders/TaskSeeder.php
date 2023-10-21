<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Phase;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Task::factory()
            ->count(3)
            ->sequence(
                ['name' => 'Try not to lose your lightsaber this time.'],
                ['name' => 'Attend a rebel strategy meeting and avoid dozing off.'],
                ['name' => 'Convince Yoda to give you a day off from Jedi training.'],
            )
            ->state(new Sequence(
                fn (Sequence $sequence) => [ 
                    'user_id' => User::whereName('Luke Skywalker')->first()->id, 
                    'phase_id' => Phase::all()->random() 
                ],
            ))
            ->create();

            \App\Models\Task::factory()
            ->count(3)
            ->sequence(
                ['name' => 'Negotiate with potential allies without rolling your eyes.'],
                ['name' => 'Brief Rebel spies without revealing your secret crush on Han.'],
                ['name' => 'Try diplomacy with planets that still think Jar Jar is funny.'],
            )
            ->state(new Sequence(
                fn (Sequence $sequence) => [ 
                    'user_id' => User::whereName('Princess Leia Organa')->first()->id, 
                    'phase_id' => Phase::all()->random() 
                ],
            ))
            ->create();

        \App\Models\Task::factory()
            ->count(3)
            ->sequence(
                ['name' => 'Fix the Falcon\'s hyperdrive (again).'],
                ['name' => 'Outsmart Imperial patrols while smuggling space \'stuff.\''],
                ['name' => 'Remind Chewie to lower the ship\'s thermostat – It\'s not Hoth in here!'],
            )
            ->state(new Sequence(
                fn (Sequence $sequence) => [ 
                    'user_id' => User::whereName('Han Solo')->first()->id, 
                    'phase_id' => Phase::all()->random() 
                ],
            ))
            ->create();

        \App\Models\Task::factory()
            ->count(3)
            ->sequence(
                ['name' => 'Hunt Rebel spies and resist force-choking them.'],
                ['name' => 'Attend a meeting with Palpatine without yawning audibly.'],
                ['name' => 'Attend Sith sensitivity training session to work on your anger management.'],
            )
            ->state(new Sequence(
                fn (Sequence $sequence) => [ 
                    'user_id' => User::whereName('Darth Vader')->first()->id, 
                    'phase_id' => Phase::all()->random() 
                ],
            ))
            ->create();

        \App\Models\Task::factory()
            ->count(3)
            ->sequence(
                ['name' => 'Keep the Falcon from falling apart mid-hyperspace jump.'],
                ['name' => 'Help Han escape a bounty hunter ambush without roaring too much.'],
                ['name' => 'Book Wookiee vocal lessons – surprise opera performance for Han.'],
            )
            ->state(new Sequence(
                fn (Sequence $sequence) => [ 
                    'user_id' => User::whereName('Chewbacca')->first()->id, 
                    'phase_id' => Phase::all()->random() 
                ],
            ))
            ->create();
    }
}
