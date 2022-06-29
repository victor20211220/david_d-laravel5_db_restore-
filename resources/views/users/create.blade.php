@extends('layouts.app')

@section("title", "Create User")

@section("page_title")
    Create User <small>Create a new user account.</small> <a href="{{ URL::to('users') }}" class="btn btn-default btn-sm">< Back</a>
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            {{ Html::ul($errors->all()) }}

            {{ Form::open(array('url' => 'users/store')) }}
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Create User</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">
                    <div class="form-group">
                        {{ Form::label('user_name', 'Full Name') }}
                        {{ Form::text('user_name', Input::old('user_name'), array('class' => 'form-control', 'placeholder' => 'Full Name')) }}
                    </div>
                    <div class="form-group">
                        {{ Form::label('user_email', 'Email Address') }}
                        {{ Form::text('user_email', Input::old('user_email'), array('class' => 'form-control', 'placeholder' => 'Email Address')) }}
                    </div>
                    <div class="form-group">
                        {{ Form::label('user_password', 'Password') }}
                        <input type="password" name="user_password" class="form-control" placeholder="Password" />
                    </div>
                    <div class="form-group">
                        {{ Form::label('user_role', 'Role') }}
                        <select name="user_role" class="form-control">
                            <option value="admin">Admin</option>
                            <option value="operator">Operator</option>
                        </select>
                    </div>
                </div>

                <div class="box-footer">
                    {{ Form::submit('Register User', array('class' => 'btn btn-primary')) }}
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        {{ Form::close() }}
    </div>

    </div>

@endsection