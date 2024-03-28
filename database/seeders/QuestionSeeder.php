<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $forms = DB::table('forms')->get();

        foreach ($forms as $form) {
            $formId = $form->id;

            
            for ($i = 1; $i <= 2; $i++) {
                DB::table('questions')->insert([
                    'question' => 'Pergunta ' . $i . ' para formulário ' . $formId,
                    'idType_answer' => 1,
                    'idForm' => $formId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
