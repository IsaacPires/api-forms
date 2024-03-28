<?php

namespace App\Listeners;

use App\Mail\formCreated;
use App\Models\Answers;
use App\Models\Forms;
use App\Models\Questions;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class emailToUser
{
    public $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    /**
     * Handle the event.
     */
    public function handle(): void
    {  
        $result = Questions::find($this->request->idQuestion);

        $countQuestions= Questions::where('idForm', $result->idForm)->count();
        $countAnswers= Answers::where('idClient', $this->request->idClient)->count();

        if($countQuestions == $countAnswers){

            $form = Forms::where('id', $result->idForm)->first();
            $user = User::where('id', $form->idUser)->first();
            $email = new formCreated();
            Mail::to($user->email)->send($email);
        }
    }
}
