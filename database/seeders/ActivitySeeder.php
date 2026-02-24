<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Activity;

class ActivitySeeder extends Seeder
{
    public function run(): void
    {
        Activity::create([
            'title' => 'Yoga du matin',
            'description' => 'Séance de yoga pour bien commencer la journée.',
            'activity_date' => '2026-03-10',
            'activity_time' => '08:00:00',
            'max_participants' => 15,
            'points_cost' => 20,
        ]);

        Activity::create([
            'title' => 'Atelier cuisine',
            'description' => 'Apprenez à cuisiner des plats sains et équilibrés.',
            'activity_date' => '2026-03-12',
            'activity_time' => '12:00:00',
            'max_participants' => 10,
            'points_cost' => 30,
        ]);

        Activity::create([
            'title' => 'Randonnée en forêt',
            'description' => 'Balade de 5km en pleine nature.',
            'activity_date' => '2026-03-15',
            'activity_time' => '09:00:00',
            'max_participants' => 20,
            'points_cost' => 15,
        ]);
    }
}