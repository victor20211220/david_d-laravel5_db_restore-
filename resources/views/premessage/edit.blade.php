@extends('layouts.app')

@section('title', 'Editing Predefined Messages')

@section('page_title')
    Editing Message <small>Edit pre-defined message</small>
@endsection

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Pre-defined Message</h3>
                </div>
                <div class="box-body">
                    {{ Html::ul($errors->all()) }}

                    {{ Form::open(array('url' => 'premessages/update/'.$message->id)) }}

                    <div class="form-group">
                        {{ Form::label('massage_name', 'Message Name') }}
                        {{ Form::text('massage_name', $message->name, array('class' => 'form-control', 'placeholder' => 'Message Name')) }}
                    </div>

                    <div class="form-group">
                        {{ Form::label('message', 'Message') }}
                        <textarea name="message" class="form-control" placeholder="Message" rows="8">{{$message->message}}</textarea>
                    </div>

                </div>
                <div class="box-footer">
                    {{ Form::submit('Edit Message', array('class' => 'btn btn-primary')) }}
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

@endsection