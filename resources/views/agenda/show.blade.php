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
            </div>
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
        </nav>
    </header>
    <div class="container">
        <a href="/" class="btn btn-secondary btn-voltar" >Voltar</a>
        <form action="/search" method="GET"> 
            <div class="form-group">
                <label>Data</label>
                <input class="form-control" type="date" name="data" min="{{date('Y-m-d')}}">
            </div>
            <div class="form-group">
                <label>Hora</label>
                <input class="form-control" type="time" name="hora">
            </div>
            <div class="form-group">
                <label>Polo</label>
                <input class="form-control" type="text" name="polo" placeholder="polo">
            </div>
            <div class="form-group">
                <input class="form-control" type="submit" value="Pesquisar">
            </div>
            
        </form>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Polo</th>
                    <th>Data</th>
                    <th>Hora</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                @foreach($salas as $sala)
                    <tr>
                        <td>{{ $sala->id }}</td>
                        <td>{{ $sala->polo }}</td>
                        <td>{{ date('d/m/Y', strtotime($sala->data)) }}</td>
                        <td><button type="button" class="btn btn-light position-relative">{{ date('H:i', strtotime($sala->hora))}}<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning">
                                @if ($sala->qtd_maquinas - $cadastros[$sala->id] > 0)
                                    +{{ $sala->qtd_maquinas - $cadastros[$sala->id] }} Vagas
                                @else
                                    Esgotado
                                @endif
                            </span>
                            </button></td>
                        <td>
                            <form action="{{route('agenda.store')}}" method="POST">
                                @csrf
                                <input type="hidden" name="id_sala" value="{{$sala->id}}">
                                <button class="btn btn-primary" type="submit">Agendar este horário</button>
                            </form> 
                            {{-- <a href="{{  }}" class="btn btn-primary">Entrar</a> --}}
                        </td>
                        {{-- <td><a href="/insert_cadastro/{{$sala->id}}/{{Auth::user()->id}}" class="btn-primary btn">Entrar</a></td> --}}
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>