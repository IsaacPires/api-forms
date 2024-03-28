<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\multiple_choices;
use Illuminate\Validation\ValidationException;

class multiple_choicesController extends Controller
{

    public function store(Request $request)
    {   
        try {
            $request->validate([
                '*.choices'     => 'required|string',
                '*.idQuestion'  => 'required|integer',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }

        $choices = [];
        foreach ($request->all() as $data) {
            $choices[] = multiple_choices::create($data);
        }

        return response()->json($choices, 201);
    }


    
    public function destroy($id)
    {
        $multiple_choices = multiple_choices::find($id);

        if (empty($multiple_choices)) {
            return response()->json(['message' => 'Alternativas não encontradas'], 404);
        }

        $multiple_choices->delete();

        return response()->json(['message' => 'Formulário excluído com sucesso'], 204 );
    }


    public function show(int $idQuestion)
    {   
        $multiple_choices = multiple_choices::where('idQuestion', $idQuestion)->paginate(10);

        if ($multiple_choices->isEmpty()) {
            return response()->json(['message' => 'Alternativas não encontradas'], 404);
        }
    
        return response()->json(['questions' => $multiple_choices], 200);
    }

    
}
