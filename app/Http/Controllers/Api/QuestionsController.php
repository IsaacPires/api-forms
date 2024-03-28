<?php

namespace App\Http\Controllers\API;

use App\Helpers\VerifyUserForm;
use App\Http\Controllers\Controller;
use App\Models\Limiters;
use Illuminate\Http\Request;
use App\Models\Questions;
use Illuminate\Validation\ValidationException;

class QuestionsController extends Controller
{

    private $VerifyUserForm;

    public function __construct(Limiters $limit) {
        $this->VerifyUserForm = new VerifyUserForm($limit);
    }

    public function index()
    {   
        $formsId = $this->VerifyUserForm->verifyUser();

        $questions = Questions::whereIn('idForm', $formsId)->paginate(10);
        return response()->json($questions, 200);
    }

    public function show($id)
    {
        $question = Questions::find($id);

        if (!$question) {
            return response()->json(['message' => 'Pergunta não encontrada'], 404);
        }

        $form = $this->VerifyUserForm->formByUser($question->idForm);

        if (!$form) {
            return response()->json(['message' => 'Formulário não encontrado.'], 404);
        }

        return response()->json(['question' => $question ], 200);
    }

    public function store(Request $request)
    {  
        try {
            $request->validate([
                '*.question'     => 'required|string|max:250',
                '*.idType_answer'=> 'required|integer',
                '*.idForm'       => 'required|integer',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }

        $form = $this->VerifyUserForm->formByUser($request['0']['idForm'] ?? null);
    
        if (!$form) {
            return response()->json(['message' => 'Formulário não encontrado.'], 404);
        }
    
        $questions = collect($request->all())->map(function ($questionData) {
            return Questions::create($questionData);
        });
    
        return response()->json($questions, 201);
    }
    

}
