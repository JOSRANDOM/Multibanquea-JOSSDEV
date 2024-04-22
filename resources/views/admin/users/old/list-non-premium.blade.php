@extends('layouts.app')

@section('content')
<x-title label="{{ __('users.not-premium-users') }}" previous-url="{{ route('admin.users.index') }}" />

<main class="container-lg ml-0 px-0">
  @if (session('status'))
  <div class="alert alert-info alert-dismissible fade show" role="alert">
    <span class="alert-inner--text">{{ session('status') }}</span>
    <button type="button" class="close" data-dismiss="alert" aria-label="{{ __('generic.close') }}">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif

  <div class="row">
    <div class="col-12 col-xl-4">
      <div class="card mb-4">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="icon icon-shape icon-md icon-shape-primary rounded mr-4 p-4">
              <span class="fas fa-users"></span>
            </div>
            <div>
              <h2 class="mb-0">{{ trans_choice('users.count', $users->count()) }}</h2>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card mb-4">
        <div class="card-body">
          <h2 class="h4 mb-4">{{ __('users.emails') }}</h2>
          <pre>Email Address&#9;Name<br>@foreach ($users as $user){{ $user->email }}&#9;{{ $user->name }}<br>{{ __('') }}@endforeach</pre>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12 mb-4">
      <div class="card">
        <div class="card-body">

          <div class="table-responsive">
            <table class="table table-centered table-nowrap table-striped mb-0 rounded">
              <thead class="thead-light">
                <tr>
                  <th class="border-0">{{ __('#') }}</th>
                  <th class="border-0">{{ __('users.name') }}</th>
                  <th class="border-0">{{ __('users.email') }}</th>
                  <th class="border-0">{{ __('users.registration-date') }}</th>
                  <th class="border-0"></th>
                </tr>
              </thead>
              <tbody>
                @foreach ($users as $user)
                <tr>
                  <td class="border-0">{{ $user->id }}</td>
                  <td class="border-0 font-weight-bold">
                    <div>{{ $user->name }}</div>
                    @if ($user->is_admin())
                    <div class="font-weight-normal text-success mt-1"><span class="fas fa-user-shield mr-2"></span>{{ __('users.admin') }}</div>
                    @endif
                    @if ($user->isSubscribed())
                    <div class="font-weight-normal text-warning mt-1"><span class="fas fa-unlock mr-2"></span>{{ __('plans.premium') }}</div>
                    @endif
                  </td>
                  <td class="border-0">{{ $user->email }}</td>
                  <td class="border-0">
                    @if ($user->created_at)
                    @formattedDate($user->created_at)
                    @endif
                  </td>
                  <td><a href="{{ route('admin.users.show', $user) }}" class="btn btn-primary float-right">{{ __('generic.details') }}</a></td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>
  </div>
</main>
@endsection
