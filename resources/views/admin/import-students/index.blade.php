@extends('layouts.madmin')
@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Importar Estudiantes</h1>
</div>
@if (session('status'))
  <div class="alert alert-info alert-dismissible fade show" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="{{ __('generic.close') }}">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
@endif
@if (isset($students_added))
    <div class="alert alert-success mt-3" role="alert">
        Estudiantes nuevos registrados: {{ $students_added }}
    </div>
@endif
<div class="card mb-12">
    <div class="card-body">
        <div class="row">
            <form id="import-csv-form" method="POST" action="{{ route('admin.import-students.import') }}" accept-charset="utf-8" enctype="multipart/form-data">
                @csrf
                <div class="col-md-12">
                    <div class="form-group">
                        <input type="file" name="file" class="form-control" placeholder="Choose file">
                    </div>
                </div>
                <div class="col-md-12 text-center">
                    <button type="submit" class="btn btn-primary w-50" id="submit"><i class="bi bi-cloud-download"></i> Importar estudiantes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
