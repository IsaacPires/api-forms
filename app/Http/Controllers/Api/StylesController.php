<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Styles;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class StylesController extends Controller
{
    public function index()
    {
        $styles = Styles::paginate(10);
        return response()->json($styles, 200);
    }

    public function store(Request $request)
    {
        try{
            $request->validate([
                'color'     => 'required|string',
                'Typography' => 'required|string'
            ]);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }

        $styles = Styles::create($request->all());

        return response()->json($styles, 201);
    }

}
