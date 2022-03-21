<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/style.css">
    <title>Lista Agendamento</title>
</head>
<body>
 
    <div class="container">

            <ul class="ul-show">
                <li><a href="/" class="btn btn-primary btn-cabecalho">Voltar</a></li>
                <form action="/logout" method="POST">
                    @csrf
                    <li><button class="btn btn-primary btn-cabecalho" type="submit" onclick="event.preventDefault(); this.closest('form').submit();"><span>Sair</span></button></li>
                </form>
            </ul>

        <form action="/search" method="GET"> 
            <div class="form-group">
                <label>Data</label>
                <input class="form-control" type="date" name="data">
            </div>
            <div class="form-group">
                <label>Hora</label>
                <input class="form-control" type="time" name="hora">
            </div>
            <div class="form-group">
                <input class="form-control" type="submit" value="Pesquisar">
            </div>
            

        </form>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Bloco</th>
                    <th>Data - Hora</th>
                    <th>Máquinas Disponíveis</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                @foreach($salas as $sala)
                    <tr>
                        <td>{{ $sala->id }}</td>
                        <td>{{ $sala->bloco }}</td>
                        <td>{{ date('d/m/Y', strtotime($sala->data)) . ' - ' . date('H:i', strtotime($sala->hora)) }}</td>
                        <td>{{ $sala->qtd_maquinas }}</td>
                        <td><a href="/insert_cadastro/{{$sala->id}}" class="btn-primary btn">Entrar</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>