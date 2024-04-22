@extends('layouts.admin')
@section('head.title', 'Administración - ' . config('app.name'))

@section('content')
    <x-title label="Importar Estudiantes" description="Importar estudiantes que vienen de Instituciones Educativas" previous-url="{{ route('admin.index') }}" />
    <main class="container-lg ml-0 px-0">
        <div class="card mb-12">
            <form id="import-csv-form" method="POST" action="{{ route('admin.import-students.import') }}" accept-charset="utf-8" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="file" name="file" placeholder="Choose file">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary" id="submit">Submit</button>
                    </div>
                </div>
            </form>

                @if (isset($students_added))
                    <div class="alert alert-success mt-3" role="alert">
                        Estudiantes nuevos registrados: {{ $students_added }}
                    </div>
                @endif

        </div>


    </main>
@endsection
