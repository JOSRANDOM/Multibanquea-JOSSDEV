@extends('layouts.app')
@section('inline_css')
<style>
    .container{
        transform-style: preserve-3d;
    }

.container .box{
    position: relative;
    width: 30%;
    min-height: 300px;
    margin: 20px;
    transform-style: preserve-3d;
    perspective: 1000px;
    cursor: pointer;
}

.container .box .body{
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    transform-style: preserve-3d;
    transition: 0.9s ease;
}



.container .box .body .imgContainer{
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    transform-style: preserve-3d;
}

.container .box .body .imgContainer img{
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    /* object-fit: cover; */
}

.container .box .body .content{
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: #02555B;
    backface-visibility: hidden;
    transform-style: preserve-3d;
    transform: rotateY(180deg);
}
.container .box .body .content img{
    width: 100%;
    height: 100%;
}

.container .box:hover .body{
    transform: rotateY(180deg);
}

.container .box .body .content div{
    transform-style: preserve-3d;
    padding: 20px;
    background: linear-gradient(45deg, #FE0061,#FFEB3B);
    transform: translateZ(100px);
}

.container .box .body .content div h3{
    letter-spacing: 1px;
}
</style>
@endsection
@section('main-class', '')
@section('content')
<x-title label="Flash cards - {{ $category->name }}" previous-url="{{ route('flash-cards.index') }}" description="{{ $category->description }}" />

<main>
    <div class="card mb-4">
        <div class="container d-flex align-items-center justify-content-center flex-wrap">
            @foreach ($cards as $card)


            <div class="box">
                <div class="body">
                    <div class="imgContainer">
                        <img src="{{ $card->image_front_location }}" alt="">
                    </div>
                    <div class="content d-flex flex-column align-items-center justify-content-center imgBack">
                        <div>
                            <h3 class="text-white fs-5">{{ $card->name}}</h3>
                            <p class="fs-6 text-white">{{ $card->description}}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</main>
@endsection
