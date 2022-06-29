@extends('layouts.app')

@section('title', 'Industry Edit')

@section('page_title')
    Edit Industry <small>Editing Industry.</small> <a href="{{ URL::to('industries') }}" class="btn btn-default btn-sm">< Back</a>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- if there are creation errors, they will show here -->
            {{ Html::ul($errors->all()) }}

            {{ Form::model($industry, array('route' => array('industries.update', $industry->id), 'method' => 'PUT')) }}
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Industry</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">

                    <div class="form-group">
                        {{ Form::label('industry', 'Industry Name') }}
                        {{ Form::text('industry', null, array('class' => 'form-control')) }}
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    {{ Form::submit('Update Industry', array('class' => 'btn btn-primary')) }}
                </div>
            </div>
            {{ Form::close() }}
        </div>

    </div>
@endsection
