@extends('layouts.app')

@section('title', 'New Lead')

@section('page_title')
    Manage Contractors <small>List a new lead.</small> <a href="{{ URL::to('contractors/create') }}" class="btn btn-success btn-sm">+ Create a Contractor</a>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Contractors List</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">
                    <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                        <thead>
                            <tr role="row">
                                <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" style="width: 10px;">ID</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Full Name</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Industries</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Areas</th>
                                <th style="width: 80px;">Actions</th>
                                <th style="width: 35px;">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($contractor as $item)
                        <tr>
                            <td>{{$item->id}}.</td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->industry}}</td>
                            <td>{{mb_strimwidth($item->area, 0, 100, "...")}}</td>
                            <td><a class="btn btn-small btn-primary btn-sm" href="{{ URL::to('contractors/'.$item->id.'/edit') }}">Edit</a></td>
                            <td><a class="btn btn-small btn-danger btn-sm" href="{{ URL::to('/contractors/delete/'.$item->id.'/') }}">Delete</a></td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>

    <script>
        $(function () {
            $('#example2').DataTable();
        });
    </script>
@endsection
