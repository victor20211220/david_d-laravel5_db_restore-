@extends('layouts.app')

@section("title", "Manage Users")

@section("page_title")
    Manage Users <small>Manage user accounts.</small> <a href="{{ URL::to('users/register') }}" class="btn btn-primary btn-sm">+ Create a User</a>
@endsection

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Manage Users</h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered" id="user">
                        <thead>
                        <th style="width: 10px;">ID:</th>
                        <th>Name:</th>
                        <th>Email:</th>
                        <th>User Role:</th>
                        <th>Date:</th>
                        <th style="width: 60px;">Delete:</th>
                        </thead>
                        <tbody>
                        @foreach($users as $item)
                            <tr>
                                <td>{{$item->id}}.</td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->email}}</td>
                                <td>{{$item->user_role}}</td>
                                <td>{{$item->updated_at}}</td>
                                <td><a href="{{URL::to("/users/delete/".$item->id)}}" class="btn btn-danger">Delete</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $('#user').dataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false
        });
    </script>
@endsection