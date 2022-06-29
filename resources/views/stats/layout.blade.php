@foreach($data as $key => $value)
    <div class="col-md-2">
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">{{ $key }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
                <div class="box-group" id="accordion">
                    <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                    @foreach($data[$key] as $key1 => $value1)
                        <div class="panel box box-primary">
                            <div class="box-header with-border">
                                <h4 class="box-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne-{{ strtolower(preg_replace('/\s+/', "-", $key1)) }}-{{ strtolower(preg_replace('/\s+/', "-", $key)) }}">
                                        {{ $key1 }}
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseOne-{{ strtolower(preg_replace('/\s+/', "-", $key1)) }}-{{ strtolower(preg_replace('/\s+/', "-", $key)) }}" class="panel-collapse collapse in">
                                <div class="box-body">
                                    @foreach($data[$key][$key1] as $key2 => $value2)
                                        <h6>{{ $key2 }}</h6>
                                        <p><strong>Sold: </strong>{{ $data[$key][$key1][$key2]["sold"] }}</p>
                                        <p><strong>Free: </strong>{{ $data[$key][$key1][$key2]["free"] }}</p>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
@endforeach