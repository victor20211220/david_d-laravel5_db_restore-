@extends('layouts.app')

@section('title', 'Create Predefined Messages')

@section('page_title')
    Create Message <small>Create new pre-defined message</small>
@endsection

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Pre-defined Messages</h3>
                </div>
                <div class="box-body">
                    {{ Html::ul($errors->all()) }}

                    {{ Form::open(array('url' => 'premessages')) }}

                    <div class="form-group">
                        {{ Form::label('massage_name', 'Message Name') }}
                        {{ Form::text('massage_name', Input::old('massage_name'), array('class' => 'form-control', 'placeholder' => 'Message Name')) }}
                    </div>

                    <div class="form-group">
                        {{ Form::label('message', 'Message') }}
                        <textarea name="message" class="form-control" placeholder="Message" rows="8"></textarea>
                    </div>

                </div>
                <div class="box-footer">
                    {{ Form::submit('Create Message', array('class' => 'btn btn-primary')) }}
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

@endsection