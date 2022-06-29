@extends('layouts.app')

@section('title', 'Free Lead')

@section('page_title')
    Lead: {{ $message->name }} <a href="{{ URL::to('freeleads') }}" class="btn btn-default btn-sm">< Back</a>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Lead Details</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                {{ Html::ul($errors->all()) }}

                {{ Form::open(array('url' => 'free/show/'.$message->id)) }}
                <div class="box-body">
                    <h2>{{ $message->name }}</h2>
                    <hr />
                    <p><strong>Phone: </strong>{{ $message->phone }}</p>
                    <p><strong>Phone Alt: </strong>{{ $message->phone_alt }}</p>
                    <p><strong>Email: </strong>{{ $message->email }}</p>
                    <p><strong>Email Alt: </strong>{{ $message->email_alt }}</p>
                    <p><strong>Area: </strong>{{ $message->area }}</p>
                    <p><strong>Industry: </strong>{{ $message->industry }}</p>
                    <p><strong>Message: </strong><br />{{ $message->message }}</p>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Move to Review</button>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

    <script>
        $(function () {
            $('#example2').DataTable();
        });
    </script>
@endsection