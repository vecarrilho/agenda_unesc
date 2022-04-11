<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sala;
use App\Models\Cadastro;
use App\Models\Polo;
use App\Models\User;
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
        if (Auth::user() == null) {
            return view('auth.login');
        }else{
            $user = User::find(Auth::user()->id);
            if($user->hasPermissionTo('user')){
                //retorna todos as salas que o usuario esta cadastrado
                $cadastros = Cadastro::minhaLista(Auth::user()->id)->get();
                if(count($cadastros)>0){
                    for ($i=0; $i < count($cadastros); $i++) { 
                        $cadastros[$i]->date_formated = $cadastros[$i]->data;
                        $cadastros[$i]->hour_formated = $cadastros[$i]->hora;
                    }
                    return view('agenda.myList', ['cadastros' => $cadastros,]);
                }else{
                    //traz as salas disponiveis conforme clausulas de scopeExibicao() do model
                    $salas = Sala::exibicao()->get();
            
                    $polos = Polo::exibicao()->get();
            
                    for ($i=0; $i < count($salas); $i++) { 
                        $salas[$i]->date_formated = $salas[$i]->data;
                        $salas[$i]->hour_formated = $salas[$i]->hora;
                    }
            
                    $cadastros = '';
            
                    //popula o array $cadastros['id_sala'] para verificar quantos computadores estão ocupados em cada sala
                    foreach($salas as $sala){
                        $cadastros[$sala->id] = Cadastro::countMaquinas($sala->id);
                    }
                    
                    return view('agenda.show', ['salas' => $salas, 'cadastros' => $cadastros, 'polos' => $polos]);
                }
            }else{
                return view('welcome');
            }
        }
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
        $polos = Polo::exibicao()->get();
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
            $maquinasReservadas = Cadastro::countMaquinas($salas->id);

            //verifica se o numero de vagas disponiveis é diferente do total de vagas ocupadas
            if($salas->qtd_maquinas != $maquinasReservadas){
                //verifica se usuario tem mais de 3 agendamentos
                $cadastrosUsuario = Cadastro::countCadastros()->count();
                
                if($cadastrosUsuario < 3){
                    //adiciona os dados na tabela cadastro
                    Cadastro::create($data);
    
                    //traz as salas disponiveis conforme clausulas de scopeExibicao() do model
                    $salas = Sala::exibicao()->get();
            
                    for ($i=0; $i < count($salas); $i++) { 
                        $salas[$i]->date_formated = $salas[$i]->data;
                        $salas[$i]->hour_formated = $salas[$i]->hora;
                    }
            
                    // $cadastros = '';
            
                    //popula o array $cadastros['id_sala'] para verificar quantos computadores estão ocupados em cada sala
                    // foreach($salas as $sala){
                    //     $cadastros[$sala->id] = Cadastro::countMaquinas($sala->id);
                    // }
    
                    //retorna todos as salas que o usuario esta cadastrado
                    // $cadastros = Cadastro::minhaLista(Auth::user()->id)->get();
    
                    // for ($i=0; $i < count($cadastros); $i++) { 
                    //     $cadastros[$i]->date_formated = $cadastros[$i]->data;
                    //     $cadastros[$i]->hour_formated = $cadastros[$i]->hora;
                    // }
    
                    return view('agenda.show', ['polos' => $polos, 'salas' => $salas])->with('msgSuccess', 'Prova agendada com sucesso!');

                }else{
                    //traz as salas disponiveis conforme clausulas de scopeExibicao() do model
                    $salas = Sala::exibicao()->get();
            
                    for ($i=0; $i < count($salas); $i++) { 
                        $salas[$i]->date_formated = $salas[$i]->data;
                        $salas[$i]->hour_formated = $salas[$i]->hora;
                    }
            
                    // $cadastros = '';
            
                    //popula o array $cadastros['id_sala'] para verificar quantos computadores estão ocupados em cada sala
                    // foreach($salas as $sala){
                    //     $cadastros[$sala->id] = Cadastro::countMaquinas($sala->id);
                    // }
                    return view('agenda.show', ['salas' => $salas, 'polos' => $polos])->with('msgError', 'Máximo de 3 agendamentos atingidos!');    
                }
            }else{
                //traz as salas disponiveis conforme clausulas de scopeExibicao() do model
                $salas = Sala::exibicao()->get();
        
                for ($i=0; $i < count($salas); $i++) { 
                    $salas[$i]->date_formated = $salas[$i]->data;
                    $salas[$i]->hour_formated = $salas[$i]->hora;
                }
        
                // $cadastros = '';
        
                //popula o array $cadastros['id_sala'] para verificar quantos computadores estão ocupados em cada sala
                // foreach($salas as $sala){
                //     $cadastros[$sala->id] = Cadastro::countMaquinas($sala->id);
                // }

                return view('agenda.show', ['salas' => $salas, 'polos' => $polos])->with('msgError', 'Máquinas insuficientes para esta data!');
            }
        }else{
            //traz as salas disponiveis conforme clausulas de scopeExibicao() do model
            $salas = Sala::exibicao()->get();
    
            for ($i=0; $i < count($salas); $i++) { 
                $salas[$i]->date_formated = $salas[$i]->data;
                $salas[$i]->hour_formated = $salas[$i]->hora;
            }
    
            // $cadastros = '';
    
            //popula o array $cadastros['id_sala'] para verificar quantos computadores estão ocupados em cada sala
            // foreach($salas as $sala){
            //     $cadastros[$sala->id] = Cadastro::countMaquinas($sala->id);
            // }

            return view('agenda.show', ['salas' => $salas, 'polos' => $polos])->with('msgError', 'Você já esta cadastrado nesta sala!');
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
        $user = User::find(Auth::user()->id);
        // if(session()->has('polo') || session()->has('data')){
        //     return redirect('search');
        // }
        //traz as salas disponiveis conforme clausulas de scopeExibicao() do model
        if($user->hasPermissionTo('admin')){
            $salas = Sala::exibicao()->orderBybloco()->orderByData()->orderByHora()->get();
    
            $polos = Polo::exibicao()->get();
        }else{
            $salas = Sala::exibicao()->verificaPolo()->orderBybloco()->orderByData()->orderByHora()->get();
    
            $polos = Polo::exibicao()->verificaPolo()->get();
        }

        for ($i=0; $i < count($salas); $i++) { 
            $salas[$i]->date_formated = $salas[$i]->data;
            $salas[$i]->hour_formated = $salas[$i]->hora;
        }

        // $cadastros = '';

        //popula o array $cadastros['id_sala'] para verificar quantos computadores estão ocupados em cada sala
        // foreach($salas as $sala){
        //     $cadastros[$sala->id] = Cadastro::countMaquinas($sala->id);
        // }
        
        return view('agenda.show', ['salas' => $salas, 'polos' => $polos]);
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
        
        //retorna todos as salas que o usuario esta cadastrado
        $cadastros = Cadastro::minhaLista(Auth::user()->id)->get();

        for ($i=0; $i < count($cadastros); $i++) { 
            $cadastros[$i]->date_formated = $cadastros[$i]->data;
            $cadastros[$i]->hour_formated = $cadastros[$i]->hora;
        }

        return view('agenda.myList', ['cadastros' => $cadastros])->with('msgSuccess', 'Agendamento removido com sucesso!');
    }

    public function search()
    {
        //captura valores dos filtros
        if(request('data')){
            $dataFilter = request('data');
        }else{
            $dataFilter = session('data');
        }

        if(request('polo')){
            $poloFilter = request('polo');
        }else{
            $poloFilter = session('polo');
        }

        //adiciona os valores do filtro em uma sessão
        session(['polo' => $poloFilter]);
        session(['data' => $dataFilter]);

        //faz as requisiçoes conforme as variaveis estao vazias ou não
        if ($dataFilter) {
            if ($poloFilter) {
                $salas = Sala::joinPolos()->data($dataFilter)->polo($poloFilter)->orderBybloco()->orderByData()->orderByHora()->get();
            } else {
                $salas = Sala::joinPolos()->data($dataFilter)->orderBybloco()->orderByData()->orderByHora()->get();
            }
        } elseif ($poloFilter) {
                $salas = Sala::joinPolos()->polo($poloFilter)->orderBybloco()->orderByData()->orderByHora()->get();
        } else {
            $salas = Sala::exibicao()->orderBybloco()->orderByData()->orderByHora()->get();
        }

        //formata data e hora
        for ($i=0; $i < count($salas); $i++) { 
            $salas[$i]->date_formated = $salas[$i]->data;
            $salas[$i]->hour_formated = $salas[$i]->hora;
        }
        
        // $cadastros = '';

        //popula o array $cadastros['id_sala'] para verificar quantos computadores estão ocupados em cada sala
        // foreach($salas as $sala){
        //     $cadastros[$sala->id] = Cadastro::countMaquinas($sala->id);
        // }

        $polos = Polo::exibicao()->get();
        return view('agenda.show')->with(compact('salas', 'polos'));
    }
    
    public function showMyList($id_aluno)
    {
        //retorna todos as salas que o usuario esta cadastrado
        $cadastros = Cadastro::minhaLista(Auth::user()->id)->get();

        for ($i=0; $i < count($cadastros); $i++) { 
            $cadastros[$i]->date_formated = $cadastros[$i]->data;
            $cadastros[$i]->hour_formated = $cadastros[$i]->hora;
        }
        return view('agenda.myList', ['cadastros' => $cadastros]);
    }
}
