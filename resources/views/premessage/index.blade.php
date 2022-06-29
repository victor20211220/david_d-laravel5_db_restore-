@extends('layouts.app')

@section('title', 'Predefined Messages')

@section('page_title')
    Pre-defined Messages <small>Messages to speed up the process</small> <a href="{{ URL::to('premessages/create') }}" class="btn btn-primary btn-sm">+ Create Message</a>
@endsection

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Pre-defined Messages</h3>
                </div>
                <div class="box-body no-padding">
                    <table class="table table-bordered">
                        <thead>
                            <th style="width: 10px;">ID:</th>
                            <th>Name:</th>
                            <th>Message:</th>
                            <th style="width: 60px;">Action:</th>
                            <th style="width: 60px;">Delete:</th>
                        </thead>
                        <tbody>
                        @foreach($premessage as $item)
                            <tr>
                                <td>{{$item->id}}.</td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->message}}</td>
                                <td><a href="{{ URL::to('/premessages/'.$item->id.'/edit') }}" class="btn btn-success">Edit</a></td>
                                <td><a href="{{ URL::to('/premessages/destroy/'.$item->id) }}" class="btn btn-danger">Delete</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection