@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card">
                <div class="d-flex justify-content-center title">
                    <h1>{{ trans('both.login.login') }}</h1>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        @if (session('messenger'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('messenger') }}
                            </div>
                        @endif
                        <div class="md-form-group float-label margin">
                            <input id="email" type="email"
                                class="md-input @error ('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}"
                                autocomplete="email" autofocus
                                onkeyup="this.setAttribute('value', this.value);" required>
                            <label>{{ trans('both.login.email') }}</label>
                            @error ('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="md-form-group float-label margin">
                            <input id="password" type="password"
                                class="md-input @error ('password') is-invalid @enderror"
                                name="password" value="{{ old('email') }}"
                                autocomplete="current-password" autofocus
                                onkeyup="this.setAttribute('value', this.value);" required>
                            <label>{{ trans('both.login.password') }}</label>
                            @error ('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group row margin-left-4">
                            <div class="form-check">
                                <input class="form-check-input"
                                    type="checkbox" name="remember"
                                    id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    {{ trans('both.login.remember_me') }}
                                </label>
                            </div>
                        </div>
                        <div class="form-group row d-flex justify-content-center margin-tb">
                            <button type="submit" class="btn btn-primary width-100" id="btn-login">
                                {{ trans('both.login.login') }}
                            </button>
                            @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ trans('both.login.forgot') }}
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
