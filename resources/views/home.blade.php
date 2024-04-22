@extends('layouts.app')
@section('head.title', 'Inicio - ' . config('app.name'))
@section('page-script')
    <script>
        $(window).load(function(){

            $('#popup').modal('show');
        });
    </script>
@endsection
@section('content')
<x-facebook-customer-chat />
<x-title label="Hola, {{ $user->name }}" description="Éste es el resumen de tu preparación" />

<main>
  <div class="row">
    <div class="col-12">
      <x-card-recommended-action />
    </div>
  </div>

  <div class="row">
    <div class="col-12 col-lg-6 col-xl-5 order-lg-1">
      <x-card-user-exams-count :user="$user" />

      @if (Auth::user()->isSubscribed())
      <x-card-active-subscription :user="$user" />
      @else
      <x-card-upgrade />
      @endif

    </div>

    <div class="col-12 col-lg-6 col-xl-7 order-lg-0">
      <x-card-user-activity :user="$user" />
    </div>
  </div>


    <!--@if(!session()->has('modal'))
        <div class="modal fade" id="popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <img src="<?php echo e(asset('/img/promo/banner.jpg')); ?>"  />
                </div>
            </div>
        </div>
        {{ session()->put('modal','shown') }}
    @endif-->
</main>
@endsection
