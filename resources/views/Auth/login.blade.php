@extends('Layout.auth-layout')
@section('content')

     <div class="col-lg-7 col-md-12 col-sm-12 col-pad-0 align-self-center">
        <div class="login-inner-form">
            <div class="details">
                <h3>Sign into your account</h3>
                 <form class="validate-form" action="{{ route('auth.login') }}" method="POST">
                    @csrf
                    @include('Includes.messages')
                    <div class="form-group">
                        <input type="email" name="email" class="input-text" placeholder="Email Address">
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="input-text" placeholder="Password">
                    </div>
                    <div class="checkbox clearfix">
                        <div class="form-check checkbox-theme">
                            <input class="form-check-input" type="checkbox" value="" id="rememberMe">
                            <label class="form-check-label" for="rememberMe">
                                Remember me
                            </label>
                        </div>
                        <a href="{{ route('auth.password.reset') }}">Forgot Password</a>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn-md btn-theme btn-block">Login</button>
                    </div>
                </form>
                <!-- <p>Powered by <a href="https://webidro.com"> Webidro Labs</a></p> -->
                <!-- <p>Don't have an account?<a href="register-17.html"> Register here</a></p> -->
            </div>
        </div>
    </div>

@endsection
