@extends('Layout.master')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>DASHBOARD</h2>
            </div>

            <!-- Widgets -->
            <div class="row clearfix">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="info-box bg-navy text-black hover-expand-effect">
                        <div class="icon bg-blue">
                            <i class="material-icons">people</i>
                        </div>
                        <div class="content">
                            <div class="text">Total Number Of Users</div>
                            <div class="number count-to" data-from="0" data-to="{{ $sumOfUsers }}" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="info-box bg-navy text-black hover-expand-effect">
                        <div class="icon bg-blue">
                            <i class="material-icons">people</i>
                        </div>
                        <div class="content">
                            <div class="text">New Users Today</div>
                            <div class="number count-to" data-from="0" data-to="{{ $sumOfUsersToday }}" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="info-box bg-navy text-black hover-expand-effect">
                        <div class="icon bg-blue">
                            <i class="material-icons">people</i>
                        </div>
                        <div class="content">
                            <div class="text">New Users This Week</div>
                            <div class="number count-to" data-from="0" data-to="{{ $sumOfUsersThisWeek }}" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="info-box bg-navy text-black hover-expand-effect">
                        <div class="icon bg-blue">
                            <i class="material-icons">people</i>
                        </div>
                        <div class="content">
                            <div class="text">Total Number Of Widgets</div>
                            <div class="number count-to" data-from="0" data-to="{{ $sumOfWidgets }}" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>



            </div>



        </div>
    </section>
@endsection
