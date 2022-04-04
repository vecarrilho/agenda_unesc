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
            </div>
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
        </nav>
    </header>
    <div class="container-fluid">
        <div class="row">
            @if(session('msg-success'))
                <p class="msg-success">{{session('msg-success')}}</p>
            @elseif(session('msg-error'))
                <p class="msg-error">{{session('msg-error')}}</p>
            @endif
            @yield('content')
        </div>
    </div>
    <div class="container">
        <a href="/" class="btn btn-secondary btn-voltar" >Voltar</a>
        <h2>Sua lista de provas</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Polo</th>
                    <th>Bloco</th>
                    <th>Sala</th>
                    <th>Data</th>
                    <th>Hora</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cadastros as $cadastro)
                    <tr>
                        <td>{{ $cadastro->id }}</td>
                        <td>{{ $cadastro->polo }}</td>
                        <td>{{ $cadastro->bloco }}</td>
                        <td>{{ $cadastro->nsala }}</td>
                        <td>{{ date('d/m/Y', strtotime($cadastro->data)) }}</td>
                        <td>{{ date('H:i', strtotime($cadastro->hora)) }}</td>
                        <form action="{{ route('agenda.destroy', ['agenda' => $cadastro->id_cadastro]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <td><button type="submit" class="btn btn-danger"><span>Cancelar este horário</span></button></td>
                        </form>
                        <td></td>
                    </tr> 
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>