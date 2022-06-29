@extends('layouts.app')

@section('title', 'Follow Up')

@section('page_title')
    Lead: {{ $lead->name }} <a href="{{ URL::to('followup') }}" class="btn btn-default btn-sm">< Back</a>
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

                {{ Form::open(array('url' => 'followup/show/'.$lead->id)) }}
                <div class="box-body">
                    <h2>{{ $lead->name }}</h2>
                    <hr />
                    <p><strong>Phone: </strong>{{ $lead->phone }}</p>
                    <p><strong>Phone Alt: </strong>{{ $lead->phone_alt }}</p>
                    <p><strong>Email: </strong>{{ $lead->email }}</p>
                    <p><strong>Email Alt: </strong>{{ $lead->email_alt }}</p>
                    <p><strong>Area: </strong>{{ $lead->area }}</p>
                    <p><strong>Industry: </strong>{{ $lead->industry }}</p>
                    <p><strong>Message: </strong><br />{{ $lead->message }}</p>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Client Assisted</button>
                    <a href="{{ url('follow/notassisted/'.$lead->id) }}" class="btn btn-success pull-right">Client not assisted</a>
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