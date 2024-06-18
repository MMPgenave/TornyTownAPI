<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Ranks;
use Database\Factories\RankFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

//        $RankDetails = [
//
//        ];
//        foreach ( $RankDetails as $rankDetail) {
//            Ranks::create([
//                'Name' => $rankDetail['Name'],
//                'Xp' => $rankDetail['XP'],
//                'Rewards' => $rankDetail['Rewards'],
//                'Icon' => $rankDetail['Icon'],
//            ]);
//        }
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
