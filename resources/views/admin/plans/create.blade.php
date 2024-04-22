@extends('layouts.madmin')
@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Nuevo plan</h1>
    <a class="btn btn-danger btn-sm float-end" href="{{ route('admin.plans.index') }}" title="Volver"><i class="bi bi-arrow-return-left"></i> Volver</a>
</div>
@if ($errors->any())
<div class="alert alert-danger" role="alert">
  <ul class="mb-0">
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif
<div class="row">
    <div class="col-12 col-xl-12">
      <div class="card mb-4">
        <div class="card-body">
          <form method="POST" action="{{ route('admin.plans.store') }}">
            {{ csrf_field() }}

            <div class="row mb-3">
              <div class="col-12 col-lg-6">
                <div class="form-group">
                  <label for="input-start" class="h5 mb-2">{{ __('plans.form.public.label') }}</label>
                  <select class="form-control" id="select-public" aria-describedby="input-public-help" name="public" required>
                    <option value="1">{{ __('plans.form.public.public') }}</option>
                    <option value="0">{{ __('plans.form.public.private') }}</option>
                  </select>
                  <small id="input-public-help" class="form-text text-muted">{{ __('plans.form.public.help') }}</small>
                </div>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-12 col-lg-6">
                <div class="form-group">
                  <label for="input-start" class="h5">{{ __('plans.form.name.label') }}</label>
                  <input class="form-control" name="name" id="input-name" aria-describedby="input-name-help" placeholder="{{ __('plans.form.name.placeholder') }}" required />
                  <small id="input-name-help" class="form-text text-muted">{{ __('plans.form.name.help') }}</small>
                </div>
              </div>

              <div class="col-12 col-lg-6">
                <div class="form-group">
                  <label for="input-start" class="h5">{{ __('plans.form.title.label') }}</label>
                  <input class="form-control" name="title" id="input-title" aria-describedby="input-title-help" required placeholder="{{ __('plans.form.title.placeholder') }}" />
                  <small id="input-title-help" class="form-text text-muted">{{ __('plans.form.title.help') }}</small>
                </div>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-12 col-lg-6">
                <div class="form-group">
                  <label for="input-start" class="h5">{{ __('plans.form.months.label') }}</label>
                  <input class="form-control" type="number" name="months" id="input-months" required />
                </div>
              </div>

              <div class="col-12 col-lg-6">
                <div class="form-group">
                  <label for="input-start" class="h5">{{ __('plans.form.monthly-price.label') }}</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">S/</span>
                    </div>
                    <input type="number" name="monthly_price" class="form-control" aria-describedby="input-monthly-price-help">
                    <div class="input-group-append">
                      <span class="input-group-text">,00</span>
                    </div>
                  </div>
                  <small id="input-monthly-price-help" class="form-text text-muted">{{ __('plans.form.monthly-price.help') }}</small>
                </div>
              </div>
            </div>
            <div class="col-lg-12 text-center mt-4">
                <button type="button" data-toggle="modal" data-target="#modal-plan-create" class="btn btn-primary w-75">{{ __('plans.create') }}</button>
            </div>
            <div class="modal" id="modal-plan-create" tabindex="-1">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">{{ __('plans.create') }}</h5>
                  </div>
                  <div class="modal-body">
                    <div class="mb-2">
                      {{ __('plans.create-modal.description-line-1') }}
                    </div>
                    <div>
                      {{ __('plans.create-modal.description-line-2') }}
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">{{ __('generic.cancel') }}</button>
                    <button type="submit" class="btn btn-outline-primary">
                      {{ __('plans.create') }}
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
</div>
@endsection
