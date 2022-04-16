@extends('Layout.auth-layout')
@section('content')
<div class="col-lg-7 col-sm-12 col-pad-0 align-self-center">
    <div class="login-inner-form">
        <div class="details">
            <h3>Create an account</h3>
            <form class="user" action="{{ route('auth.register') }}" method="POST">
                @csrf
                @include('Includes.messages')
                <div class="form-group">
                    <input type="text" name="name" class="input-text" placeholder="Full Name">
                </div>
                <div class="form-group">
                    <input type="email" name="email" class="input-text" placeholder="Email Address">
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="input-text" placeholder="Password">
                </div>
                <div class="form-group">
                    <input type="password" name="password_confirmation" class="input-text" placeholder="Confirm Password">
                </div>
                <div class="checkbox clearfix">
                    <div class="form-check checkbox-theme">
                        <input class="form-check-input" type="checkbox" value="" id="termsOfService">
                        <label class="form-check-label" for="termsOfService">
                            I agree to the<a href="#" class="terms">terms of service</a>
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn-md btn-theme btn-block">Register</button>
                </div>
            </form>
            <p>Already a member? <a href="{{ route('login') }}">Login here</a></p>
        </div>
    </div>
</div>
@endsection