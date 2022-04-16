@extends('Layout.master')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>Subscription Packages </h2>
            </div>
            <!-- Basic Examples -->
            <div class="row clearfix">
                @include('Includes.admin-messages')
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Subscription Packages
                            </h2>
                            <ul class="header-dropdown m-r--5">
                                <li><button class="btn btn-success" data-toggle="modal" data-target="#createModal">Add Package</button></li>
                            </ul>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>Package Name</th>
                                            <th>Package Query</th>
                                            <th>Package Type</th>
                                            <th>Package Payment Type</th>
                                            <th>Package Active</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($packages as $package)
                                            <tr>
                                                <td>{{ $package->package_name }}</td>
                                                <td>
                                                    {{ $package->package_query }}
                                                </td>
                                                <td>{{ $package->package_type }}</td>
                                                <td>{{ $package->package_payment_type }}</td>
                                                <td>{{ ($package->is_active)? "active" : "not active" }}</td>
                                                <td style="width: 140px;">
                                                    <button
                                                        class="btn btn-info edit-package"
                                                        data-toggle="modal"
                                                        data-target="#editModal"
                                                        data-package="{{ $package }}"
                                                    >Edit</button>

                                                    <button
                                                        class="btn btn-danger delete-package"
                                                        data-package="{{ $package }}"
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
                    <h4 class="modal-title">Create Package</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form action="{{ route('admin.subscription.add') }}" method="POST">
                    @csrf
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="form-group">
                            <label> Package Name</label>
                            <div class="form-line">
                                <input type="text" class="form-control" name="package_name" placeholder="Enter Package Name"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label> Package Query</label>
                            <div class="form-line">
                                <input type="text" class="form-control" name="package_query" placeholder="Enter Package Query"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label> Package Type</label>
                            <select name="package_type" class="form-control">
                                <option value="" disabled selected>Select Package Type</option>
                                <option value="addon">Addon</option>
                                <option value="frontend">Front End</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label> Package Payment Type</label>
                            <select name="package_payment_type" class="form-control">
                                <option value="" disabled selected>Select Package Payment Type</option>
                                <option value="onetime">One Time</option>
                                {{-- <option value="daily">Daily</option>
                                <option value="weekly">Weekly</option> --}}
                                <option value="monthly">Monthly</option>
                                <option value="yearly">Yearly</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label> Package Dormancy</label>
                            <select name="package_dormancy" class="form-control">
                                <option value="" disabled selected>Select Package Dormancy</option>
                                <option value="true">Active</option>
                                <option value="false">Inactive</option>
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
                    <h4 class="modal-title">Edit Package</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form action="{{ route('admin.subscription.edit') }}" method="POST">
                    @csrf
                    <!-- Modal body -->
                    <div class="modal-body">
                        <label>Package Query</label>
                        <div class="form-group list-group">
                            <div class="list-group-item">
                                <b>JvZoo</b><br>
                                <span id="package_query_jvzoo"></span>
                            </div>
                            <div class="list-group-item">
                                <b>Worrior Plus</b><br>
                                <span id="package_query_worrior"></span>
                            </div>
                            <div class="list-group-item">
                                <b>Thrive Cart</b><br>
                                <span id="package_query_thrive"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label> Package Name</label>
                            <div class="form-line">
                                <input type="hidden" class="form-control" name="package_id" id="package_id"/>
                                <input type="text" class="form-control" name="package_name" id="package_name" placeholder="Enter Package Name"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label> Package Query</label>
                            <div class="form-line">
                                <input type="text" class="form-control" name="package_query" id="package_query" placeholder="Enter Package Query"/>
                            </div>
                        </div>
                        <div class="form-group" id="package_type_container">
                            <label> Package Type</label>
                            <select name="package_type" id="package_type" class="form-control">
                                <option value="" disabled selected>Select Package Type</option>
                                <option value="addon">Addon</option>
                                <option value="frontend">Front End</option>
                            </select>
                        </div>
                        <div class="form-group" id="package_payment_type_container">
                            <label> Package Payment Type</label>
                            <select name="package_payment_type" id="package_payment_type" class="form-control">
                                <option value="" disabled selected>Select Package Payment Type</option>
                                <option value="onetime">One Time</option>
                                {{-- <option value="daily">Daily</option>
                                <option value="weekly">Weekly</option> --}}
                                <option value="monthly">Monthly</option>
                                <option value="yearly">Yearly</option>
                            </select>
                        </div>
                        <div class="form-group" id="package_dormancy_container">
                            <label> Package Dormancy</label>
                            <select name="package_dormancy" id="package_dormancy" class="form-control">
                                <option value="" disabled selected>Select Package Dormancy</option>
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
        $(".delete-package").on('click', function(){
            let package = $(this).data('package');
            var r = confirm('Are you sure? Click Ok to proceed.');
            if (r) {
                window.location.href = "{{ url('/subscriptions/delete') }}/"+package.id;
            }
        });
        $(".edit-package").on('click', function(){
            let package = $(this).data('package');
            $("#package_name").val(package.package_name);
            $("#package_id").val(package.id);
            $("#package_query").val(package.package_query);


            $("#package_query_jvzoo").html("{{ url('api/payment/jvzoo') }}?sub_type="+package.package_query);

            $("#package_query_worrior").html("{{ url('api/payment/warriorplus') }}?sub_type="+package.package_query);

            $("#package_query_thrive").html("{{ url('api/payment/thrivecart') }}?sub_type="+package.package_query);


            $("#package_type").val(package.package_type);
            let packageTypeButtonTitle = $("#package_type option:selected").text();
            $("#package_type_container").find('button').prop('title', packageTypeButtonTitle);
            $("#package_type_container").find('.filter-option').text(packageTypeButtonTitle);


            $("#package_payment_type").val(package.package_payment_type);
            let packagePaymentTypeButtonTitle = $("#package_payment_type option:selected").text();
            $("#package_payment_type_container").find('button').prop('title', packagePaymentTypeButtonTitle);
            $("#package_payment_type_container").find('.filter-option').text(packagePaymentTypeButtonTitle);


            $("#package_dormancy").val(package.is_active);
            let packageDormancyButtonTitle = $("#package_dormancy option:selected").text();
            $("#package_dormancy_container").find('button').prop('title', packageDormancyButtonTitle);
            $("#package_dormancy_container").find('.filter-option').text(packageDormancyButtonTitle);

            console.log(package);

        });
    </script>
@endsection
