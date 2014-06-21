@extends('layouts.main')

@section('content')

<p>
<h1>{{ $results[0]->username }}</h1>
<table border="1">
    <thead>
    <tr>
        <th>Score</th>
        <th>Stars</th>
        <th>Language</th>
        <th>Repo</th>
    </tr>
    </thead>
    <tbody>
        @foreach ($results as $result)
            <tr>
                <td>{{ $result->score }}</td>
                <td>{{ $result->stars }}</td>
                <td>{{ $result->language }}</td>
                <td><a href="http://github.com/{{ $result->name }}" target="_blank">{{ $result->name }}</a></td>
            </tr>
        @endforeach
    </tbody>
</table>

</p>

@stop