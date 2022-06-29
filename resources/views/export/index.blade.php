@extends('layouts.app')

@section('title', 'Exporting')

@section('page_title')
    Export <small>Generate Excel Exports.</small>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Exports</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">
                    <h3>Export Leads</h3>
                    <hr />
                    <div class="row">
                        <div class="col-md-4">
                            <p>Export all the leads in the system out.</p>
                            <a href="/export/messages" class="btn btn-primary">Export Leads</a>
                        </div>
                        <div class="col-md-4">
                            <p>Export all the leads for a specific operator.</p>
                            {{ Html::ul($errors->all()) }}

                            {{ Form::open(array('url' => 'export/operator')) }}
                            <select class="form-control" name="contractor">
                                @foreach($operators as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            <br />
                            <input type="submit" class="btn btn-primary" value="Export Leads" />
                            {{ Form::close() }}
                        </div>
                        <div class="col-md-4">
                            <p>Export all the leads for a specific contractor (Enter name/id).</p>
                            {{ Html::ul($errors->all()) }}

                            {{ Form::open(array('url' => 'export/contractor')) }}
                            <input type="text" name="contractor_name" class="form-control" placeholder="Contractor Name" />
                            <center><p>OR</p></center>
                            <input type="text" name="contractor_id" class="form-control" placeholder="Contractor ID" />
                            <br />
                            <input type="submit" class="btn btn-primary" value="Export Leads" />
                            {{ Form::close() }}
                        </div>
                    </div>

                    <h3>Export Contractors</h3>
                    <hr />
                    <div class="row">
                        <div class="col-md-4">
                            <p>Export all contractors in the system.</p>
                            <a href="/export/contractors" class="btn btn-primary">Export Contractors</a>
                        </div>
                    </div>

                    <h3>Backup MySQL Database</h3>
                    <hr />
                    <div class="row">
                        <div class="col-md-4">
                            <p>Download a copy of the full database for backup (recommended once a week).</p>
                            <a href="/export/full" class="btn btn-primary">Generate Backup</a>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
        </div>

    </div>
@endsection
