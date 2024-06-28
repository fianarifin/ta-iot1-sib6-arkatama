@extends('layouts.dashboard')

{{-- @section('content')
    <div class="row">
        <!-- Gas Sensor Monitoring -->
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

        <!-- DHT11 Temperature Monitoring -->
        <div class="col-sm-10 col-md-5">
            <div class="card iq-mb-3">
                <div class="card-body">
                    <h4 class="card-title">Monitoring Sensor Suhu</h4>
                    <p class="card-text">Grafik berikut adalah monitoring sensor suhu 3 menit terakhir.</p>
                    <div id="gaugeTemperature"></div>
                    <p class="card-text"><small class="text-muted">Terakhir diubah 3 menit lalu</small></p>
                </div>
            </div>
        </div>

        <!-- DHT11 Humidity Monitoring -->
        <div class="col-sm-10 col-md-5">
            <div class="card iq-mb-3">
                <div class="card-body">
                    <h4 class="card-title">Monitoring Sensor Kelembaban</h4>
                    <p class="card-text">Grafik berikut adalah monitoring sensor kelembaban 3 menit terakhir.</p>
                    <div id="gaugeHumidity"></div>
                    <p class="card-text"><small class="text-muted">Terakhir diubah 3 menit lalu</small></p>
                </div>
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
        let chartGas, gaugeGas, gaugeTemperature, gaugeHumidity;
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

        async function requestGaugeTemperature() {
            const result = await fetch("{{ route('api.sensors.dht11.index') }}");
            if (result.ok) {
                const data = await result.json();
                const sensorData = data.data;

                const value = sensorData[0].temperature;

                if (gaugeTemperature) {
                    gaugeTemperature.series[0].setData([Number(value)], true, true, true);
                }

                setTimeout(requestGaugeTemperature, 3000);
            }
        }

        async function requestGaugeHumidity() {
            const result = await fetch("{{ route('api.sensors.dht11.index') }}");
            if (result.ok) {
                const data = await result.json();
                const sensorData = data.data;

                const value = sensorData[0].humidity;

                if (gaugeHumidity) {
                    gaugeHumidity.series[0].setData([Number(value)], true, true, true);
                }

                setTimeout(requestGaugeHumidity, 3000);
            }
        }

        window.addEventListener('load', function() {
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

            gaugeTemperature = new Highcharts.Chart({
                chart: {
                    renderTo: 'gaugeTemperature',
                    type: 'gauge',
                    plotBackgroundColor: null,
                    plotBackgroundImage: null,
                    plotBorderWidth: 0,
                    plotShadow: false,
                    height: '80%',
                    events: {
                        load: requestGaugeTemperature
                    }
                },
                title: {
                    text: 'Temperature'
                },
                pane: {
                    startAngle: -150,
                    endAngle: 150
                },
                yAxis: {
                    min: 0,
                    max: 50,
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
                        text: '°C',
                        style: {
                            color: '#A0A0A3'
                        }
                    },
                    plotBands: [{
                        from: 0,
                        to: 15,
                        color: '#55BF3B' // green
                    }, {
                        from: 16,
                        to: 25,
                        color: '#DDDF0D' // yellow
                    }, {
                        from: 26,
                        to: 50
                    }, {
                        from: 26,
                        to: 50,
                        color: '#DF5353' // red
                    }]
                },
                series: [{
                    name: 'Temperature',
                    data: [0],
                    tooltip: {
                        valueSuffix: ' °C'
                    }
                }]
            });

            gaugeHumidity = new Highcharts.Chart({
                chart: {
                    renderTo: 'gaugeHumidity',
                    type: 'gauge',
                    plotBackgroundColor: null,
                    plotBackgroundImage: null,
                    plotBorderWidth: 0,
                    plotShadow: false,
                    height: '80%',
                    events: {
                        load: requestGaugeHumidity
                    }
                },
                title: {
                    text: 'Humidity'
                },
                pane: {
                    startAngle: -150,
                    endAngle: 150
                },
                yAxis: {
                    min: 0,
                    max: 100,
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
                        text: '%',
                        style: {
                            color: '#A0A0A3'
                        }
                    },
                    plotBands: [{
                        from: 0,
                        to: 40,
                        color: '#55BF3B' // green
                    }, {
                        from: 41,
                        to: 70,
                        color: '#DDDF0D' // yellow
                    }, {
                        from: 71,
                        to: 100,
                        color: '#DF5353' // red
                    }]
                },
                series: [{
                    name: 'Humidity',
                    data: [0],
                    tooltip: {
                        valueSuffix: ' %'
                    }
                }]
            });
        });
    </script>
@endpush --}}
