<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <title>Gerar Relatório</title>
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
    <div class="container">
        <a href="/" class="btn btn-secondary btn-voltar" >Voltar</a>
        <form class="form-inline" action="{{ route('admin.export') }}" method="GET"> 
            @csrf
            <div class="form-group input-filter">
                <label class="sr-only" for="inlineFormInputName2">Data</label>
                <select name="data" class="form-select">
                    <option value="">Selecione uma data</option>
                    @foreach ($salas as $sala)
                        <option value="{{ $sala->data }}">{{ $sala->date_formated }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group2 input-filter">
                <input class="form-control" type="submit" value="Filtrar">
            </div> 
        </form>
    </div>


</div>
</body>
</html>