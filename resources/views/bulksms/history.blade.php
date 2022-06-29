@extends('layouts.app')

@section('title', 'New Lead')

@section('page_title')
    Bulk Message History <small>History of bulk messages.</small> <a href="{{ URL::to('bulk') }}" class="btn btn-success btn-sm">+ Create a Bulk Message</a>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Bulk Message</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">
                    <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                        <thead>
                            <tr role="row">
                                <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" style="width: 10px;">ID</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Industry</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Message</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Date Sent</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($message as $item)
                        <tr>
                            <td>{{$item->id}}.</td>
                            <td>{{$item->industry}}</td>
                            <td>{{$item->message}}</td>
                            <td>{{ $item->created_at }}</td>
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
