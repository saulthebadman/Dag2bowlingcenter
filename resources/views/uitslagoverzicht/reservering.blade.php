@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-2xl font-bold mb-4">Uitslagen voor Reservering: {{ $reservering->id }}</h1>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <table class="table-auto w-full">
        <thead>
            <tr>
                <th>Persoon</th>
                <th>Spel</th>
                <th>Aantal Punten</th>
            </tr>
        </thead>
        <tbody>
            @foreach($uitslagen as $uitslag)
            <tr>
                <td>{{ $uitslag->persoon->naam }}</td>
                <td>{{ $uitslag->spel->naam }}</td>
                <td>{{ $uitslag->aantal_punten }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
