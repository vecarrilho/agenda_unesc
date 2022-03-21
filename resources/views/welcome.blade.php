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
    <div class="container">
        <ul class="lista-botoes">
            <li><a href="{{ route('agenda.create') }}" class="btn btn-primary">Cadastrar Agendamento</a></li>
            <li><a href="{{ route('agenda.show', ['agenda' => 1]) }}" class="btn btn-primary">Listar Agendamentos</a></li>
        </ul>
    </div>
</body>
</html>