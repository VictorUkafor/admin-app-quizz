<script>
    @if(Session::has('successMessage'))
        let message = ` {{Session::get('successMessage')}} `;
        alertify.success(message);
        {{Session::forget('successMessage')}}
    @endif

    @if(Session::has('errorMessage'))
        let message = ` {{Session::get('errorMessage')}} `;
        alertify.error(message);
        {{Session::forget('errorMessage')}}
    @endif

</script>
