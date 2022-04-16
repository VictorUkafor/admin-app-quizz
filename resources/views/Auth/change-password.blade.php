@extends('Layout.auth-layout')
@section('content')

<div class="col-lg-7 col-sm-12 col-sm-12 col-pad-0 align-self-center">
    <div class="login-inner-form">
        <div class="details">
            <h3>Change Password Login</h3>
            <form class="login100-form validate-form" action="{{route('auth.password.update')}}" method="POST">
                @csrf
                @include('Includes.messages')
                <div class="form-group">
                    <input type="password" name="password" class="input-text" placeholder="New Password">
                </div>
                <div class="form-group">
                    <input type="password" name="password_confirmation" class="input-text" placeholder="Re Enter New Password">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn-md btn-theme btn-block">Change Password</button>
                </div>
            </form>
            <p>Already a member?<a href="{{ route('login') }}"> Login here</a></p>
        </div>
    </div>
</div>
@endsection
