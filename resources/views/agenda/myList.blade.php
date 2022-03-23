<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/style.css">
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
                    <th>Bloco</th>
                    <th>Data - Hora</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cadastros as $cadastro)
                    <tr>
                        <td>{{ $cadastro->id }}</td>
                        <td>{{ $cadastro->bloco }}</td>
                        <td>{{ date('d/m/Y', strtotime($cadastro->data)) . ' - ' . date('H:i', strtotime($cadastro->hora)) }}</td>
                        <form action="{{ route('agenda.destroy', ['agenda' => Auth::user()->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <td><button type="submit" class="btn btn-danger"><span>Sair</span></button></td>
                        </form>
                        <td></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>