<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;
use App\Models\User;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $project = Project::find(9);

        User::factory()
        ->count(50)
        ->hasAttached(
            $project
        )
        ->create();
    }
}
