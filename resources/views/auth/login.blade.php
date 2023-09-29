@extends('layouts.auth')

@section('main-content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">{{ __('Sistem Seleksi Penentuan Calon Penerima PKH') }}</h1>
                                </div>

                                @if ($errors->any())
                                    <div class="alert alert-danger border-left-danger" role="alert">
                                        <ul class="pl-4 my-2">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('login') }}" class="user">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-user" name="email" placeholder="{{ __('E-Mail Address') }}" value="{{ old('email') }}" required autofocus>
                                    </div>

                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="password" class="form-control form-control-user" name="password" id="password" placeholder="{{ __('Password') }}" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text bg-transparent border-1" style="border-radius: 0 100rem 100rem 0;">
                                                    <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>                                                                                                            
                                    
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success btn-user btn-block" id="login-button" enabled>
                                            {{ __('Login') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        $(".toggle-password").click(function () {
            const passwordField = $($(this).attr("toggle"));
            const icon = $(this);
            const loginButton = $('#login-button'); // Select the login button

            // Toggle password visibility
            if (passwordField.attr("type") === "password") {
                passwordField.attr("type", "text");
                // Change icon to slashed eye
                icon.removeClass("fa-eye").addClass("fa-eye-slash");
                // Disable the login button
                loginButton.attr("disabled", true);
            } else {
                passwordField.attr("type", "password");
                // Change icon to open eye
                icon.removeClass("fa-eye-slash").addClass("fa-eye");
                // Enable the login button
                loginButton.attr("disabled", false);
            }
        });
    </script>
@endsection
