<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipamento;
use App\Http\Requests\EquipamentoFormRequest;

class EquipamentosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
            $equipamentos = Equipamento::all();
            return view('equipamentos.index', compact('equipamentos') );
     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!session()->has('redirect_to'))
        {
           session(['redirect_to' => url()->previous()]);
        }
        return view('equipamentos.create', ['action'=>route('equipamento.store'), 'method'=>'post']);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EquipamentoFormRequest $request)
    {
        //
        if (! $request->has('cancel') ){
            $dados = $request->all();
            Equipamento::create($dados);
            $request->session()->flash('message', 'Cadastrado com sucesso');
        }
        else
        { 
            $request->session()->flash('message', 'Operação cancelada pelo usuário'); 
        }
        return redirect()->to(session()->pull('redirect_to'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Equipamento $equipamento, EquipamentoFormRequest $request)
    {   
    if (! $request->has('cancel') ){
        $equipamento->tipo = $request->input('tipo');
        $equipamento->modelo = $request->input('modelo');
        $equipamento->fabricante = $request->input('fabricante');
        $equipamento->update();
        $request->session()->flash('message', 'Atualizado com sucesso !');
    }
    else
    { 
        $request->session()->flash('message', 'Operação cancelada pelo usuário'); 
    }
    return redirect()->to(session()->pull('redirect_to'));
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Equipamento $equipamento, Request $request)
    {
        if (! $request->has('cancel') ){
            $strEqp = $equipamento->tipo . ', modelo: ' . $equipamento->modelo . ', fabricante:' . $equipamento->fabricante . '}';
            $equipamento->delete();
            $request->session()->flash('message', 'Excluído com sucesso !');
        }
        else
        { 
            $request->session()->flash('message', 'Operação cancelada pelo usuário'); 
        }
        return redirect()->to(session()->pull('redirect_to'));
    }
}
