<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sala;
use App\Models\Cadastro;

class AgendaController extends Controller
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
    public function create()
    {
        return view('agenda.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $salas = Sala::all();
        return view('agenda.show', ['salas' => $salas]);
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

    public function search(){
        $data = request('data');
        $hora = request('hora');

        if ($data) {
            if($hora){
                $salas = Sala::where([
                    ['data', $data],
                    ['hora', date('H:i:s', strtotime($hora))]
                ])->get();
            }else{
                $salas = Sala::where([
                    ['data', ($data)]
                ])->get();
            }
        }elseif($hora){
            $salas = Sala::where([
                ['hora', date('H:i:s', strtotime($hora))]
            ])->get();
        }else{
            $salas = Sala::all();
        }
        
        return view('agenda.show',['salas' => $salas]);
    }

    public function insert_cadastro($id_sala, $id_aluno){

        $cadastro = new Cadastro;

        $cadastro->id_usuario = $id_aluno;
        $cadastro->id_sala = $id_sala;

        $cadastro->save();

        $salas = Sala::findOrFail($id_sala);

        // if($salas->qtd_maquinas>0){
        //     $salas->qtd_maquinas--;
        // }else{
        //     $salas->qtd_maquinas = 0;
        // }

        // $salas->save();

        $salas = Sala::all();

        return view('agenda.show', ['salas' => $salas]);
    }
}
