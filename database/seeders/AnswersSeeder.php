<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Answers;
use App\Models\Question;
use App\Models\Form;
use App\Models\Forms;
use App\Models\Questions;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AnswersSeeder extends Seeder
{


    public function run()
    {

        $form = DB::table('forms')->skip(200)->take(1)->first();

        if (!$form) {
            $this->command->info('Formulário não encontrado na posição 201.');
            return;
        }

        $questions = DB::table('questions')->where('idForm', $form->id)->get();

        for ($i = 0; $i < 100000; $i += 2) {
            $clientId = $i + 1; 

            DB::table('answers')->insert([
                'answer' => 'Resposta do cliente ' . $clientId . ' para pergunta 1',
                'idQuestion' => $questions[0]->id,
                'idForm' => $form->id,
                'idClient' => $clientId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('answers')->insert([
                'answer' => 'Resposta do cliente ' . $clientId . ' para pergunta 2',
                'idQuestion' => $questions[1]->id,
                'idForm' => $form->id,
                'idClient' => $clientId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } 

        /* 2.000.000 de respostas  */

        $forms = DB::table('forms')->take(200)->get();

        foreach ($forms as $form) {
            $questions = DB::table('questions')->where('idForm', $form->id)->get();

            if ($questions->count() != 2) {
                $this->command->info('O formulário ' . $form->id . ' não possui exatamente 2 perguntas associadas.');
                continue;
            }

            for ($i = 0; $i < 10000; $i += 2) {
                $clientId = $i + 10; 

                DB::table('answers')->insert([
                    'answer' => 'Resposta do cliente ' . $clientId . ' para pergunta 1 do formulário ' . $form->id,
                    'idQuestion' => $questions[0]->id,
                    'idForm' => $form->id,
                    'idClient' => $clientId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                DB::table('answers')->insert([
                    'answer' => 'Resposta do cliente ' . $clientId . ' para pergunta 2 do formulário ' . $form->id,
                    'idQuestion' => $questions[1]->id,
                    'idForm' => $form->id,
                    'idClient' => $clientId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}