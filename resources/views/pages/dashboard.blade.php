@extends('layouts.dashboard')

@section('content')
    <div class="row">
        <!-- Gas Sensor Monitoring -->
        <div class="col-sm-12 col-md-6">
            <div class="card iq-mb-3">
                <div class="card-body">
                    <h4 class="card-title">Monitoring Sensor Gas</h4>
                    <p class="card-text">Grafik berikut adalah monitoring sensor gas 3 menit terakhir.</p>
                    <div id="monitoringGas"></div>
                    <p class="card-text"><small class="text-muted">Terakhir diubah 3 menit lalu</small></p>
                </div>
            </div>
        </div>
        <div class="col-sm-10 col-md-5">
            <div class="card iq-mb-3">
                <div class="card-body">
                    <h4 class="card-title">Monitoring Sensor Gas</h4>
                    <p class="card-text">Grafik berikut adalah monitoring sensor gas 3 menit terakhir.</p>
                    <div id="gaugeGas"></div>
                    <p class="card-text"><small class="text-muted">Terakhir diubah 3 menit lalu</small></p>
                </div>
            </div>
        </div>
    @endsection

    @push('scripts')
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/highcharts-more.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>
        <script src="https://code.highcharts.com/modules/export-data.js"></script>
        <script src="https://code.highcharts.com/modules/accessibility.js"></script>
        <script>
            let chartGas, gaugeGas;
            async function requestData() {
                const result = await fetch("{{ route('api.sensors.mq.index') }}");
                if (result.ok) {
                    const data = await result.json();
                    const sensorData = data.data;

                    const date = sensorData[0].created_at;
                    const value = sensorData[0].value;

                    const point = [new Date(date).getTime(), Number(value)];
                    const series = chartGas.series[0],
                        shift = series.data.length > 20;

                    chartGas.series[0].addPoint(point, true, shift);
                    setTimeout(requestData, 3000);
                }
            }

            async function requestGaugeGas() {
                const result = await fetch("{{ route('api.sensors.mq.index') }}");
                if (result.ok) {
                    const data = await result.json();
                    const sensorData = data.data;

                    const value = sensorData[0].value;

                    if (gaugeGas) {
                        gaugeGas.series[0].setData([Number(value)], true, true, true);
                    }

                    setTimeout(requestGaugeGas, 3000);
                }
            }

            window.addEventListener('load', function() {
                chartGas = new Highcharts.Chart({
                    chart: {
                        renderTo: 'monitoringGas',
                        defaultSeriesType: 'spline',
                        events: {
                            load: requestData
                        }
                    },
                    xAxis: {
                        type: 'datetime',
                        tickPixelInterval: 150,
                        maxZoom: 20 * 1000
                    },
                    yAxis: {
                        minPadding: 0.2,
                        maxPadding: 0.2,
                        title: {
                            text: 'Value',
                            margin: 80
                        }
                    },
                    series: [{
                        name: 'Gas',
                        data: []
                    }]
                });

                gaugeGas = new Highcharts.Chart({
                    chart: {
                        renderTo: 'gaugeGas',
                        type: 'gauge',
                        plotBackgroundColor: null,
                        plotBackgroundImage: null,
                        plotBorderWidth: 0,
                        plotShadow: false,
                        height: '80%',
                        events: {
                            load: requestGaugeGas
                        }
                    },
                    title: {
                        text: 'Gas'
                    },
                    pane: {
                        startAngle: -150,
                        endAngle: 150
                    },
                    yAxis: {
                        min: 0,
                        max: 1023,
                        minorTickInterval: 'auto',
                        minorTickWidth: 1,
                        minorTickLength: 10,
                        minorTickPosition: 'inside',
                        minorTickColor: '#666',
                        tickPixelInterval: 30,
                        tickWidth: 2,
                        tickPosition: 'inside',
                        tickLength: 10,
                        tickColor: '#666',
                        labels: {
                            step: 2,
                            rotation: 'auto',
                            style: {
                                color: '#E0E0E3'
                            }
                        },
                        title: {
                            text: 'Value',
                            style: {
                                color: '#A0A0A3'
                            }
                        },
                        plotBands: [{
                            from: 0,
                            to: 199,
                            color: '#55BF3B' // green
                        }, {
                            from: 200,
                            to: 299,
                            color: '#DDDF0D' // yellow
                        }, {
                            from: 300,
                            to: 1000,
                            color: '#DF5353' // red
                        }]
                    },
                    series: [{
                        name: 'Value',
                        data: [0],
                        tooltip: {
                            valueSuffix: ''
                        }
                    }]
                });
            });
        </script>
    @endpush
