@extends('layouts.app')

@section('title', 'Bulk SMS')

@section('page_title')
    Create Bulk SMS/Email <small>Send a large batch SMS/Email.</small>
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Bulk SMS/Email</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">

                    {{ Html::ul($errors->all()) }}

                    {{ Form::open(array('url' => 'bulksms')) }}

                    <div class="form-group">
                        {{ Form::label('subject', 'Subject') }}
                        {{ Form::text('subject', Input::old('subject'), array('class' => 'form-control')) }}
                    </div>

                    <div class="form-group">
                        {{ Form::label('message', 'Message') }}
                        <textarea name="message" class="form-control"></textarea>
                    </div>

                    <div class="form-group">
                        {{ Form::label('industry', 'Industry') }}
                        <select class="form-control lead_industry" name="industry[]" multiple="multiple" size="10"></select>
                    </div>

                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary" value="Send">Send</button>
                    {{ Form::close() }}
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>

    <script type="text/javascript">
        // Industries
        var jsonIndustry = "{{$industry}}";
        var textIndustry = jsonIndustry.replace(/&quot;/g, '"');
        var resultIndustry = JSON.parse(textIndustry);

        $.each(resultIndustry, function(key, value){
            $('.lead_industry').append($('<option value="'+key+'"></option>').html(key));
            $.each(resultIndustry[key], function(key0, value0){
                $('.lead_industry').append($('<option value="'+value0+'"></option>').html("--"+value0));
            });
        });
    </script>

@endsection