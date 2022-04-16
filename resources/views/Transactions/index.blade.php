@extends('Layout.master')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>Payment Transaction Logs </h2>
            </div>
            <!-- Basic Examples -->
            <div class="row clearfix">
                @include('Includes.admin-messages')
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Payment Transaction Logs
                            </h2>
                            <ul class="header-dropdown m-r--5">
                                <li>
                                    <!-- <button class="btn btn-success">Export</button> -->
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Order ID</th>
                                            <th>Amount</th>
                                            <th>Gateway</th>
                                            <th>Status</th>
                                            <th>Type</th>
                                            <th>Created</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($transactions as $transaction)
                                            <tr>
                                                <td>{{ $transaction->subscriber_name }}</td>
                                                <td>
                                                    {{ $transaction->subscriber_email }}
                                                </td>
                                                <td>{{ $transaction->txn_id }}</td>
                                                <td>{{ $transaction->amount }}</td>
                                                <td>{{ $transaction->payment_gateway }}</td>
                                                <td>{{ $transaction->payment_status }}</td>
                                                <td>{{ $transaction->subscription_type }}</td>
                                                <td>{{ $transaction->created_at }}</td>
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
   
@endsection
@section('scripts')
@endsection
