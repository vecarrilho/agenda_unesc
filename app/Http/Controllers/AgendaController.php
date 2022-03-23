<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sala;
use App\Models\Cadastro;
use Illuminate\Support\Facades\DB;

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
        $dataAtual = date('Y-m-d');
        $salas = Sala::where([
            ['data', '>=', $dataAtual]
        ])->get();

        foreach($salas as $sala){
            $cadastros[$sala->id] = Cadastro::where('id_sala',$sala->id)->count();
        }
        
        return view('agenda.show', ['salas' => $salas, 'cadastros' => $cadastros]);
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
        DB::table('cadastros')->where('id_usuario', $id)->delete();
        return redirect('agenda');
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
        foreach($salas as $sala){
            $cadastros[$sala->id] = Cadastro::where('id_sala',$sala->id)->count();
        }

        
        return view('agenda.show',['salas' => $salas, 'cadastros' => $cadastros]);
    }

    public function insert_cadastro($id_sala, $id_aluno){

        // $cadastro = Cadastro::all();

        $salas = Sala::findOrFail($id_sala);

        $maquinas_reservadas = Cadastro::where('id_sala',$salas->id)->count();

        if($salas->qtd_maquinas != $maquinas_reservadas){
            $cadastro = new Cadastro;

            $cadastro->id_usuario = $id_aluno;
            $cadastro->id_sala = $id_sala;
    
            $cadastro->save();

            return redirect('agenda')->with('msg-success', 'Prova agendada com sucesso!');
        }else{
            return redirect('agenda')->with('msg-error', 'Máquinas insuficientes para esta data!');
        }
    }
    
    public function show_my_list($id_aluno){
        
        $cadastros = DB::table('cadastros')
                    ->join('salas', 'salas.id', '=', 'cadastros.id_sala')
                    ->select('salas.id', 'salas.bloco', 'salas.hora', 'salas.data')->get();
        return view('agenda.myList', ['cadastros' => $cadastros]);
    }
}
