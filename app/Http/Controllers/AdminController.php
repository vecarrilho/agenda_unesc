<?php

namespace App\Http\Controllers;

use App\Exports\salasExport;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUpdateSalaFormRequest;
use App\Models\Cadastro;
use App\Models\Polo;
use App\Models\Sala;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
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
        $data['status'] = 'Ativo';

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
        $user = User::find(Auth::user()->id);
        if($user->hasPermissionTo('admin')){
            $salas = Sala::statusAtivo()->groupDatasRelatorio()->get();
    
            for ($i=0; $i < count($salas); $i++) { 
                $salas[$i]->date_formated = $salas[$i]->data;
            }
    
            return view('admin.show', ['salas' => $salas]);
        }else{
            return redirect(route('/')) ;
        }
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

    public function export(){
        $user = User::find(Auth::user()->id);
        if($user->hasPermissionTo('admin')){
            $data = request('data');
    
            return Excel::download(new salasExport($data), 'salas.xls');
        }else{
            return redirect(route('agenda.index'));
        }
    }
}
