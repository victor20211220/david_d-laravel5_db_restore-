<ul class="nav nav-tabs">
    <li class="active"><a href="#tab_1" data-toggle="tab">Month View</a></li>
    <li><a href="#tab_2" data-toggle="tab">Day View</a></li>
</ul>
<div class="tab-content">
    <div class="tab-pane active" id="tab_1">
        <div class="row">
            @foreach($data as $chart)
                <div class="col-md-3">
                    <center><h3>{{explode("+", $chart->industry)[1]}}</h3></center>
                    <canvas id='myChart-{{strtolower(preg_replace('/\s*/', '', explode("+", $chart->industry)[1]))}}' width="400" height="400"></canvas>
                    <script type="text/javascript">
                        var ctx = document.getElementById("myChart-{{strtolower(preg_replace('/\s*/', '', explode("+", $chart->industry)[1]))}}");

                        var data = {
                            labels: [
                                "Free Leads",
                                "Sold Leads"
                            ],
                            datasets: [
                                {
                                    data: [parseInt("{{ $chart->free_count }}"), parseInt("{{ $chart->other_count }}")],
                                    backgroundColor: [
                                        "#FF6384",
                                        "#36A2EB",
                                    ]
                                }]
                        };

                        var pieOptions = {
                            events: false,
                            animation: {
                                duration: 500,
                                easing: "easeOutQuart",
                                onComplete: function () {
                                    var ctx = this.chart.ctx;
                                    ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, 'bold', Chart.defaults.global.defaultFontFamily);
                                    ctx.textAlign = 'center';
                                    ctx.textBaseline = 'bottom';

                                    this.data.datasets.forEach(function (dataset) {

                                        for (var i = 0; i < dataset.data.length; i++) {
                                            var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model,
                                                    total = dataset._meta[Object.keys(dataset._meta)[0]].total,
                                                    mid_radius = model.innerRadius + (model.outerRadius - model.innerRadius)/2,
                                                    start_angle = model.startAngle,
                                                    end_angle = model.endAngle,
                                                    mid_angle = start_angle + (end_angle - start_angle)/2;

                                            var x = mid_radius * Math.cos(mid_angle);
                                            var y = mid_radius * Math.sin(mid_angle);

                                            ctx.fillStyle = '#fff';
                                            if (i == 3){ // Darker text color for lighter background
                                                ctx.fillStyle = '#444';
                                            }

                                            ctx.fontSize = 16;

                                            var val = dataset.data[i];
                                            var percent = String(Math.round(val/total*100)) + "%";

                                            if(val != 0) {
                                                ctx.fillText(dataset.data[i], model.x + x, model.y + y);
                                                // Display percent in another line, line break doesn't work for fillText
                                                ctx.fillText(percent, model.x + x, model.y + y + 15);
                                            }
                                        }
                                    });
                                }
                            }
                        };

                        var myPieChart = new Chart(ctx,{
                            type: 'pie',
                            data: data,
                            options: pieOptions
                        });
                    </script>
                </div>
            @endforeach
        </div>
    </div>
    <!-- /.tab-pane -->
    <div class="tab-pane" id="tab_2">
        <div class="row">
            @foreach($data2 as $chart2)
                <div class="col-md-3">
                    <center><h3>{{explode("+", $chart2->industry)[1]}}</h3></center>
                    <canvas id='myChart2-{{strtolower(preg_replace('/\s*/', '', explode("+", $chart2->industry)[1]))}}' width="400" height="400"></canvas>
                    <script type="text/javascript">
                        var ctx = document.getElementById("myChart2-{{strtolower(preg_replace('/\s*/', '', explode("+", $chart2->industry)[1]))}}");

                        var data2 = {
                            labels: [
                                "Free Leads",
                                "Sold Leads"
                            ],
                            datasets: [
                                {
                                    data: [parseInt("{{ $chart2->free_count }}"), parseInt("{{ $chart2->other_count }}")],
                                    backgroundColor: [
                                        "#FF6384",
                                        "#36A2EB",
                                    ]
                                }]
                        };

                        var pieOptions2 = {
                            events: false,
                            animation: {
                                duration: 500,
                                easing: "easeOutQuart",
                                onComplete: function () {
                                    var ctx = this.chart.ctx;
                                    ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, 'bold', Chart.defaults.global.defaultFontFamily);
                                    ctx.textAlign = 'center';
                                    ctx.textBaseline = 'bottom';

                                    this.data.datasets.forEach(function (dataset) {

                                        for (var i = 0; i < dataset.data.length; i++) {
                                            var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model,
                                                    total = dataset._meta[Object.keys(dataset._meta)[0]].total,
                                                    mid_radius = model.innerRadius + (model.outerRadius - model.innerRadius)/2,
                                                    start_angle = model.startAngle,
                                                    end_angle = model.endAngle,
                                                    mid_angle = start_angle + (end_angle - start_angle)/2;

                                            var x = mid_radius * Math.cos(mid_angle);
                                            var y = mid_radius * Math.sin(mid_angle);

                                            ctx.fillStyle = '#fff';
                                            if (i == 3){ // Darker text color for lighter background
                                                ctx.fillStyle = '#444';
                                            }

                                            ctx.fontSize = 16;

                                            var val = dataset.data[i];
                                            var percent = String(Math.round(val/total*100)) + "%";

                                            if(val != 0) {
                                                ctx.fillText(dataset.data[i], model.x + x, model.y + y);
                                                // Display percent in another line, line break doesn't work for fillText
                                                ctx.fillText(percent, model.x + x, model.y + y + 15);
                                            }
                                        }
                                    });
                                }
                            }
                        };

                        var myPieChart = new Chart(ctx,{
                            type: 'pie',
                            data: data2,
                            options: pieOptions2
                        });
                    </script>
                </div>
            @endforeach
        </div>
    </div>
</div>
<!-- /.tab-content -->