<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sala;
use App\Models\Cadastro;
use App\Models\Polo;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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
        $users = '';
        $polos = '';
        if (Auth::user() == null) {
            return view('auth.login');
        }else{
            $user = User::find(Auth::user()->id);
            // if($user->hasPermissionTo('user')){
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
                    if($user->hasPermissionTo('admin')){
                        $salas = Sala::exibicao()->statusAtivo()->orderBybloco()->orderByData()->orderByHora()->get();

                        $datas = Sala::groupDatas()->statusAtivo()->get();
                
                        $polos = Polo::exibicao()->get();
                    }else{
                        $salas = Sala::exibicao()->statusAtivo()->verificaPolo()->orderBybloco()->orderByData()->orderByHora()->get();

                        $datas = Sala::groupDatas()->statusAtivo()->verificaPolo()->get();

                        if($user->hasPermissionTo('writer')){
                            $users = User::where('cd_pessoa', '!=', 1)->orderByCodigo()->get();

                            for ($i=0; $i < count($users); $i++) { 
                                $users[$i]->nomeExibicao = $users[$i]->cd_pessoa . '-' . $users[$i]->name;
                            }
                        }
                    }
            
                    for ($i=0; $i < count($salas); $i++) { 
                        $salas[$i]->date_formated = $salas[$i]->data;
                        $salas[$i]->hour_formated = $salas[$i]->hora;
                    }
                    
                    for ($i=0; $i < count($datas); $i++) { 
                        $datas[$i]->date_formated = $datas[$i]->data;
                    }
                    
                    return view('agenda.show', ['salas' => $salas, 'polos' => $polos, 'datas' => $datas, 'users' => $users]);
                }
            // }else{
            //     return view('welcome');
            // }
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
        $user = User::find(Auth::user()->id);
        $polos = '';
        $users = '';
        //traz todos dados do form
        $data = $request->all();
        if(session('aluno')){
            $data['id_usuario'] = session('aluno');
        }else{
            $data['id_usuario'] = Auth::user()->id;
        }

        //traz as salas disponiveis conforme clausulas de scopeExibicao() do model
        if($user->hasPermissionTo('admin')){
            $salas = Sala::exibicao()->orderBybloco()->orderByData()->orderByHora()->get();
            $polos = Polo::exibicao()->get();
            $datas = Sala::groupDatas()->get();
        }elseif($user->hasPermissionTo('writer')){
            $salas = Sala::exibicao()->statusAtivo()->verificaPolo()->orderBybloco()->orderByData()->orderByHora()->get();
            $datas = Sala::statusAtivo()->groupDatas()->get();
            $users = User::where('cd_pessoa', '!=', 1)->orderByCodigo()->get();

            for ($i=0; $i < count($users); $i++) { 
                $users[$i]->nomeExibicao = $users[$i]->cd_pessoa . '-' . $users[$i]->name;
            }
        }else{
            $salas = Sala::exibicao()->statusAtivo()->verificaPolo()->orderBybloco()->orderByData()->orderByHora()->get();
            $datas = Sala::statusAtivo()->groupDatas()->verificaPolo()->get();
        }

        for ($i=0; $i < count($salas); $i++) { 
            $salas[$i]->date_formated = $salas[$i]->data;
            $salas[$i]->hour_formated = $salas[$i]->hora;
        }

        for ($i=0; $i < count($datas); $i++) { 
            $datas[$i]->date_formated = $datas[$i]->data;
        }
        
        //verifica se o aluno ja esta cadastrado nesta sala
        $cadastros = Cadastro::verificaAgenda($data['id_usuario'], $data['id_sala'])->first();
        
        //verifica se o retorno é vazio
        if(empty($cadastros)){
            //acha os dados da sala
            $sala = Sala::find($data['id_sala']);

            //verifica se o numero de vagas disponiveis é diferente do total de vagas ocupadas
            if($sala->qtd_maquinas != 0){
                //verifica se usuario tem mais de 5 agendamentos
                $cadastrosUsuario = Cadastro::countCadastros()->count();
                
                if($cadastrosUsuario < 5){
                    //adiciona os dados na tabela cadastro
                    Cadastro::create($data);
                    
                    $tipoMsg = 'msgSuccess';
                    $msg = 'Prova agendada com sucesso!';
                    $sala->date_formated = $sala->data;
                    $sala->hour_formated = $sala->hora;
                    
                    $dataEmail = array('data'=>$sala->date_formated, 'hora'=>$sala->hour_formated, 'bloco'=>$sala->bloco);
                    Mail::send('emails.email', $dataEmail, function($message){
                        $message->to('vecarrilho@unesc.net', 'Artisan')
                                ->subject('Confirmação de agendamento de prova');
                        $message->from('vecarrilho3@gmail.com', 'Vitor');
                                
                    });
                }else{
                    
                    $tipoMsg = 'msgError';
                    $msg = 'Máximo de 5 agendamentos atingidos!';
                }
            }else{
                    
                $tipoMsg = 'msgError';
                $msg = 'Máquinas insuficientes para esta data!';
            }
        }else{
                    
            $tipoMsg = 'msgError';
            $msg = 'Você já esta cadastrado nesta sala!';
        }
        return view('agenda.show', ['salas' => $salas, 'polos' => $polos, 'datas' => $datas, 'users' => $users])->with($tipoMsg, $msg);
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
        $polos = '';
        $users = '';
        
        //traz as salas disponiveis conforme clausulas de scopeExibicao() do model
        if($user->hasPermissionTo('admin')){
            $salas = Sala::exibicao()->orderBybloco()->orderByData()->orderByHora()->get();

            $datas = Sala::groupDatas()->get();
    
            $polos = Polo::exibicao()->get();
        }elseif($user->hasPermissionTo('writer')){
            $users = User::where('cd_pessoa', '!=', 1)->orderByCodigo()->get();

            for ($i=0; $i < count($users); $i++) { 
                $users[$i]->nomeExibicao = $users[$i]->cd_pessoa . '-' . $users[$i]->name;
            }

            $salas = Sala::exibicao()->statusAtivo()->verificaPolo()->orderBybloco()->orderByData()->orderByHora()->get();

            $datas = Sala::statusAtivo()->groupDatas()->verificaPolo()->get();
        }else{
            $salas = Sala::exibicao()->statusAtivo()->verificaPolo()->orderBybloco()->orderByData()->orderByHora()->get();

            $datas = Sala::statusAtivo()->groupDatas()->verificaPolo()->get();
        }

        for ($i=0; $i < count($salas); $i++) { 
            $salas[$i]->date_formated = $salas[$i]->data;
            $salas[$i]->hour_formated = $salas[$i]->hora;
        }

        for ($i=0; $i < count($datas); $i++) { 
            $datas[$i]->date_formated = $datas[$i]->data;
        }
        
        return view('agenda.show', ['salas' => $salas, 'polos' => $polos, 'datas' => $datas, 'users' => $users]);
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
        $users = '';
        //deleta o cadastro do usuario naquela sala
        Cadastro::deleteCadastro($id)->delete();
        
        $user = User::find(Auth::user()->id);
        if($user->hasPermissionTo('writer')){
            $users = User::where('cd_pessoa', '!=', 1)->orderByCodigo()->get();

            for ($i=0; $i < count($users); $i++) { 
                $users[$i]->nomeExibicao = $users[$i]->cd_pessoa . '-' . $users[$i]->name;
            }
        }
        //retorna todos as salas que o usuario esta cadastrado
        $cadastros = Cadastro::minhaLista(Auth::user()->id)->get();

        for ($i=0; $i < count($cadastros); $i++) { 
            $cadastros[$i]->date_formated = $cadastros[$i]->data;
            $cadastros[$i]->hour_formated = $cadastros[$i]->hora;
        }

        return view('agenda.myList', ['cadastros' => $cadastros, 'users' => $users])->with('msgSuccess', 'Agendamento removido com sucesso!');
    }

    public function search()
    {
        $user = User::find(Auth::user()->id);
        $users = '';
        $polos = '';

        //captura valores dos filtros
        if(request('data')){
            $dataFilter = request('data');
        }else{
            $dataFilter = '';
        }

        if(request('polo')){
            $poloFilter = request('polo');
        }else{
            $poloFilter = '';
        }

        if(request('aluno')){
            $alunoFilter = request('aluno');
        }else{
            $alunoFilter = '';
        }

        //adiciona os valores do filtro em uma sessão
        session(['polo' => $poloFilter]);
        session(['data' => $dataFilter]);
        session(['aluno' => $alunoFilter]);

        //faz as requisiçoes conforme as variaveis estao vazias ou não
        if ($dataFilter) {
            if($user->hasPermissionTo('writer')){
                if($alunoFilter){
                    $poloAluno = User::codigoAluno($alunoFilter)->first();
                    $salas = Sala::exibicao()->data($dataFilter)->polo($poloAluno->cd_polo)->orderBybloco()->orderByData()->orderByHora()->get();
                }else{
                    $salas = Sala::joinPolos()->statusAtivo()->verificaPolo()->data($dataFilter)->orderBybloco()->orderByData()->orderByHora()->get();
                }
            }else{
                if ($poloFilter) {
                    $salas = Sala::joinPolos()->data($dataFilter)->polo($poloFilter)->orderBybloco()->orderByData()->orderByHora()->get();
                } else {
                    if($user->hasPermissionTo('admin')){
                        $salas = Sala::joinPolos()->data($dataFilter)->orderBybloco()->orderByData()->orderByHora()->get();
                    }else{
                        $salas = Sala::joinPolos()->statusAtivo()->verificaPolo()->data($dataFilter)->orderBybloco()->orderByData()->orderByHora()->get();
                    }
                }
            }
        } elseif ($poloFilter) {
                $salas = Sala::joinPolos()->polo($poloFilter)->orderBybloco()->orderByData()->orderByHora()->get();
        } else {
            if($user->hasPermissionTo('writer')){
                if($alunoFilter){
                    $poloAluno = User::codigoAluno($alunoFilter)->first();

                    $salas = Sala::exibicao()->polo($poloAluno->cd_polo)->orderBybloco()->orderByData()->orderByHora()->get();
                }else{
                    $salas = Sala::exibicao()->orderBybloco()->orderByData()->orderByHora()->get();
                }
            }elseif($user->hasPermissionTo('admin')){
                $salas = Sala::exibicao()->orderBybloco()->orderByData()->orderByHora()->get();
            }else{
                $salas = Sala::exibicao()->statusAtivo()->verificaPolo()->orderBybloco()->orderByData()->orderByHora()->get();
            }
        }


        if($user->hasPermissionTo('admin')){
            $datas = Sala::groupDatas()->get();
            $polos = Polo::exibicao()->get();
        }elseif($user->hasPermissionTo('writer')){
            $datas = Sala::statusAtivo()->groupDatas()->get();
            $users = User::where('cd_pessoa', '!=', 1)->orderByCodigo()->get();

            for ($i=0; $i < count($users); $i++) { 
                $users[$i]->nomeExibicao = $users[$i]->cd_pessoa . '-' . $users[$i]->name;
            }
        }else{
            $datas = Sala::statusAtivo()->groupDatas()->verificaPolo()->get();
        }

        //formata data e hora
        for ($i=0; $i < count($salas); $i++) { 
            $salas[$i]->date_formated = $salas[$i]->data;
            $salas[$i]->hour_formated = $salas[$i]->hora;
        }

        for ($i=0; $i < count($datas); $i++) { 
            $datas[$i]->date_formated = $datas[$i]->data;
        }

        return view('agenda.show')->with(compact('salas', 'polos', 'datas', 'users'));
    }

    public function searchMyList()
    {
        $user = User::find(Auth::user()->id);
        $users = '';

        //captura valores dos filtros
        if(request('aluno')){
            $alunoFilter = request('aluno');
        }else{
            $alunoFilter = '';
        }

        //adiciona os valores do filtro em uma sessão
        session(['aluno' => $alunoFilter]);

        if($user->hasPermissionTo('writer')){
            $users = User::where('cd_pessoa', '!=', 1)->orderByCodigo()->get();

            for ($i=0; $i < count($users); $i++) { 
                $users[$i]->nomeExibicao = $users[$i]->cd_pessoa . '-' . $users[$i]->name;
            }
        }
        //retorna todos as salas que o usuario esta cadastrado
        $cadastros = Cadastro::minhaLista($alunoFilter)->get();

        for ($i=0; $i < count($cadastros); $i++) { 
            $cadastros[$i]->date_formated = $cadastros[$i]->data;
            $cadastros[$i]->hour_formated = $cadastros[$i]->hora;
        }

        return view('agenda.myList', ['cadastros' => $cadastros, 'users' => $users]);
    }
    
    public function showMyList($id_aluno)
    {
        //retorna todos as salas que o usuario esta cadastrado
        $cadastros = Cadastro::minhaLista(Auth::user()->id)->get();
        $user = User::find(Auth::user()->id);

        if($user->hasPermissionTo('writer')){
            $users = User::where('cd_pessoa', '!=', 1)->orderByCodigo()->get();

            for ($i=0; $i < count($users); $i++) { 
                $users[$i]->nomeExibicao = $users[$i]->cd_pessoa . '-' . $users[$i]->name;
            }
        }else{
            $users = '';
        }

        for ($i=0; $i < count($cadastros); $i++) { 
            $cadastros[$i]->date_formated = $cadastros[$i]->data;
            $cadastros[$i]->hour_formated = $cadastros[$i]->hora;
        }
        return view('agenda.myList', ['cadastros' => $cadastros, 'users' => $users]);
    }

    public function getAluno($id){
        return $id;
    }
}
