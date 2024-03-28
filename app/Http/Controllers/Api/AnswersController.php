<?php

namespace App\Http\Controllers\API;

use App\Events\emailToUser;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Answers;
use App\Helpers\VerifyUserForm;
use App\Models\Limiters;
use Illuminate\Validation\ValidationException;


class AnswersController extends Controller
{
    private $VerifyUserForm;

    public function __construct(Limiters $limit) {
        $this->VerifyUserForm = new VerifyUserForm($limit);
    }
 
    public function store(Request $request)
    {
        try{
            $request->validate([
                'answer' => 'required|string|max:255',
                'idQuestion' => 'required|integer',
                'idClient' => 'required|integer',
                'idForm' => 'required|integer',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }

        $verify = $this->VerifyUserForm->verifyCountUser($request);

        if($verify){
            return response()->json(['return'=>$verify->original], 201);
        }
        
        $answers = Answers::create($request->all());

        emailToUser::dispatch($request);
        
        return response()->json(['return'=>$answers], 201);
    }


}
