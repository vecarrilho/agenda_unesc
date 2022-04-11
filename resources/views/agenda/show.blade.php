<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <title>Lista Agendamento</title>
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="container">
                <a class="navbar-brand" href="#">
                    <img src="/img/logo.png" alt="">
                </a>
                <div class="dropdown-header">
                    <ul class="nav justify-content-end">
                        <div class="dropdown nav-item">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }}
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <form action="/logout" method="POST">
                                    @csrf
                                    <li><button class="btn btn-primary dropdown-item" type="submit" onclick="event.preventDefault(); this.closest('form').submit();"><span>Sair</span></button></li>
                                </form>
                            </ul> 
                        </div>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <div class="container-fluid">
        <div class="row">
            @if(!empty($msgError))
                <p class="msg-error">{{$msgError}}</p>
            @elseif(!empty($msgSuccess))
                <p class="msg-success">{{$msgSuccess}}</p>
            @endif
        </div>
    </div>
    <div class="container">
        <ul class="lista-botoes inline-flex">
            @can('user')
                <li><a href="{{ route('agenda.myList', Auth::user()->id) }}" class="btn btn-primary">Meus Agendamentos</a></li>
            @elsecan('admin')
                <li><a href="{{ route('admin.createSala') }}" class="btn btn-primary">Cadastrar Sala</a></li>
                <li><a href="{{ route('admin.createPolo') }}" class="btn btn-primary">Cadastrar Polo</a></li>
            @endcan
        </ul>
        <form class="form-inline" action="/search" method="GET"> 
            @can('admin')
                <div class="form-group input-filter">
                    <label>Polo</label>
                    <select name="polo" class="form-select">
                        <option value="">Selecione um polo</option>
                        @foreach($polos as $polo)
                            @if($polo->id == session('polo'))
                                <option value="{{ $polo->id }}" selected>{{ $polo->descricao }}</option>
                            @else
                                <option value="{{ $polo->id }}">{{ $polo->descricao }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            @endcan
            <div class="form-group input-filter">
                <label class="sr-only" for="inlineFormInputName2">Data</label>
                {{-- <input class="form-control" id="inlineFormInputName2" type="date" name="data" min="{{date('Y-m-d')}}" value="{{ session('data') }}"> --}}
                <select name="data" class="form-select">
                    <option value="">Selecione uma data</option>
                    @foreach($datas as $data)
                        @if(session('data') == $data->data)
                            <option value="{{ $data->data }}" selected>{{ $data->date_formated }}</option>
                        @else
                            <option value="{{ $data->data }}">{{ $data->date_formated }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group2 input-filter">
                <input class="form-control" type="submit" value="Filtrar">
            </div> 
        </form>
        <table class="table">
            <thead>
                <tr>
                    <th>Bloco</th>
                    <th>Polo</th>
                    <th>Data</th>
                    <th>Hora</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($salas as $sala)
                    <tr>
                        <td>{{ $sala->bloco }}</td>
                        <td>{{ $sala->descricao }}</td>
                        <td>{{ $sala->date_formated }}</td>
                        @if ($sala->qtd_maquinas > 0)
                            <td><button type="button" class="btn btn-light position-relative">{{ $sala->hour_formated }}
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning"> +{{ $sala->qtd_maquinas }} Vagas
                                </span>
                            </button></td>
                            <td>
                                <form action="{{route('agenda.store')}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id_sala" value="{{$sala->id}}">
                                    <button class="btn btn-primary" type="submit">Agendar este horário</button>
                                </form> 
                            </td>
                        @else
                            <td><button type="button" class="btn btn-light position-relative">{{ $sala->hour_formated }}
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"> Esgotado
                                </span>
                            </button></td>
                            <td>
                                <form action="{{route('agenda.store')}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id_sala" value="{{$sala->id}}">
                                    <button class="btn btn-primary" type="submit" disabled>Agendar este horário</button>
                                </form> 
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
