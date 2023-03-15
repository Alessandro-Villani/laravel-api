<?php

namespace Database\Seeders;

use App\Models\Technology;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TechnologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $technologies = [
            ['name' => 'HTML', 'icon' => '<i class="fa-brands fa-html5"></i>', 'color' => '#F75421'],
            ['name' => 'CSS', 'icon' => '<i class="fa-brands fa-css3-alt"></i>', 'color' => '#2091EB'],
            ['name' => 'JavaScript', 'icon' => '<i class="fa-brands fa-js"></i>', 'color' => '#F7D800'],
            ['name' => 'VueJS', 'icon' => '<i class="fa-brands fa-vuejs"></i>', 'color' => '#3FB27F'],
            ['name' => 'PHP', 'icon' => '<i class="fa-brands fa-php"></i>', 'color' => '#7377AD'],
            ['name' => 'SQL', 'icon' => '<i class="fa-solid fa-database"></i>', 'color' => '#F7AC00'],
            ['name' => 'Laravel', 'icon' => '<i class="fa-brands fa-laravel"></i>', 'color' => '#E83A2D'],
            ['name' => 'Bootstrap', 'icon' => '<i class="fa-brands fa-bootstrap"></i>', 'color' => '#8411F6']
        ];

        foreach ($technologies as $technology) {
            $new_tech = new Technology();
            $new_tech->name = $technology['name'];
            $new_tech->icon = $technology['icon'];
            $new_tech->color = $technology['color'];
            $new_tech->save();
        }
    }
}
