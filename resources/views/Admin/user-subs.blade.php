@extends('Layout.master')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>{{ $user->name }} Subscriptions </h2>
            </div>
            <!-- Basic Examples -->
            <div class="row clearfix">
                    @include('Includes.admin-messages')
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                    {{ $user->name }} Subscriptions
                            </h2>
                            <ul class="header-dropdown m-r--5">
                                <li><button class="btn btn-success" data-toggle="modal" data-target="#createModal">Add Sub</button></li>
                            </ul>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>Package Name</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>is Active</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($subs as $sub)
                                            <tr>
                                                <td>{{ $sub['package_name'] }}</td>
                                                <td>{{ $sub['start_date'] }}</td>
                                                <td>{{ $sub['end_date'] }}</td>
                                                <td>{{ ($sub['is_active'])? "active" : "not active" }}</td>
                                                <td>
                                                    <button
                                                        class="btn btn-info edit-user"
                                                        data-toggle="modal"
                                                        data-packageid="{{ $sub['package_id'] }}"
                                                        data-startdate="{{ $sub['start_date'] }}"
                                                        data-enddate="{{ $sub['end_date'] }}"
                                                        data-status="{{ ($sub['is_active'])? "1" : "0" }}"
                                                        data-target="#editModal"
                                                    >Edit Sub</button>

                                                     <button
                                                        class="btn btn-danger delete-sub"
                                                        data-query="{{ $sub['query'] }}"
                                                        data-userid="{{ $sub['user_id'] }}"
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
    </section>

    <!-- The Modal -->
    <div class="modal fade" id="createModal">
        <div class="modal-dialog">
            <div class="modal-content">

                    <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Create Subscription</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form action="{{ route('admin.users.subscriptions.add') }}" method="POST">
                    @csrf
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="form-group">
                            <label> Select Subscription Package</label>
                            <select name="subscription_package" class="form-control">
                                <option value="" disabled selected>Select Package</option>
                                @foreach ($packages as $package)
                                    <option value="{{ $package->id }}">{{ $package->package_name }}</option>
                                @endforeach

                            </select>
                            <input type="hidden" name="user_id" value="{{ $user->user_id }}" />
                        </div>

                        <div class="form-group">
                            <label> Set Duration</label>
                            <div class="input-daterange input-group" id="bs_datepicker_range_container">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="start_date" data-date-format="dd-mm-yyyy" value="{{ date('d-m-Y') }}" placeholder="Date start...">
                                </div>
                                <span class="input-group-addon">to</span>
                                <div class="form-line">
                                    <input type="text" class="form-control" name="end_date" data-date-format="dd-mm-yyyy" value="{{ date('d-m-Y') }}" placeholder="Date end...">
                                </div>
                            </div>

                        </div>

                        <div class="form-group">
                            <label> Subscription Status</label>
                            <select name="status" class="form-control">
                                <option value="" disabled selected>Select Subscription Status</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
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

    <!-- The Modal -->
    <div class="modal fade" id="editModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Edit Subscription</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form action="{{ route('admin.users.subscriptions.add') }}" method="POST">
                    @csrf
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="form-group">
                            <label> Set Duration</label>
                            <div class="input-daterange input-group bs_datepicker_range_container">
                                <div class="form-line">
                                    <input type="text" class="form-control" id="start" name="start_date" data-date-format="dd-mm-yyyy" value="{{ date('d-m-Y') }}" placeholder="Date start...">
                                </div>
                                <span class="input-group-addon">to</span>
                                <div class="form-line">
                                    <input type="text" class="form-control" id="end" name="end_date" data-date-format="dd-mm-yyyy" value="{{ date('d-m-Y') }}" placeholder="Date end...">
                                </div>
                            </div>
                            <input type="hidden" name="user_id" value="{{ $user->user_id }}" />
                            <input type="hidden" name="subscription_package" id="package_id" />

                        </div>

                        <div class="form-group" id="status-container">
                            <label> Subscription Status</label>
                            <select name="status" class="form-control" id="status">
                                <option value="" disabled selected>Select Subscription Status</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
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
@endsection

@section('scripts')
    <script>
        $(".edit-user").on('click', function(){

            $("#package_id").val($(this).data('packageid'));
            $("#start").val($(this).data('startdate'));
            $("#end").val($(this).data('enddate'));
            $("#status").val($(this).data('status'));

            let statusButtonTitle = $("#status option:selected").text();
            $("#status-container").find('button').prop('title', statusButtonTitle);
            $("#status-container").find('.filter-option').text(statusButtonTitle);
        });
        $(".delete-sub").on('click', function(){
            let query = $(this).data('query');
            let user_id = $(this).data('userid');
            var r = confirm('Are you sure? Click Ok to proceed.');
            if (r) {
                window.location.href = "{{ url('/admin/users/subscriptions/delete') }}/"+user_id+'/'+query;
            }
        });
    </script>
@endsection
