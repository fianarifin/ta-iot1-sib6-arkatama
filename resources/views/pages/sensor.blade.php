@extends('layouts.dashboard')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- DHT11 Temperature Monitoring -->
            <div class="col-lg-4 col-md-6">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Monitoring Sensor Suhu</h5>
                        <div id="gaugeTemperature"></div>
                        <p class="card-text"><small class="text-muted">Terakhir diubah 3 menit lalu</small></p>
                    </div>
                </div>
            </div>

            <!-- DHT11 Humidity Monitoring -->
            <div class="col-lg-4 col-md-6">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Monitoring Sensor Kelembaban</h5>
                        <div id="gaugeHumidity"></div>
                        <p class="card-text"><small class="text-muted">Terakhir diubah 3 menit lalu</small></p>
                    </div>
                </div>
            </div>

            <!-- Rain Sensor Monitoring -->
            <div class="col-lg-4 col-md-6">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Monitoring Sensor Hujan</h5>
                        <p class="card-text">0= Tidak hujan, 1=Hujan</p>
                        <div id="gaugeRain"></div>
                        <p class="card-text"><small class="text-muted">Terakhir diubah 3 menit lalu</small></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/highcharts-more.js"></script>
    <script src="https://code.highcharts.com/modules/solid-gauge.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script>
        let gaugeTemperature, gaugeHumidity, gaugeRain;

        async function fetchSensorData(route, gauge, key) {
            try {
                const response = await fetch(route);
                if (response.ok) {
                    const data = await response.json();
                    const sensorData = data.data;

                    if (sensorData && sensorData[0] && typeof sensorData[0][key] !== 'undefined') {
                        const value = sensorData[0][key];
                        gauge.series[0].points[0].update(Number(value));
                    } else {
                        console.error(`${key} data is missing or malformed`, sensorData);
                    }
                } else {
                    console.error(`Failed to fetch ${key} data`, response.statusText);
                }
            } catch (error) {
                console.error(`Error fetching ${key} data`, error);
            }
        }

        async function requestGaugeTemperature() {
            await fetchSensorData("{{ route('api.sensors.dht11.index') }}", gaugeTemperature, 'temperature');
            setTimeout(requestGaugeTemperature, 3000);
        }

        async function requestGaugeHumidity() {
            await fetchSensorData("{{ route('api.sensors.dht11.index') }}", gaugeHumidity, 'humidity');
            setTimeout(requestGaugeHumidity, 3000);
        }

        async function requestGaugeRain() {
            await fetchSensorData("{{ route('api.sensors.rain.index') }}", gaugeRain, 'value');
            setTimeout(requestGaugeRain, 3000);
        }

        window.addEventListener('load', function() {
            gaugeTemperature = Highcharts.chart('gaugeTemperature', {
                chart: {
                    type: 'solidgauge',
                    height: '80%',
                    events: {
                        load: requestGaugeTemperature
                    }
                },
                title: {
                    text: 'Temperature'
                },
                pane: {
                    center: ['50%', '85%'],
                    size: '140%',
                    startAngle: -90,
                    endAngle: 90,
                    background: {
                        backgroundColor: Highcharts.defaultOptions.legend.backgroundColor || '#EEE',
                        innerRadius: '60%',
                        outerRadius: '100%',
                        shape: 'arc'
                    }
                },
                yAxis: {
                    min: 0,
                    max: 50,
                    stops: [
                        [0.1, '#55BF3B'], // green
                        [0.5, '#DDDF0D'], // yellow
                        [0.9, '#DF5353']  // red
                    ],
                    lineWidth: 0,
                    tickWidth: 0,
                    minorTickInterval: null,
                    tickAmount: 2,
                    title: {
                        y: -70,
                        text: '°C'
                    },
                    labels: {
                        y: 16
                    }
                },
                series: [{
                    name: 'Temperature',
                    data: [0],
                    tooltip: {
                        valueSuffix: ' °C'
                    },
                    dataLabels: {
                        format: '<div style="text-align:center"><span style="font-size:25px">{y}</span><br/><span style="font-size:12px;opacity:0.4">°C</span></div>'
                    }
                }]
            });

            gaugeHumidity = Highcharts.chart('gaugeHumidity', {
                chart: {
                    type: 'solidgauge',
                    height: '80%',
                    events: {
                        load: requestGaugeHumidity
                    }
                },
                title: {
                    text: 'Humidity'
                },
                pane: {
                    center: ['50%', '85%'],
                    size: '140%',
                    startAngle: -90,
                    endAngle: 90,
                    background: {
                        backgroundColor: Highcharts.defaultOptions.legend.backgroundColor || '#EEE',
                        innerRadius: '60%',
                        outerRadius: '100%',
                        shape: 'arc'
                    }
                },
                yAxis: {
                    min: 20,
                    max: 90,
                    stops: [
                        [0.1, '#55BF3B'], // green
                        [0.5, '#DDDF0D'], // yellow
                        [0.9, '#DF5353']  // red
                    ],
                    lineWidth: 0,
                    tickWidth: 0,
                    minorTickInterval: null,
                    tickAmount: 2,
                    title: {
                        y: -70,
                        text: '%'
                    },
                    labels: {
                        y: 16
                    }
                },
                series: [{
                    name: 'Humidity',
                    data: [0],
                    tooltip: {
                        valueSuffix: ' %'
                    },
                    dataLabels: {
                        format: '<div style="text-align:center"><span style="font-size:25px">{y}</span><br/><span style="font-size:12px;opacity:0.4">%</span></div>'
                    }
                }]
            });

            gaugeRain = Highcharts.chart('gaugeRain', {
                chart: {
                    type: 'solidgauge',
                    height: '80%',
                    events: {
                        load: requestGaugeRain
                    }
                },
                title: {
                    text: 'Rain'
                },
                pane: {
                    center: ['50%', '85%'],
                    size: '140%',
                    startAngle: -90,
                    endAngle: 90,
                    background: {
                        backgroundColor: Highcharts.defaultOptions.legend.backgroundColor || '#EEE',
                        innerRadius: '60%',
                        outerRadius: '100%',
                        shape: 'arc'
                    }
                },
                yAxis: {
                    min: 0,
                    max: 1,
                    stops: [
                        [0.1, '#55BF3B'], // green
                        [0.5, '#DDDF0D'], // yellow
                        [0.9, '#DF5353']  // red
                    ],
                    lineWidth: 0,
                    tickWidth: 0,
                    minorTickInterval: null,
                    tickAmount: 2,
                    title: {
                        y: -70,
                        text: ''
                    },
                    labels: {
                        y: 16
                    }
                },
                series: [{
                    name: 'Rain',
                    data: [0],
                    tooltip: {
                        valueSuffix: ' %'
                    },
                    dataLabels: {
                        format: '<div style="text-align:center"><span style="font-size:25px">{y}</span><br/><span style="font-size:12px;opacity:0.4">%</span></div>'
                    }
                }]
            });
        });
    </script>
@endpush
