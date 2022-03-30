<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sala;
use App\Models\Cadastro;
use Illuminate\Support\Facades\Auth;

class AgendaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //redireciona para pagina inicial
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
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    //função p/ inserir dados na tabela cadastros
    public function store(Request $request)
    {
        //traz todos dados do form
        $data = $request->all();
        $data['id_usuario'] = Auth::user()->id;

        //verifica se o aluno ja esta cadastrado nesta sala
        $cadastros = Cadastro::verificaAgenda($data['id_usuario'], $data['id_sala'])->first();
        
        //verifica se o retorno é vazio
        if(empty($cadastros)){
            //acha os dados da sala
            $salas = Sala::find($data['id_sala']);

            //verifica numero de máquinas já ocupadas
            $maquinas_reservadas = Cadastro::countMaquinas($salas->id);

            //verifica se o numero de vagas disponiveis é diferente do total de vagas ocupadas
            if($salas->qtd_maquinas != $maquinas_reservadas){
                //adiciona os dados na tabela cadastro
                Cadastro::create($data);

                return redirect('agenda')->with('msg-success', 'Prova agendada com sucesso!');
            }else{
                return redirect('agenda')->with('msg-error', 'Máquinas insuficientes para esta data!');
            }
        }else{
            return redirect('agenda')->with('msg-error', 'Você já esta cadastrado nesta sala!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     //função para mostrar as salas
    public function show($id)
    {
        //traz as salas disponiveis conforme clausulas de scopeExibicao() do model
        $salas = Sala::exibicao()->get();

        $cadastros = '';

        //popula o array $cadastros['id_sala'] para verificar quantos computadores estão ocupados em cada sala
        foreach($salas as $sala){
            $cadastros[$sala->id] = Cadastro::countMaquinas($sala->id);
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
        //deleta o cadastro do usuario naquela sala
        Cadastro::deleteCadastro($id)->delete();

        return redirect('agenda')->with('msg-success', 'Prova removida com sucesso!');
    }

    public function search(){
        //captura valores dos filtros
        $data = request('data');
        $hora = request('hora');

        //faz as requisiçoes conforme as variaveis estao vazias ou não
        if ($data) {
            if($hora){
                $salas = Sala::data($data)->hora($hora)->get();
            }else{
                $salas = Sala::data($data)->get();
            }
        }elseif($hora){
            $salas = Sala::hora($hora)->get();
        }else{
            $salas = Sala::exibicao()->get();
        }
        
        $cadastros = '';

        //popula o array $cadastros['id_sala'] para verificar quantos computadores estão ocupados em cada sala
        foreach($salas as $sala){
            $cadastros[$sala->id] = Cadastro::countMaquinas($sala->id);
        }
        
        return view('agenda.show',['salas' => $salas, 'cadastros' => $cadastros]);
    }
    
    public function showMyList($id_aluno){
        //retorna todos as salas que o usuario esta cadastrado
        $cadastros = Cadastro::minhaLista($id_aluno)->get();

        return view('agenda.myList', ['cadastros' => $cadastros,]);
    }
}
