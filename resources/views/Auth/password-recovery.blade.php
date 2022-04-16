@extends('Layout.auth-layout')
@section('content')


<div class="col-lg-7 col-sm-12 col-sm-12 col-pad-0 align-self-center">
    <div class="login-inner-form">
        <div class="details">
            <h3>Recover your password</h3>
            <form class="login100-form validate-form" action="{{route('auth.password.recover')}}" method="POST">
                @csrf
                @include('Includes.messages')
                <div class="form-group">
                    <input type="email" name="email" class="input-text" placeholder="Email Address">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn-md btn-theme btn-block">Send Me Email</button>
                </div>
            </form>
            <p>Already a member?<a href="{{ route('login') }}"> Login here</a></p>
        </div>
    </div>
</div>
@endsection
