
@if(count($errors)>0)
    <div class="alert alert-danger col-md-12 text-left">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
    <div class="clearfix"></div>
@endif
@section('notifications')
    <script>
        @if(Session::has('successMessage'))
            alertify.success(` {{Session::get('successMessage')}} `);
            {{Session::forget('successMessage')}}
        @endif

        @if(Session::has('errorMessage'))
            alertify.error(` {{Session::get('errorMessage')}} `);
        {{Session::forget('errorMessage')}}
        @endif

    </script>
@endsection
