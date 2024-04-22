@extends('layouts.app')
@section('inline_css')
<style>
.text-title{
    background-color: rgba(0,0, 0, 0.5);
    text-decoration: none!important;
    display: none;
    /* margin: -50px 0 0 0; */
}
.link-category:hover .text-title{
    display: block;
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}
.link-category:hover .text-title .txt-category{
    margin-top: 30%;
    color: white;
}

</style>
@endsection
@section('main-class', '')
@section('content')
<x-title label="Flash cards" previous-url="{{ route('home') }}" description="Listado de categorias para seleccionar" />

<main>
    <div class="card mb-4">
        <div class="card-body row">
            @foreach ($categories as $category)
            <div class="col-4 mb-3" style="position: relative">
                <a href="{{ route('flash-cards.category',['slug'=>$category->slug])}}" class="link-category">
                    <img src="{{ $category->image }}" alt="" class="w-100">
                    <div class="text-title">
                        <h5 class="text-center text-uppercase txt-category">{{ $category->name}}</h5>
                    </div>
                </a>
            </div>
            @endforeach

        </div>
    </div>
</main>
@endsection
