@extends('layouts.madmin')
@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Categorías</h1>
</div>
@if (session('status'))
<div class="alert alert-info alert-dismissible fade show" role="alert">
  <span class="alert-inner--text">{{ session('status') }}</span>
  <button type="button" class="close" data-dismiss="alert" aria-label="{{ __('generic.close') }}">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif
<div class="row">
  <div class="col-12 mb-4">
    <div class="card">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-centered table-nowrap mb-0 rounded">
            <thead class="thead-light">
              <tr>
                <th class="border-0">{{ __('#') }}</th>
                <th class="border-0">{{ __('question-categories.name') }}</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($question_categories as $question_category)
              <tr>
                <td class="border-0">{{ $question_category->id }}</td>
                <td class="border-0 font-weight-bold">{{ $question_category->name }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
