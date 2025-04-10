<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h1>Spelerslijst</h1>
<ul>
    @foreach ($spelers as $speler)
        <li><a href="{{ route('spelers.show', $speler->id) }}">{{ $speler->naam }}</a></li>
    @endforeach
</ul>

</body>
</html>