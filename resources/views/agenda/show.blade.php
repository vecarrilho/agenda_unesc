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
                            <td>{{ $sala->id }}</td>
                            <td><a href="{{ route('agenda.edit', ['agenda' => 1]) }}" class="btn btn-warning">Editar</a><a href="{{ route('agenda.destroy', ['agenda' => 1]) }}" class="btn btn-danger">Deletar</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
    </div>
</body>
</html>