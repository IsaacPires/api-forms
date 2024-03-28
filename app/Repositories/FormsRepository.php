<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FormsRepository
{

  public function CountForms(){

    $user = Auth::user();

    return DB::table('forms')
    ->select('forms.id', 'forms.title', DB::raw('COUNT(DISTINCT answers.idClient) as total_responded'))
    ->leftJoin('questions', 'forms.id', '=', 'questions.idForm')
    ->leftJoin('answers', 'questions.id', '=', 'answers.idQuestion')
    ->where('forms.idUser', $user->id)
    ->groupBy('forms.id', 'forms.title')
    ->paginate(10);

  }

  public function compiled($id){
    
    $questions = DB::table('questions')
    ->where('idForm', $id)
    ->orderBy('id')
    ->get()
    ->keyBy('id')
    ->toArray();
   
  $clientAnswers = DB::table('answers')
      ->select('idClient', 'idQuestion', 'answer')
      ->where('idForm', $id)
      ->get()
      ->groupBy('idClient')
      ->map(function ($answers) {
          return $answers->mapWithKeys(function ($answer) {
              return [$answer->idQuestion => $answer->answer ?? ''];
          });
      })
      ->toArray();

      return [$clientAnswers, $questions];
  }

  public function deleteAll($question, $answers, $form)
  { 

    $questions =  $question::where('idForm', $form->id)->get();

    if($questions)
    {
        $question::where('idForm', $form->id)->delete();
    }

    $answers =  $answers::where('idForm', $form->id)->get();

    if($questions)
    {
        $question::where('idForm', $form->id)->delete();
    }

    $form->delete();

  }


}