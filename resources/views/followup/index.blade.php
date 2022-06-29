@extends('layouts.app')

@section('title', 'New Lead')

@section('page_title')
    Follow Up's <small>Follow up on leads.</small>
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

    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Leads</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">

                    <div class="form-group">
                        <label>Follow up on leads from: </label>
                        <select class="followUp">
                            <option value="1">1 Hour Ago</option>
                            <option value="2">2 Hours Ago</option>
                            <option value="3">3 Hours Ago</option>
                            <option value="4">4 Hours Ago</option>
                            <option value="5">5 Hours Ago</option>
                            <option value="6">6 Hours Ago</option>
                            <option value="yesterday">Yesterday</option>
                        </select> <span class="glyphicon glyphicon-refresh glyphicon-refresh-animate loadingApply" style="opacity: 0;"> </span>
                    </div>

                    <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                        <thead>
                        <tr role="row">
                            <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" style="width: 10px;">ID</th>
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Full Name</th>
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Industries</th>
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Area</th>
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Messages</th>
                            <th style="width: 80px;">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="leadFollowUpList">
                        @foreach($leads as $item)
                            <tr>
                                <td>{{$item->id}}.</td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->industry}}</td>
                                <td>{{$item->area}}</td>
                                <td>{{$item->message}}</td>
                                <td><a class="btn btn-small btn-primary btn-sm" href="{{ URL::to('followup/'.$item->id.'/show') }}">Follow Up</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>

    <script>
        $(function () {
            $('#example2').DataTable();
        });

        $('.followUp').on('change', function(){
            var timeVal = $('.followUp').val();
            $('.loadingApply').css('opacity', 1); // Enable the loading animation

            $.ajax({
                data: null,
                type: "GET",
                url: encodeURI("{{URL::to('/')}}/followup/search/"+timeVal+"/"),
                dataType: "json",
                success: function (response) {
                    // Do something if successful.removeContractors();
                    $('.leadFollowUpList').html(response.data);
                    $('.loadingApply').css('opacity', 0); // Enable the loading animation
                }
            });

        });
    </script>
@endsection
