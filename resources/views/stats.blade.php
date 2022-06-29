@extends('layouts.app')

@section('title', 'Statistics')

@section('page_title')
    Statistics
@endsection

@section('content')

    <style type="text/css">
        .glyphicon.spinning {
            animation: spin 1s infinite linear;
            -webkit-animation: spin2 1s infinite linear;
        }

        @keyframes spin {
            from { transform: scale(1) rotate(0deg); }
            to { transform: scale(1) rotate(360deg); }
        }

        @-webkit-keyframes spin2 {
            from { -webkit-transform: rotate(0deg); }
            to { -webkit-transform: rotate(360deg); }
        }
    </style>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>

    <script type="text/javascript" src="{{ URL::asset("public/bower_components/moment/min/moment.min.js") }}"></script>
    <script type="text/javascript" src="{{ URL::asset("public/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js") }}"></script>
    <link rel="stylesheet" href="{{ URL::asset("public/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css") }}" />

    <div class="row">
        <div class="col-md-12">
            <p>Select a date period for stats to be presented.</p>
        </div>
            <div class='col-md-2'>
                <div class="form-group">
                    <div class='input-group date' id='datetimepicker6'>
                        <input type='text' id="from_date" class="form-control" placeholder="From" />
                        <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
                    </div>
                </div>
            </div>
            <div class='col-md-2'>
                <div class="form-group">
                    <div class='input-group date' id='datetimepicker7'>
                        <input type='text' id="to_date" class="form-control" placeholder="To" />
                        <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
                    </div>
                </div>
            </div>
            <div class="col-md-1">
                <a href="#" class="btn btn-primary filter_btn">Fetch</a> <span class="glyphicon glyphicon-refresh spinning" style="opacity: 0;"></span>
            </div>

    </div>

    <div class="row stats_data">

    </div>

    <script type="text/javascript">
        $(function () {
            $('#datetimepicker6').datetimepicker({
                showTodayButton: true,
                showClear: true,
                format: 'YYYY-MM-DD H:ss'
            });
            $('#datetimepicker7').datetimepicker({
                useCurrent: false, //Important! See issue #1075
                showClear: true,
                showTodayButton: true,
                format: 'YYYY-MM-DD H:ss'
            });
            $("#datetimepicker6").on("dp.change", function (e) {
                $('#datetimepicker7').data("DateTimePicker").minDate(e.date);
            });
            $("#datetimepicker7").on("dp.change", function (e) {
                $('#datetimepicker6').data("DateTimePicker").maxDate(e.date);
            });
        });
    </script>

    <script type="text/javascript">
        $(".filter_btn").on("click", function() {
            $(".spinning").css("opacity", 1);
            var from = $("#from_date").val()+":00.000000";
            var to = $("#to_date").val()+":00.000000";

            if (from == "" && to == "") {
                alert("Please select a date range");
                $(".spinning").css("opacity", 0);
            } else if (from == "") {
                alert("Please select a from date.");
                $(".spinning").css("opacity", 0);
            } else if (to == "") {
                alert("Please select a to date.");
                $(".spinning").css("opacity", 0);
            } else {
                //alert("From: "+from+"\nTo: "+to);

                // /stats/search/{from}/{to}/

                // Ajax request
                $.ajax({
                    url: "<?php echo url('/stats/search/');?>/"+from+"/"+to,
                    success: function(data) {
                        $(".stats_data").html(data);
                        $(".spinning").css("opacity", 0);
                    }
                });
            }

        });
    </script>

@endsection