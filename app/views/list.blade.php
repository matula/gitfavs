@extends('layouts.main')

@section('content')

<p>
<h2>{{ $results[0]->username }}</h2>
<table border="1">
    <thead>
    <tr>
        <th>Score</th>
        <th>GH Stars</th>
        <th>Language</th>
        <th>Repo</th>
    </tr>
    </thead>
    <tbody>
        @foreach ($results as $result)
            <tr>
                <td style="background-color: #efefef">{{ $result->score }}</td>
                <td style="background-color: #efefef">{{ $result->stars }}</td>
                <td style="background-color: #efefef">{{ $result->language }}</td>
                <td style="background-color: #efefef"><a href="http://github.com/{{ $result->name }}" target="_blank">{{ $result->name }}</a></td>
            </tr>
        @endforeach
    </tbody>
</table>

</p>

@stop