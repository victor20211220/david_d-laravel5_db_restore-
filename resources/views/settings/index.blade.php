@extends('layouts.app')

@section('title', 'Settings')

@section('page_title')
    Settings <small>Set System Settings</small>
@endsection

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Settings</h3>
                </div>
                <div class="box-body">
                    {{ Html::ul($errors->all()) }}

                    {{ Form::open(array('url' => 'settings/save/')) }}

                    <input type="hidden" name="id" value="{{ $id }}">

                    <div class="form-group">
                        {{ Form::label('setting_disclosure', 'Disclosure Message') }}
                        {{ Form::text('setting_disclosure', $disclosure, array('class' => 'form-control', 'placeholder'=>'Full Name')) }}
                    </div>
                    <div class="form-group">
                        {{ Form::label('followup_email', 'Follow up email') }}
                        {{ Form::text('followup_email', $followup_email, array('class' => 'form-control', 'placeholder'=>'joe@example.com')) }}
                    </div>
                </div>
                <div class="box-footer">
                    {{ Form::submit('Save', array('class' => 'btn btn-primary')) }}
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

@endsection