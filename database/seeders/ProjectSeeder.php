<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        for ($i = 0; $i < 5; $i++) {
            $project = new Project();
            $project->name = $faker->words(3, true);
            $project->description = $faker->paragraphs(10, true);
            $project->project_url = $faker->url();
            $project->image_url = $faker->imageUrl(200, 200);
            $project->save();
        }
    }
}
