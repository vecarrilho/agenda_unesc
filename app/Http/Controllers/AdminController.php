<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreUpdateSalaFormRequest;
use App\Models\Polo;
use App\Models\Sala;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('welcome');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createSala()
    {
        $polos = Polo::exibicao()->get();

        return view('admin.create.sala', ['polos' => $polos]);
    }

    public function createPolo()
    {
        return view('admin.create.polo');
    }

    public function createExport()
    {

        return view('admin.create.export');
    }

    public function searchExport()
    {
        $cadastro = Cadasrto::find(Auth::cadastro()->id);

        //captura valores dos filtros
        if(request('data')){
            $dataFilter = request('data');
        }else{
            $dataFilter = session('data');
        }

        //adiciona os valores do filtro em uma sessão
        session(['data' => $dataFilter]);

        if ($dataFilter) {
                $salas = Sala::joinPolos()->data($dataFilter)->orderByData()->get();
            }else{
                $salas = Sala::exibicao()->orderByData()->get();
            }

         //formata data e hora
         for ($i=0; $i < count($salas); $i++) { 
            $salas[$i]->hour_formated = $salas[$i]->hora;
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeSala(Request $request)
    {
        // $sala = new Sala;
        // $sala->bloco = $request->bloco;
        // $sala->nsala = $request->nsala;
        // $sala->qtd_maquinas = $request->qtd_maquinas;
        // $sala->hora = $request->hora;
        // $sala->data = $request->data;
        // $sala->save();
        $data = $request->all();
        $data['qtd_maquinas_original'] = $request->qtd_maquinas;

        Sala::create($data);

        return redirect()->route('admin.createSala')->with('msg-success', 'Sala cadastrada com sucesso!');

    }

    public function storePolo(Request $request)
    {
        $data = $request->all();
        $data['status'] = 'Ativo';

        Polo::create($data);

        return redirect()->route('admin.createPolo')->with('msg-success', 'Polo cadastrado com sucesso!');

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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
