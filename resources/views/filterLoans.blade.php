@extends('layouts.app')

@section('content')

<div class="container">
    <h2>Prestamos</h2>
    <div class="container">
        @if(isset($books)) 
            @foreach($books as $book)
                <div>
                    <div>
                        Título:
                        <?=$book->book->title?>
                    </div>

                    <div>
                        Autor:
                        <?=$book->book->author?>
                    </div>

                    <div>
                        Sinopsis:
                        <?=$book->book->synopsis?>
                    </div>

                    <div>
                        Género:
                        <?=$book->book->genre?>
                    </div>

                    <div>
                        Fecha de prestamo:
                        <?=$book->delivery_date?>
                    </div>

                    <div>
                        Fecha en la que se devolvió:
                        @if($book->return_date === null)
                        "No devuelto"
                        @else 
                        <?=$book->delivery_date?>
                        @endif
                    </div>
                </div></br>
            @endforeach
        @endif
    </div>
</div>
@endsection