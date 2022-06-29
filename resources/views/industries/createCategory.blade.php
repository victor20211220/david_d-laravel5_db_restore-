@extends('layouts.app')

@section('title', 'Create Category')

@section('page_title')
    Create Category <small>Create a new Category.</small> <a href="{{ URL::to('industries') }}" class="btn btn-default btn-sm">< Back</a>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            {{ Html::ul($errors->all()) }}

            {{ Form::open(array('url' => 'industries/createCategory')) }}
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Industry</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">

                    <div class="form-group">
                        {{ Form::label('category_name', 'Category Name') }}
                        {{ Form::text('category_name', Input::old('category_name'), array('class' => 'form-control')) }}
                    </div>
                    <div class="form-group">
                        {{ Form::label('category_industry', 'Category Industry') }}
                        <select name="category_industry" class="form-control">
                            @foreach($industry as $item)
                                <option value="{{$item->id}}">{{$item->industry}}</option>
                                @endforeach
                        </select>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    {{ Form::submit('Create Category', array('class' => 'btn btn-primary')) }}
                </div>
            </div>
            {{ Form::close() }}
        </div>

    </div>
@endsection
