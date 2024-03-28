<?php

namespace App\Helpers;

use App\Models\Answers;
use App\Models\Forms;
use App\Models\Limiters;
use Illuminate\Support\Facades\Auth;

class VerifyUserForm
{

  private $limit;

  public function __construct( Limiters $limit) {
    $this->limit = $limit;
  }

  public function formByUser(int $id)
  {
    $user = Auth::user();

    $form = Forms::where('idUser', $user->id)->where('id', $id)->first();

    return $form;

  }

  public function verifyUser(){
    
    $user =  Auth::user();
    return Forms::where('idUser', $user->id)->pluck('id');
  }

  public function verifyCountUser($request)
  {

    $form = Forms::where('id', $request->idForm)->first();

    if(!$form){
        return response()->json('Formulário não encontrado', 403);
    }

    $answer = Answers::where('idClient', $request->idClient)
    ->where('idForm', $request->idForm)
    ->first();

    $limiter = Limiters::where('idUser', $form->idUser)
    ->where('idForm', $request->idForm)
    ->whereYear('created_at', '=', date('Y'))
    ->whereMonth('created_at', '=', date('m'))
    ->first();

    if(empty($limiter)){
        $this->limit->consumption = 1;
        $this->limit->idForm = $request->idForm;
        $this->limit->idUser = $form->idUser;
        $this->limit->save();       
    }

    
    if(!empty($limiter) && empty($answer)){

        $sumConsumption = Limiters::selectRaw('sum(consumption) as currentUse')
        ->where('idUser', $form->idUser)
        ->whereYear('created_at', '=', date('Y'))
        ->whereMonth('created_at', '=', date('m'))
        ->groupBy('idUser')
        ->first();

        if($sumConsumption->currentUse >= 100){
            return response()->json('Limite de respostas do mês atingido.', 429);
        }

        $limiter->consumption += 1;
        $limiter->save();

    }
  }
   
}
