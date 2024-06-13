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

@foreach($subcategories as $subcategory)
            @foreach($subcategory->questions as $question)
                <li class="p-3 mb-3 rounded" style="background-color: white;">
                    <h4>{{ $question->text }}</h4>
                        <ul>
                            <div class="btn-group">
                                @foreach($question->answers as $answer)
                                <button type="button" class="btn btn-primary mx-1 rounded">{{ $answer->text }}</button>
                                @endforeach
                            </div>
                    </ul>
                </li>
            @endforeach
@endforeach

@endsection
