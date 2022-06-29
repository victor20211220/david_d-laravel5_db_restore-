@extends('layouts.app')

@section('title', 'Messages')

@section('page_title')
    Messages <small>Leads to be reviewed.</small>
@endsection

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Review Messages</h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered" id="messages">
                        <thead>
                        <th style="width: 10px;">ID:</th>
                        <th>Name:</th>
                        <th>Message:</th>
                        <th>Type:</th>
                        <th>Status:</th>
                        <th>Date:</th>
                        <th style="width: 60px;">Action:</th>
                        <th style="width: 60px;">Delete:</th>
                        </thead>
                        <tbody>
                        @foreach($messages as $item)
                            <tr>
                                <td>{{$item->id}}.</td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->message}}</td>
                                <td>{{$item->type}}</td>
                                <td>{{$item->status}}</td>
                                <td>{{$item->updated_at}}</td>
                                <td>
                                    @if($item->status == "free")
                                        <a href="{{URL::to("/free/show/".$item->id)}}" class="btn btn-primary">Show</a>
                                    @endif
                                </td>
                                <td><a href="{{URL::to("/messages/delete/".$item->id)}}" class="btn btn-danger">Delete</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $('#messages').dataTable();
    </script>
@endsection