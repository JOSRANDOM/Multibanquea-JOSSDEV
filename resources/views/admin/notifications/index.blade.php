@extends('layouts.madmin')
@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Notificaciones</h1>
</div>
@if (session('status'))
<div class="alert alert-info alert-dismissible fade show" role="alert">
  <span class="alert-inner--text">{{ session('status') }}</span>
  <button type="button" class="close" data-dismiss="alert" aria-label="{{ __('generic.close') }}">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif

@endsection
