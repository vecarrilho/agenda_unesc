<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <title>Cadastrar Sala</title>
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
            @if(session('msg-success'))
                <p class="msg-success">{{session('msg-success')}}</p>
            @endif
            @yield('content')
        </div>
    <div class="container">
        <a href="/" class="btn btn-secondary btn-voltar" >Voltar</a>

        @if ($errors->any())
            <ul class="errors">
                @foreach ($errors as $error)
                    <li class="error">{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <form action="{{ route('admin.storeSala') }}" method="POST">
            @csrf 
            <div class="form-group">
                <label>Bloco</label>
                <input class="form-control" type="text" name="bloco" placeholder="Bloco">
            </div>
            <div class="form-group">
                <label>Sala</label>
                <input class="form-control" type="text" name="nsala" placeholder="Sala">
            </div>
            <div class="form-group">
                <label>Quantidade de Maquinas</label>
                <input class="form-control" type="number" name="qtd_maquinas" placeholder="Quantidade de maquinas">
            </div>
            <div class="form-group">
                <label>Hora</label>
                <input class="form-control" type="time" name="hora">
            </div>
            <div class="form-group">
                <label>Data</label>
                <input class="form-control" type="date" name="data" min="{{date('Y-m-d')}}">
            </div>
            <div class="form-group">
                <label>Polo</label>
                <select class="form-select" name="polo">
                    <option value="">Selecione um polo</option>
                    @foreach($polos as $polo)
                        <option value="{{ $polo->id }}">{{ $polo->descricao }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <input class="form-control" type="submit" value="Salvar">
            </div>
        </form>
</body>
</html>