@extends('layouts.app')

@section('title', 'Create Contractors')

@section('page_title')
    Create Contractor <small>Create a new Contractor.</small> <a href="{{ URL::to('contractors') }}" class="btn btn-default btn-sm">< Back</a>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            {{ Html::ul($errors->all()) }}

            {{ Form::open(array('url' => 'contractors/update/'.$contractor->id)) }}
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Contractor</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">

                    <div class="form-group">
                        {{ Form::label('contractor_name', 'Contractor Name') }}
                        {{ Form::text('contractor_name', $contractor->name, array('class' => 'form-control')) }}
                    </div>
                    <div class="form-group">
                        {{ Form::label('contractor_email', 'Contractor Email(s)') }}
                        <div class="controls">
                            <div class="form">
                                <?php
                                    $emails = explode(',', $contractor->emails);
                                    foreach($emails as $item) {
                                        echo '<div class="entry input-group">
                                    <input class="form-control" name="contractor_email[]" type="email" value="'.$item.'">
                                    <span class="input-group-btn">
                                <button class="btn btn-flat btn-remove btn-danger" type="button">-</button>
                            </span>
                                </div>';
                                    }
                                ?>
                                <div class="entry input-group">
                                    {{ Form::email('contractor_email[]', Input::old('email'), array('class' => 'form-control')) }}
                                    <span class="input-group-btn">
                                <button class="btn btn-success btn-add btn-flat" type="button">+</button>
                            </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('contractor_phone', 'Contractor Phone(s)') }}
                        <div class="controls-phone">
                            <div class="form-phone">
                                <?php
                                $phones = explode(',', $contractor->phones);
                                foreach($phones as $item) {
                                    echo '<div class="entry-phone input-group">
                                    <input class="form-control" name="contractor_phone[]" type="tel" value="'.$item.'">
                                    <span class="input-group-btn">
                                <button class="btn btn-flat btn-remove-phone btn-danger" type="button">-</button>
                            </span>
                                </div>';
                                }
                                ?>
                                <div class="entry-phone input-group">
                                    {{ Form::tel('contractor_phone[]', Input::old('phones'), array('class' => 'form-control')) }}
                                    <span class="input-group-btn">
                                <button class="btn btn-success btn-add-phone btn-flat" type="button">+</button>
                            </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('contractor_area', 'Contractor Area(s)') }}
                        <input type="hidden" value="{{ $contractor->area }}" class="contractor_area" name="contractor_area" />
                        <input type="hidden" value="{{ $contractor->overallArea }}" class="contractor_overall_area" name="contractor_overall_area" />
                        <input name="" id="tags" value="{{ $contractor->area }}" class="form-control" style="width: 100%;" />
                        <hr/>
                        <div class="row">
                            <div class="col-xs-3">
                                <p>Province:</p>
                                <select name="province" class="form-control province">
                                    <option></option>
                                </select>
                            </div>
                            <div class="col-xs-3">
                                <p>City:</p>
                                <select name="city" class="form-control city" disabled="true">
                                </select>
                            </div>
                            <div class="col-xs-3">
                                <p>Area:</p>
                                <select name="area" class="form-control area" multiple disabled="true">
                                </select>
                            </div>
                            <div class="col-xs-3">
                                <button id="addAreasBtn" type="button" class="btn btn-primary btn-block btn-flat" style="margin-top: 30px;">Add Area</button>
                                <button id="removeAreasBtn" type="button" class="btn btn-primary btn-block btn-flat" style="margin-top: 30px;">Remove Area</button>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('contractor_industry', 'Contractor Industry(s)') }}
                        <div class="row industries">

                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('contractor_leads', 'Number of leads') }}
                        {{ Form::text('contractor_leads', $contractor->leads_remaining, array('class' => 'form-control', 'placeholder' => '123')) }}
                    </div>

                    <div class="form-group">
                        {{ Form::label('contractor_lead_status', 'Leads Status') }}
                        <select name="contractor_lead_status" class="form-control">
                            <option value="0" <?php if($contractor->leads_status == 0){echo "selected";}?>>Active</option>
                            <option value="1" <?php if($contractor->leads_status == 1){echo "selected";}?>>Pause</option>
                        </select>
                    </div>
                </div>
            <!-- /.box-body -->
            <div class="box-footer">
                {{ Form::submit('Update Contractor', array('class' => 'btn btn-primary')) }}
            </div>
        </div>
        {{ Form::close() }}
    </div>

    </div>
    <script src="{{ URL::asset("tagging/jquery.tagsinput.js") }}"></script>
    <script type="text/javascript">
        function runTags() {
            $('#tags').tagsInput({
                'width':'100%',
                'height': '300px',
                'delimiter': ['+'],
                'defaultText': 'add area'
            });
        }

        runTags();

        var province;
        var city;
        var areas;

        // Locations
        var jsonData = "{{$areasJSON}}";
        var text = jsonData.replace(/&quot;/g, '"');
        var result = JSON.parse(text);

        // Industries
        var jsonIndustry = "{{$industry}}";
        var textIndustry = jsonIndustry.replace(/&quot;/g, '"');
        var resultIndustry = JSON.parse(textIndustry);

        var jsonSelectedCheckbox = <? echo json_encode(explode(',', $contractor->industry)); ?>;

        $.each( result, function( key1, value1 ) {
            $('.province').append( $('<option name="'+key1+'"></option>').html(key1) );
        });

        // Industry
        $.each(resultIndustry, function(key2, value2){
            var boxClass = key2.toLowerCase().replace(/ /g, '-');
            $('.industries').append($('<div class="col-xs-3 '+boxClass+'"></div>').html('<h4>'+key2+':</h4><hr />'));
            $.each(resultIndustry[key2], function(key, value){

                if(Object.values(jsonSelectedCheckbox).indexOf(""+key2+"+"+value) > -1) {
                    $('.'+boxClass+'').append('<div class="checkbox"><label><input type="checkbox" value="'+key2+'+'+value+'" name="contractor_industries[]" checked>'+value+'</label></div>');
                } else {
                    $('.'+boxClass+'').append('<div class="checkbox"><label><input type="checkbox" value="'+key2+'+'+value+'" name="contractor_industries[]">'+value+'</label></div>');
                }
            });
        });

        // Set the value for city based on province
        $('.province').on('change', function(){
            //alert("Hello");
            province = $('.province').val();
            $('.city').empty();
            $.each( result[province], function( key1, value1 ) {
                $('.city').append( $('<option name="'+key1+'"></option>').html(key1) );
                $('.city').attr("disabled", false);
            });
        });

        // Set the value for city based on province
        $('.city').on('change', function(){
            //alert("Hello");
            city = $('.city').val();
            $('.area').empty();
            $.each( result[province][city], function( key1, value1 ) {
                $('.area').append( $('<option name="'+key1+'"></option>').html(key1) );
                $('.area').attr("disabled", false);
            });
        });

        $('#addAreasBtn').on('click', function(){
            $('.area :selected').each(function(i, sel){
                var area = $(sel).val();
                //alert(area);
                console.log(""+result[province][city][area]);
                $.each( result[province][city][area], function( key1, value1 ) {

                    if($('#tags').tagExist(province + "," + city + "," + area + "," + value1) == true) {

                    } else {
                        $('#tags').attr("value", "" + $('#tags').attr("value") + "+" + province + "," + city + "," + area + "," + value1);
                        $('#tags').addTag("" + province + "," + city + "," + area + "," + value1);
                    }
                });
                var overallAreaTags = $('.contractor_overall_area').attr("value");
                $('.contractor_overall_area').attr("value", overallAreaTags+""+province + "," + city + "," + area + "/");
                console.log(overallAreaTags);
            });
            var current_tags = jQuery( '#tags' ).tagsInput()[0].value;
            $('.contractor_area').attr("value", current_tags);

        });

        $('#removeAreasBtn').on('click', function(){
            $('.area :selected').each(function(i, sel){
                var area = $(sel).val();
                //alert(area);
                console.log(""+result[province][city][area]);
                $.each( result[province][city][area], function( key1, value1 ) {
                    $('#tags').removeTag(""+province+","+city+","+area+","+value1);
                });
                var overallAreaTags = $('.contractor_overall_area').attr("value");
                var removeOverallArea = province+","+city+","+area+"/";
                var overallREmoved = overallAreaTags.replace(RegExp(removeOverallArea, "g"), '');
                console.log(overallREmoved);
                $('.contractor_overall_area').attr("value", overallREmoved);
            });
            var current_tags = jQuery( '#tags' ).tagsInput()[0].value;
            $('.contractor_area').attr("value", current_tags);
            console.log( current_tags );
        });



    </script>
@endsection
