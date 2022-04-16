@extends('Layout.user')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>Subscription</h2>
            </div>
            <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="header">
                                <h2>
                                        Subscription
                                </h2>
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
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($subs as $sub)
                                                <tr>
                                                    <td>{{ $sub['package_name'] }}</td>
                                                    <td>{{ $sub['start_date'] }}</td>
                                                    <td>{{ $sub['end_date'] }}</td>
                                                    <td>{{ ($sub['is_active'])? "active" : "not active" }}</td>
                                                </tr>
                                            @endforeach

                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </section>
@endsection
