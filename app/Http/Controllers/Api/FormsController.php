<?php

namespace App\Http\Controllers\API;

use App\Helpers\VerifyUserForm;
use App\Http\Controllers\Controller;
use App\Models\Answers;
use App\Models\Forms;
use App\Models\Questions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Repositories\FormsRepository;

class FormsController extends Controller
{

    private $VerifyUserForm;
    private $formRepository;

    public function __construct( VerifyUserForm $VerifyUserForm, FormsRepository $formRepository )
    {
        $this->VerifyUserForm = $VerifyUserForm;
        $this->formRepository = $formRepository;

    }

    public function index()
    {
        $formsWithCount = $this->formRepository->CountForms();

        if (!$formsWithCount) {
            return response()->json(['message' => 'Formulário não encontrado'], 404);
        }

        return response()->json($formsWithCount, 200);
    } 

    //retorna formulários com perguntas e respostas
    public function formsAndAnswers($id)
    { 
      
        [$clientAnswers, $questions] = $this->formRepository->compiled($id);

        if(empty($clientAnswers) && empty($questions)){
            return response()->json( ['message' =>'Nenhuma pergunta cadastrada para este formulário.'], 400);
        }

        $format = $this->formatForm($clientAnswers, $questions);
        
        return response()->json($format, 200);
    }
    
 
    public function store(Request $request, Forms $form)
    {   
        $user = Auth::user();

        try{
            $request->validate([
                'title' => 'required|string|max:50',
                'idStyle' => 'required|integer'
            ]);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }

        $form->title = $request->title;
        $form->idStyle = $request->idStyle;
        $form->idUser = $user->id;
        
        if($form->save()){
            return response()->json($form, 201);
        }
    }

    public function destroy($id, Questions $question, Answers $answers)
    {   
        $form = $this->VerifyUserForm->formByUser($id);

        if(!$form){
            return response()->json(['message' => 'Falha ao encontrar formulário.'], 400);
        }

        $this->formRepository->deleteAll($question, $answers, $form);


        return response()->json('Formulário excluído com sucesso', 204);

    }

    public function update(Request $request, $id)
    {  
        $form = $this->VerifyUserForm->formByUser($id);
       
        if(!$form){
            return response()->json(['message' => 'Falha ao encontrar formulário.'], 400);
        }

        $form->update($request->all());

        return response()->json(['message' => 'Formulário atualizado com sucesso', 'form' => $form]);
    }


    private function formatForm($clientAnswers, $questions)
    {
        //a lógica implementada não permitiu que eu utilizasse o paginate do laravel
        $page = 1;
        if(!empty($_GET['page'])){
            $page = $_GET['page'];
        }
        $limit = 10;
        if(!empty($_GET['limit'])){
            $limit = $_GET['limit'];
        }

        $showAll = false;
        if(!empty($_GET['showAll'])){
            $showAll = $_GET['showAll'];
        }

        $maxQuestionCount = count($questions);

        $formatado = [];
        $startIndex = ($page - 1) * $limit;


        foreach ($clientAnswers as $idClient => $answers) {
            $answeredAll = ($maxQuestionCount === count(array_filter($answers)));
    
            if (!$showAll && !$answeredAll) {
                continue;
            }
    
            $formatado[$idClient] = [
                'idClient' => $idClient,
                'respostas' => [],
            ];
    
            foreach ($questions as $question) {
                $formatado[$idClient]['respostas'][] = [
                    'pergunta' => $question->question,
                    'resposta' => $answers[$question->id] ?? '',
                ];
            }
        }

        $paginatedResult = array_slice($formatado, $startIndex, $limit);
    
        return $paginatedResult;
    }
    
    
    
}
