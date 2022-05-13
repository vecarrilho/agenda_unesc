<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <title>Agenda</title>
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="container">
                <a class="navbar-brand" href="#">
                    <img src="/img/logo.png" alt="">
                </a>
                @auth
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
                @endauth
            </div>
        </nav>
    </header>
    <div class="container-fluid">
        <div class="row">
            @if(!empty($msgSuccess))
                <p class="msg-success">{{$msgSuccess}}</p>
            @endif
        </div>
    </div>
    <div class="container">
        <ul class="lista-botoes inline-flex">
            <li><a href="{{ route('agenda.show', true) }}" class="btn btn-primary">Horários Disponíveis</a></li>
        </ul>
        <form class="form-inline" action="/search/MyList" method="GET"> 
            @csrf
            @can('writer')
                <div class="form-group input-filter">
                    <label>Aluno</label>
                    <select name="aluno" id="aluno" onchange="getAluno()" class="form-select" data-live-search="true" required>
                        <option value="">Selecione um código de aluno</option>
                        @foreach($users as $user)
                            @if($user->id == session('aluno'))
                                <option value="{{ $user->id }}" selected>{{ $user->nomeExibicao  }}</option>
                            @endif
                                <option value="{{ $user->id }}">{{ $user->nomeExibicao  }}</option>
                        @endforeach
                    </select>
                </div>
            @endcan
            <div class="form-group2 input-filter">
                <input class="form-control" type="submit" value="Filtrar">
            </div> 
        </form>
        <h2>Meus horários agendados</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Polo</th>
                    <th>Bloco</th>
                    <th>Data</th>
                    <th>Hora</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cadastros as $cadastro)
                    <tr>
                        <td>{{ $cadastro->descricao }}</td>
                        <td>{{ $cadastro->bloco }}</td>
                        <td>{{ $cadastro->date_formated }}</td>
                        <td>{{ $cadastro->hour_formated }}</td>
                        <form action="{{ route('agenda.destroy', ['agenda' => $cadastro->id_cadastro]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <td><button type="submit" class="btn btn-danger"><span>Cancelar este horário</span></button></td>
                        </form>
                    </tr> 
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>