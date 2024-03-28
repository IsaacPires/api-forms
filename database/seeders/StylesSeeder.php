<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StylesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $styles = [
            ['color' => 'white', 'Typography' => 'arial'],
            ['color' => 'black', 'Typography' => 'times new roman'],
        ];

        foreach ($styles as $style) {
            DB::table('styles')->insert([
                'color' => $style['color'],
                'Typography' => $style['Typography'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
