@extends('layouts.madmin')
@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Subcategorías</h1>
</div>

@if (session('status'))
<div class="alert alert-info alert-dismissible fade show" role="alert">
  <span class="alert-inner--text">{{ session('status') }}</span>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
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
                <th class="border-0">{{ __('question-subcategories.name') }}</th>
                <th class="border-0">{{ trans_choice('question-categories.question-category', 1) }}</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($question_subcategories as $question_subcategory)
              <tr>
                <td class="border-0">{{ $question_subcategory->id }}</td>
                <td class="border-0 font-weight-bold">{{ $question_subcategory->name }}</td>
                <td class="border-0">{{ $question_subcategory->question_category->name }}</td>
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
