<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h1>Scores van {{ $speler->naam }}</h1>

<table border="1">
    <thead>
        <tr>
            <th>Datum</th>
            <th>Score</th>
            <th>Spelmodus</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($speler->scores as $score)
            <tr>
                <td>{{ $score->datum }}</td>
                <td>{{ $score->waarde }}</td>
                <td>{{ $score->modus }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
                                                                                                
</body>
</html>