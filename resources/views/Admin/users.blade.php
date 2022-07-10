@extends('Layout.master')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>User Management </h2>
            </div>
            <!-- Basic Examples -->
            <div class="row clearfix">
                    @include('Includes.admin-messages')
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Users
                            </h2>
                            <ul class="header-dropdown m-r--5">
                                <li><button class="btn btn-success" data-toggle="modal" data-target="#createModal">Add User</button></li>
                            </ul>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>User Name</th>
                                            <th>User Email</th>
                                            <th>User Role</th>
                                            <!-- <th>Units</th> -->
                                           
                                            <th>User Active</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->user_type }}</td>
                                                <!-- <td>{{ $user->quota }}</td> -->
                                                <td>{{ ($user->is_active)? "active" : "not active" }}</td>
                                                <td>
                                                    <button
                                                        class="btn btn-info edit-user"
                                                        data-toggle="modal"
                                                        data-target="#editModal"
                                                        data-user="{{ $user }}"
                                                    >Edit</button>
                                                    <a
                                                        href="{{ route('admin.users.subscriptions', $user->user_id) }}"
                                                        class="btn btn-primary edit-access"
                                                    >Subscription</a>
                                                    <button
                                                        class="btn btn-default edit-password"
                                                        data-toggle="modal"
                                                        data-user="{{ $user }}"
                                                        data-target="#passwordModal"
                                                    >Password</button>

                                                    <button
                                                        class="btn btn-danger delete-user"
                                                        data-user="{{ $user }}"
                                                        href="javascript:;"
                                                    >Delete</button>

                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Basic Examples -->
        </div>

        <div class="modal fade" id="createModal">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Create User</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <form action="{{ route('admin.users.add') }}" method="POST">
                        @csrf
                        <!-- Modal body -->
                        <div class="modal-body">
                            <div class="form-group">
                                <label> User Full Name</label>
                                <div class="form-line">
                                    <input type="text" class="form-control" name="name" placeholder="Enter User Full Name" required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label> User Email</label>
                                <div class="form-line">
                                    <input type="text" class="form-control" name="email" placeholder="Enter User Email" required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label> User Mobile</label>
                                <div class="form-line">
                                    <input type="text" class="form-control" name="mobile" placeholder="Enter User Mobile" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label> User Role</label>
                                <select name="user_type" class="form-control">
                                    <option value="" disabled selected>Select User Role</option>
                                    <option value="member">Member</option>
                                    <option value="support">Support</option>
                                    <option value="reviewer">Reviewer</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label> User Status</label>
                                <select name="is_active" class="form-control">
                                    <option value="" disabled selected>Select User Status</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>

                            <!-- <div class="form-group">
                                <label> Units</label>
                                <div class="form-line">
                                    <input type="text" class="form-control" name="quota" placeholder="Units" />
                                </div>
                            </div> -->

                            <div class="form-group">
                                <label> User Password</label>
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
                        <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-info">Submit</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        <div class="modal fade" id="editModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Edit User</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <form action="{{ route('admin.users.edit') }}" method="POST">
                        @csrf
                        <!-- Modal body -->
                        <div class="modal-body">
                            <div class="form-group">
                                <label> User Full Name</label>
                                <input type="hidden" class="form-control" name="user_id" id="user_id"/>
                                <div class="form-line">
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter User Full Name" required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label> User Email</label>
                                <div class="form-line">
                                    <input type="text" class="form-control" name="email" id="email" placeholder="Enter User Email" required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label> User Mobile</label>
                                <div class="form-line">
                                    <input type="text" class="form-control" name="mobile" id="mobile" placeholder="Enter User Mobile" />
                                </div>
                            </div>
                            <div class="form-group" id="user_type_container">
                                <label> User Role</label>
                                <select name="user_type" id="user_type" class="form-control">
                                    <option value="" disabled selected>Select User Role</option>
                                    <option value="member">Member</option>
                                    <option value="support">Support</option>
                                    <option value="reviewer">Reviewer</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                            <div class="form-group" id="user_is_active_container">
                                <label> User Status</label>
                                <select name="is_active" id="user_is_active" class="form-control">
                                    <option value="" disabled selected>Select User Status</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>

                            <!--  <div class="form-group">
                                <label> Units</label>
                                <div class="form-line">
                                    <input type="text" class="form-control" name="quota" id="quota" placeholder="Units" />
                                </div>
                            </div> -->




                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-info">Submit</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        <!-- The Modal -->
        <div class="modal fade" id="passwordModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Edit User Password</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <form action="{{ route('admin.users.edit.password') }}" method="POST">
                        @csrf
                        <!-- Modal body -->
                        <div class="modal-body">
                            <div class="form-group">
                                <label> User Password</label>
                                <input type="hidden" class="form-control" name="user_id" id="pass_user_id"/>
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
                        <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-info">Submit</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>

@endsection
@section('scripts')
<script>
    $(".edit-user").on('click', function(){
        let user = $(this).data('user');
        $("#name").val(user.name);
        $("#user_id").val(user.user_id);
        $("#email").val(user.email);
        $("#user_type").val(user.user_type);
        $("#mobile").val(user.mobile);
        $("#user_is_active").val(user.is_active);
        $("#quota").val(user.quota);
        // console.log($("#user_is_active_container").find('button').prop('title'));
        let activeButtonTitle = $("#user_is_active option:selected").text();
        $("#user_is_active_container").find('button').prop('title', activeButtonTitle);
        $("#user_is_active_container").find('.filter-option').text(activeButtonTitle);

        let userTypeButtonTitle = $("#user_type option:selected").text();
        $("#user_type_container").find('button').prop('title', userTypeButtonTitle);
        $("#user_type_container").find('.filter-option').text(userTypeButtonTitle);



    });

    $(".edit-password").on('click', function(){
        let user = $(this).data('user');
        $("#pass_user_id").val(user.user_id);
    });

    $(".delete-user").on('click', function(){
        let user = $(this).data('user');
        var r = confirm('Are you sure? This action is irreversable. Click Ok to proceed.');
        if (r) {
            window.location.href = "{{ url('/admin/users/delete') }}/"+user.user_id;
        }
    });
</script>

@endsection
