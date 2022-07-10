@extends('Layout.user')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>Account Settings </h2>
            </div>
            <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="header">
                                <h2>
                                    CHANGE SETTINGS
                                </h2>
                            </div>
                            <div class="body">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs tab-nav-right" role="tablist">
                                    <li role="presentation" class="active"><a href="#home" data-toggle="tab">ACCOUNT DETAILS</a></li>
                                    <li role="presentation"><a href="#profile" data-toggle="tab">PASSWORD</a></li>
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane fade in active" id="home">
                                        <form action="{{ route('user.settings.edit') }}" method="POST">
                                                @csrf
                                            <!-- Modal body -->
                                            {{-- <div class="card-body"> --}}
                                                <div class="form-group">
                                                    <label>Full Name</label>
                                                    <input
                                                        type="hidden" class="form-control"
                                                        name="user_id" id="user_id" value="{{ Auth::user()->user_id }}"/>
                                                    <div class="form-line">
                                                        <input type="text" class="form-control"
                                                            name="name" id="name"
                                                            value="{{ Auth::user()->name }}"
                                                            placeholder="Enter User Full Name" required/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <div class="form-line">
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            name="email" id="email"
                                                            value="{{ Auth::user()->email }}"
                                                            placeholder="Enter User Email" required/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Mobile</label>
                                                    <div class="form-line">
                                                        <input type="text"
                                                            class="form-control"
                                                            name="mobile" id="mobile"
                                                            value="{{ Auth::user()->mobile }}"
                                                            placeholder="Enter User Mobile" />
                                                    </div>
                                                </div>



                                            {{-- </div> --}}

                                            <!-- Modal footer -->
                                            <div class="card-footer">
                                                <button type="submit" class="btn btn-info">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div role="tabpanel" class="tab-pane fade" id="profile">
                                        <form action="{{ route('user.settings.password.edit') }}" method="POST">
                                            @csrf
                                            <!-- Modal body -->
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label>Password</label>
                                                    <input type="hidden" class="form-control" name="user_id" value="{{ Auth::user()->user_id }}"/>
                                                    <div class="form-line">
                                                        <input type="password" class="form-control" name="password" placeholder="Enter User Password" required/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Confirm Password</label>
                                                    <div class="form-line">
                                                        <input type="password" class="form-control" name="confirm_password" placeholder="Confirm User Password" required/>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Modal footer -->
                                            <div class="card-footer">
                                                <button type="submit" class="btn btn-warning">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </section>
@endsection
