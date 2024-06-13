@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-boton">
    <h1 style="color: white;">ENTRENAMIENTO <span class="badge bg-warning text-dark">beta</span></h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-success" id="newScheduleBtn">
                <i class="bi bi-plus"></i> Nuevo Horario
             </button>
            <a href="{{ route('home') }}" class="btn btn-danger">
                <i class="bi bi-arrow-return-left"></i> Regresar
            </a>
        </div>
    </div>
</div>

<!-- Mostrar el ID de la categoría -->
<div>
    <h2>ID de la Categoría: {{ $id }}</h2>
</div>

<!-- Mostrar las subcategorías con sus IDs y 10 preguntas al azar -->
<div>
    <h3>Subcategorías</h3>
    <ul>
        @foreach($subcategories as $subcategory)
            <li>
                {{ $subcategory->id }} - {{ $subcategory->name }}
                <ul>
                    @foreach($subcategory->questions as $question)
                        <li>
                            {{ $question->id }} - {{ $question->text }}
                            <ul>
                                @foreach($question->answers as $answer)
                                    @if ($answer->correct == 1)
                                        <li style="color: red;">{{ $answer->id }} - {{ $answer->text }}</li>
                                    @else
                                        <li>{{ $answer->id }} - {{ $answer->text }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                    @endforeach
                </ul>
            </li>
        @endforeach
    </ul>
</div>
@endsection
