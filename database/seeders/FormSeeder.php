<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $users = User::first();

        for ($i = 1; $i <= 200; $i++) {
            DB::table('forms')->insert([
                'title' => 'Formulário ' . $i . ' para usuário 1',
                'idStyle' => 1, 
                'idUser' => $users->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $otherUser = User::where('id', '!=', $users->id)->first();

        DB::table('forms')->insert([
            'title' => 'Formulário para usuário ' . $otherUser->id,
            'idStyle' => 1,
            'idUser' => $otherUser->id, 
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        
    }
}
