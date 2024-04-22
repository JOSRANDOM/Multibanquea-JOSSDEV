@extends('layouts.app')
@section('head.title', 'Mis Cursos - ' . config('app.name'))

@section('content')
    <x-title label="Mis Cursos" previous-url="{{ route('home') }}" description="Clases audiovisuales preparadas para ti...." />

    <main>
        <div class="row">
            <div class="col-12 border-video"> 
                <x-embed url="https://www.youtube.com/watch?v={{ $url }}"  aspect-ratio="16:9" />
            </div>
        </div>
    </main>
@endsection




