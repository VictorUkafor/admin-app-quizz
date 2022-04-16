@extends('Layout.master')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>Webhooks </h2>
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
                                <li><button class="btn btn-success" data-toggle="modal" data-target="#createModal">Add Webhook</button></li>
                            </ul>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>Event</th>
                                            <th>URL</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($webhooks as $webhook)
                                            <tr>
                                                <td>{{ $webhook->event }}</td>
                                                <td>{{ $webhook->webhook_url }}</td>
                                                <td>
                                                    <button
                                                        class="btn btn-info edit-webhook"

                                                        data-toggle="modal"
                                                        data-target="#editModal"
                                                        data-webhook="{{ $webhook }}"
                                                    >Edit</button>
                                                    <button
                                                     data-webhook_id ="{{ $webhook->id }}"
                                                     data-url ="{{ route('admin.webhooks.delete', $webhook->id) }}"
                                                        class="btn btn-warning delete-webhook"
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
                        <h4 class="modal-title">Create Webhook</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <form action="{{ route('admin.webhooks.add') }}" method="POST">
                        @csrf
                        <!-- Modal body -->
                        <div class="modal-body">
                            <div class="form-group">
                                <label> Event</label>
                                <select name="event" class="form-control">
                                    <option value="" disabled selected>Select Event</option>
                                    @foreach ($events as $event)
                                        <option value="{{ $event["event"] }}">{{ $event["name"] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label> Webhook URL</label>
                                <div class="form-line">
                                    <input type="text" class="form-control" name="webhook_url" placeholder="Eg: https://example.io" required/>
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

        <!-- The Modal -->
        <div class="modal fade" id="editModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Webhook</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <form action="{{ route('admin.webhooks.update') }}" method="POST">
                        @csrf
                        <!-- Modal body -->
                        <div class="modal-body">
                            <div class="form-group" id="event-container">
                                <label> Event</label>
                                <select name="event" class="form-control" id="event">
                                    <option value="" disabled selected>Select Event</option>
                                    @foreach ($events as $event)
                                        <option value="{{ $event["event"] }}">{{ $event["name"] }}</option>
                                    @endforeach
                                </select>
                                <input type="hidden" class="form-control" name="webhook_id" id="webhook_id"/>
                            </div>
                            <div class="form-group">
                                <label> Webhook URL</label>
                                <div class="form-line">
                                    <input type="text" class="form-control" id="webhook_url" name="webhook_url" placeholder="Eg: https://example.io" required/>
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
@endsection
@section('scripts')
    <script>
        $(".edit-webhook").on('click', function(){
            let webhook = $(this).data('webhook');
            $("#event").val(webhook.event);
            $("#webhook_id").val(webhook.id);
            $("#webhook_url").val(webhook.webhook_url);

            let eventButtonTitle = $("#event option:selected").text();
            $("#event-container").find('button').prop('title', eventButtonTitle);
            $("#event-container").find('.filter-option').text(eventButtonTitle);
        });
        $(".delete-webhook").on('click', function(){
            let url = $(this).data('url');
            showConfirmMessage(url);
        });

        function showConfirmMessage(url) {
            swal({
                title: "Are you sure?",
                text: "This action cannot be undone!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            }, function () {
                window.location = url;
            });
        }

    </script>
@endsection
