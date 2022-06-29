@extends('layouts.app')

@section("title", "Review Message")

@section("page_title")
    Review Message <small>Review message details.</small>
@endsection

@section('content')

    <style>
        .glyphicon-refresh-animate {
            -animation: spin .7s infinite linear;
            -webkit-animation: spin2 .7s infinite linear;
        }

        @-webkit-keyframes spin2 {
            from { -webkit-transform: rotate(0deg);}
            to { -webkit-transform: rotate(360deg);}
        }

        @keyframes spin {
            from { transform: scale(1) rotate(0deg);}
            to { transform: scale(1) rotate(360deg);}
        }

        .ui-autocomplete .ui-menu-item {
            height: 25px;
            border-bottom: 1px solid #CCC;
            padding-left: 5px;
        }

        .ui-autocomplete .ui-menu-item:hover {
            height: 25px;
            background:#3c8dbc;
            color:#FFF;
        }
    </style>
    <link href = "{{ URL::asset("css/jquery-ui.theme.min.css")}}" rel = "stylesheet">
    <link href = "{{ URL::asset("css/jquery-ui.structure.min.css")}}" rel = "stylesheet">

    <script src="{{ URL::asset("bower_components/AdminLTE/plugins/jQueryUI/jquery-ui.min.js")}}" type="text/javascript"></script>

    {{ Html::ul($errors->all()) }}

    {{ Form::open(array('url' => 'leads/review/'.$lead[0]["id"].'')) }}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Lead Details</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">

                    @if($lead[0]["type"] == "call")
                        <input type="hidden" name="lead_type" id="lead_type" value="0" />
                    @else
                        <input type="hidden" name="lead_type" id="lead_type" value="1" />
                    @endif

                    @if($lead[0]["type"] == "call")
                        <div class="form-group">
                            {{ Form::label('lead_name', 'Full Name') }}
                            {{ Form::text('lead_name', $lead[0]["name"], array('class' => 'form-control', 'placeholder'=>'Full Name')) }}
                        </div>
                        <div class="form-group">
                            {{ Form::label('lead_email', 'Email Address') }}
                            {{ Form::text('lead_email', $lead[0]["email"], array('class' => 'form-control', 'placeholder'=>'Email Address')) }}
                        </div>
                        <div class="form-group">
                            {{ Form::label('lead_email_alt', 'Alternative Email Address') }}
                            {{ Form::text('lead_email_alt', $lead[0]["email_alt"], array('class' => 'form-control', 'placeholder'=>'Alternative Email')) }}
                        </div>
                        <div class="form-group">
                            {{ Form::label('lead_phone', 'Phone Number') }}
                            {{ Form::text('lead_phone', $lead[0]["phone"], array('class' => 'form-control', 'placeholder'=>'Phone Number')) }}
                        </div>
                        <div class="form-group">
                            {{ Form::label('lead_phone_alt', 'Alternative Phone Number') }}
                            {{ Form::text('lead_phone_alt', $lead[0]["phone_alt"], array('class' => 'form-control', 'placeholder'=>'Alternative Phone')) }}
                        </div>
                    @endif
                    <div class="form-group">
                        {{ Form::label('lead_message', 'Message') }}
                        <textarea name="lead_message" class="form-control lead_message" placeholder="Message" rows="10">{{$lead[0]["message"]}}</textarea>
                    </div>
                    <div class="input-group input-group-sm">
                        <select class="form-control" style="-webkit-border-radius: 0px;" id="premessageSelect">

                        </select>
                                        <span class="input-group-btn">
                                          <button type="button" class="btn btn-success btn-flat addPreMessage">Add</button>
                                        </span>
                    </div>

                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    @role('admin')
                    <h3 class="box-title">Select Contractor</h3>
                    @endrole
                    @role('operator')
                    <h3 class="box-title">Contractor Details</h3>
                    @endrole
                    @role('admin')
                    <div class="pull-right hidden-xs">
                        <span class="glyphicon glyphicon-refresh glyphicon-refresh-animate loadingApply" style="opacity: 0;"> </span> <a href="#" class="btn btn-primary btn-xs searchContractors">Search For Contractors</a>
                    </div>
                    @endrole
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">
                    <div class="form-group">
                        {{ Form::label('lead_area', 'Area') }}
                        {{ Form::text('lead_area', $lead[0]["area"], array('class' => 'form-control area', 'placeholder'=>'Location', 'id' => 'autocomplete')) }}
                    </div>

                    <div class="form-group">
                        {{ Form::label('lead_industry', 'Lead Industry') }}
                        <select name="lead_industry" class="form-control lead_industry">
                        </select>
                    </div>

                    <div class="form-group">
                        {{ Form::label('free_lead', 'Free Lead') }}
                        <input type="checkbox" name="free_lead" {{ ($lead[0]["status"] == "free") ? 'checked' : '' }} />
                    </div>

                    <div class="form-inline">
                        <div class="input-group">
                            <input name="searchValueString" type="text" class="form-control searchValueString" placeholder="Search Contractors" />
                        <span class="input-group-btn">
                            <select class="form-control searchValueColumn" name="searchValueColumn">
                                <option value="name">Name</option>
                                <option value="industry">Industry</option>
                                <option value="area">Area</option>
                                <option value="emails">Emails</option>
                                <option value="phones">Phones</option>
                            </select>
                        </span>
                        </div>
                        <button type="button" class="btn btn-primary searchForContractor">Search</button>
                        <div class="pull-right hidden-xs">
                            <span class="glyphicon glyphicon-refresh glyphicon-refresh-animate loadingApply2" style="opacity: 0;"> </span>
                        </div>
                    </div>

                    @role('admin')
                    <table class="table table-bordered contractorsTable" id="example2">
                        <thead>
                        <th style="width: 10px;"><input type="radio" disabled /></th>
                        <th style="width: 10px;">ID</th>
                        <th>Name</th>
                        <th>Sent lead today?</th>
                        <th>Leads Remaining</th>
                        <th style="width: 10px;">&nbsp;</th>
                        </thead>
                        <tbody id="contractorsDetails">
                        </tbody>
                    </table>
                    @endrole
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    {{ Form::submit('Send Lead', array('class' => 'btn btn-primary')) }}
                </div>
            </div>
        </div>
    </div>
    {{ Form::close() }}

    <script src="{{ URL::asset("tagging/jquery.tagsinput.js") }}"></script>
    <script type="text/javascript">

        $('.loadingApply').css('opacity', 0);

        var province;
        var city;
        var area;

        // Locations
        var jsonData = "{{$areasJSON}}";
        var text = jsonData.replace(/&quot;/g, '"');
        var result = JSON.parse(text);

        // Industries
        var jsonIndustry = "{{$industry}}";
        var textIndustry = jsonIndustry.replace(/&quot;/g, '"');
        var resultIndustry = JSON.parse(textIndustry);

        // PreMessage
        var jsonPreMessage = "{{$premessage}}";
        var textPreMessage = jsonPreMessage.replace(/&quot;/g, '"');
        var resultPreMessage = JSON.parse(textPreMessage);

        var oTable = $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false
        });

        var selectedIndustry = "{{$lead[0]["industry"]}}";

        $.each(resultIndustry, function(key, value){
            $('.lead_industry').append($('<option value="'+key+'"></option>').html(key));
            $.each(resultIndustry[key], function(key0, value0){
                if(value0 == selectedIndustry) {
                    $('.lead_industry').append($('<option selected="" value="'+value0+'"></option>').html("--"+value0));
                } else {
                    $('.lead_industry').append($('<option value="'+value0+'"></option>').html("--"+value0));
                }

            });
        });

        $.each(resultPreMessage, function(keyPre, valuePre){
            console.log(""+keyPre);
            console.log(""+resultPreMessage[keyPre].name);

            $('#premessageSelect').append($('<option value="'+keyPre+'"></option>').html(resultPreMessage[keyPre].name));
        });

        $('.addPreMessage').on('click', function(){
            var messagekey = $('#premessageSelect').val();
            console.log(messagekey);
            var messageVal = $('.lead_message').val();
            var message = resultPreMessage[messagekey].message;
            $('.lead_message').html(""+messageVal+" "+message);
        });

        $('.searchContractors').on('click', function(e) {
            e.preventDefault();
            $('.loadingApply').css('opacity', 1); // Enable the loading animation

            // Get the location and industry
            var location = $('.area').val();
            var industry = $('.lead_industry').val();

            $.ajax({
                data: null,
                type: "GET",
                url: encodeURI("{{URL::to('/')}}/contractorsGet/"+industry+"/"+location+""),
                dataType: "json",
                success: function (response) {
                    // Do something if successful.removeContractors();
                    $('#contractorsDetails').html(response.data);
                    $('.loadingApply').css('opacity', 0); // Enable the loading animation
                    oTable.refresh;
                }
            });

        });

        var avalibleTags = [];

        // JSON string
        $.each(result, function(key5, value5){
            var province1 = key5;
            $.each(result[province1], function(key6, value6){
                var city1 = key6;
                $.each(result[province1][city1], function(key7, value7){
                    var area1 = key7;
                    $.each(result[province1][city1][area1], function(key8, value8){
                        var suburb1 = value8;
                        avalibleTags.push(""+province1+","+city1+","+area1+","+suburb1);
                    });
                });
            });
        });

        $( "#autocomplete" ).autocomplete({
            source: avalibleTags
        });

        function changeAcc(item) {
            if (item == "call") {
                $('#lead_type').attr("value", 0);
            } else {
                $('#lead_type').attr("value", 1);
            }
        }

        $('.searchForContractor').on('click', function(e) {
            e.preventDefault();
            $('.loadingApply2').css('opacity', 1); // Enable the loading animation
            var column = $('.searchValueColumn').val();
            var string = $('.searchValueString').val();

            $.ajax({
                data: null,
                type: "GET",
                url: encodeURI("{{URL::to('/')}}/search/"+string+"/"+column+""),
                dataType: "json",
                success: function (response) {
                    // Do something if successful.removeContractors();
                    $('#contractorsDetails').html(response.data);
                    $('.loadingApply2').css('opacity', 0); // Enable the loading animation
                    //oTable.refresh;
                }
            });
        });


    </script>
@endsection