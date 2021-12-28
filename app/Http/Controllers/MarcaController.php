<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;

class MarcaController extends Controller
{

    public function __construct(Marca $marca)
    {
        $this->marca = $marca;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$marca = Marca::all();
        $marcas = $this->marca->all();
        return response()->json($marcas, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //$marca =Marca::create($request->all());
        //validando parametros nome e imagem
        $regras = [
            'nome' => 'required|unique:marcas',
            'imagem' => 'required'
        ];

        $feedback = [
            'required' => 'O campo é obrigatório',
            'nome.unique' => 'O nome da marca já existe'
        ];

        $request->validate($regras, $feedback);

        $marca = $this->marca->create($request->all());
         return response()->json($marca, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        /*
        // *******************Forma mais extensa***********************

        $marcaId = Marca::find($marca);
        return $marcaId;
        */

        //forma mais simples
        $marca = $this->marca->find($id);

        if ($marca == '') {
            return response()->json(['erro' => 'recurso pesquisado não existe'], 404);
        }else {
            return  response()->json($marca, 200);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function edit(Marca $marca)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       $marca = $this->marca->find($id);
       if ($marca == '') {
           return response()->json(['erro' => 'Essa marca não existe, impossivel atualizar'], 404);
       }else{
        $marca->update($request->all());
            return response()->json($marca, 200);
       }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Marca  $marca
     * @return \Illuminate\Http\Responses
     */
    public function destroy($id)
    {
        $marca = $this->marca->find($id);
        if ($marca == '') {
            return response()->json(['Essa marca não existe ou já foi deletada'], 404);
        }else{
            $marca->delete();
            return response()->json(['msg' => 'Marca deletada'],200); 
        }
    }
}
