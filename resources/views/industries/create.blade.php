@extends('layouts.app')

@section('title', 'Industries')

@section('page_title')
    Create Industry <small>Create a new Industry.</small> <a href="{{ URL::to('industries') }}" class="btn btn-default btn-sm">< Back</a>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            {{ Html::ul($errors->all()) }}

            {{ Form::open(array('url' => 'industries')) }}
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Industry</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">

                    <div class="form-group">
                        {{ Form::label('industry_name', 'Industry Name') }}
                        {{ Form::text('industry_name', Input::old('industry_name'), array('class' => 'form-control')) }}
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    {{ Form::submit('Create Industry', array('class' => 'btn btn-primary')) }}
                </div>
            </div>
            {{ Form::close() }}
        </div>

    </div>
@endsection
