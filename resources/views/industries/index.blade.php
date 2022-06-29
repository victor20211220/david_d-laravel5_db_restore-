@extends('layouts.app')

@section('title', 'Industries')

@section('page_title')
    Manage Industries <small>List of industries.</small> <a href="{{ URL::to('industries/create/category') }}" class="btn btn-primary btn-sm">+ Create a Category</a> <a href="{{ URL::to('industries/create') }}" class="btn btn-success btn-sm">+ Create a Industry</a>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Categories</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body no-padding">
                    <table class="table sortableTable">
                        <tbody>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Name</th>
                            <th>Industry</th>
                            <th style="width: 80px">Actions</th>
                            <th style="width: 60px">Delete</th>
                        </tr>
                        @foreach($category as $item1)
                        <tr>
                            <td>{{$item1->id}}.</td>
                            <td>{{$item1->category}}</td>
                            <td>{{$item1->industry}}</td>
                            <td><a class="btn btn-small btn-primary btn-sm" href="{{URL::to('industries/category/'.$item1->id.'/edit')}}">Edit</a></td>
                            <td><a class="btn btn-small btn-danger btn-sm" href="{{ URL::to('category/delete/' . $item1->id) }}">Delete</a></td>
                        </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
        </div>

        <div class="col-md-4">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Industries</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body no-padding">
                    <table class="table">
                        <tbody>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Name</th>
                            <th style="width: 70px">Actions</th>
                            <th style="width: 60px">Delete</th>
                        </tr>
                        @foreach($industry as $item)
                        <tr>
                            <td>{{$item->id}}.</td>
                            <td>{{$item->industry}}</td>
                            <td><a class="btn btn-small btn-primary btn-sm" href="{{ URL::to('industries/' . $item->id . '/edit') }}">Edit</a></td>
                            <td><a class="btn btn-small btn-danger btn-sm" href="{{ URL::to('industries/delete/' . $item->id) }}">Delete</a></td>
                        </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
        </div>

    </div>
@endsection
