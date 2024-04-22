@extends('layouts.app')
@section('head.title', 'Mis Cursos - ' . config('app.name'))

@section('content')
<x-title label="Mis Cursos" previous-url="{{ route('home') }}" description="Enae Recargado" />
<a href="https://us06web.zoom.us/j/88142648938" style="color:white;">Ingresa a las Clases en Vivo<a>
<main>
    <div class="col-12 mb-5">
        <div class="card mb-12">
            <div class="accordion" id="accordionExample">
                @for ($i = 0; $i < count($courses_header); $i++)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <b>{{  $courses_header[$i]->course_name }}</b>
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" >
                            <div class="accordion-body">
                                <ul class="list-group list-group mb-3">
                                    @foreach ($courses[$i] as $course)
                                        <li class="list-group-item">
                                            <a href="{{ route('courses.show', $course->url) }}"><b>{{ $loop->index+1}}.- {{ $course->description_video}}</b></a>
                                            <a style="float: right" href="/material/{{ $course->url_resource }}"><b>{{ $course->url_resource}}</b></a>
                                        </li>
                                    @endforeach
                                </ul>
                                <span><b>Recursos adicionales: </b></span><br>

                            </div>
                        </div>
                    </div>
                @endfor

            </div>
        </div>
    </div>


</main>
@endsection

<!--    <main>
        <div class="row">
            <div class="col-12">
                <x-embed url="https://www.youtube.com/watch?v=Q0PwpiIT4GI"  aspect-ratio="16:9" />
            </div>
       </div>
    </main>-->
