@extends('layouts.app')

@section('content')

<div class="container">
    <h2>Filtre por un Género y/o un Autor!</h2>
    <form class="container" action="{{url('filterBooks')}}" method="GET">
        <h3>Autor</h3>
        <input class="input" placeholder="Autor" name="author" type="text"/>
        <h3>Género</h3>
        <input class="input" placeholder="Género" name="genre" type="text"/>
        <input type="submit"/>
    </form>
</div>
@endsection