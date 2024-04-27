@extends('layouts.app')

@section('content')
<script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>
<div class="container">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-boton">
        <div class="custom-container">
            <dotlottie-player src="https://lottie.host/bece6595-3107-468b-94e3-023a7f7b61f7/grb0AkNbVG.json" background="transparent" speed="1" class="size-32" style="margin: 0 auto;" loop autoplay></dotlottie-player>
            <h1 style="color: black;">Conoce nuestro sistema de entrenamiento personalizado </h1>
        </div>
    </div>
</div>
@endsection
