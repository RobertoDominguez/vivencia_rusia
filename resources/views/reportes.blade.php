@extends('layouts.header')

@section('content')
    <br>
    <div class="container-fluid">
        <h1 class="mt-4">Balance</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Reportes</li>
        </ol>

        <div class="row">
            <form action="{{ route('reportes') }}" method="GET">
                {{ csrf_field() }}
                <input type="text" name="dias" value="1" hidden>
                <div class="col-xl-6 col-md-6">
                    <button class="btn btn-primary">1 Dia</button>
                </div>
            </form>
            <form action="{{ route('reportes') }}" method="GET">
                {{ csrf_field() }}
                <input type="text" name="dias" value="7" hidden>
                <div class="col-xl-6 col-md-6">
                    <button class="btn btn-primary">1 Semana</button>
                </div>
            </form>
            <form action="{{ route('reportes') }}" method="GET">
                {{ csrf_field() }}
                <input type="text" name="dias" value="30" hidden>
                <div class="col-xl-6 col-md-6">
                    <button class="btn btn-primary">1 Mes</button>
                </div>
            </form>
            <form action="{{ route('reportes') }}" method="GET">
                {{ csrf_field() }}
                <input type="text" name="dias" value="365" hidden>
                <div class="col-xl-6 col-md-6">
                    <button class="btn btn-primary">1 Año</button>
                </div>
            </form>
            <form action="{{ route('reportes') }}" method="GET">
                {{ csrf_field() }}
                
                <div class="col-xl-6 col-md-6">
                    <input type="number" name="dias">
                    <button class="btn btn-primary">Dias</button>
                </div>
            </form>
        </div>
        <br>

        @foreach ($errors->all() as $error)
            <div class="alert alert-danger">{{ $error }}</div>
        @endforeach

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="row">
            <div class="col-xl-6 col-md-6">
                <div class="card bg-success text-white mb-4">
                    <div class="card-body">{{ $entrada . ' $' }}</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link">Entradas</a>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-md-6">
                <div class="card bg-danger text-white mb-4">
                    <div class="card-body">{{ $salida . ' $' }}</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link">Salidas</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-xl-12 col-md-6">
                <div class="card bg-warning text-white mb-4">
                    <div class="card-body">{{ $entrada - $salida }}</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link">Balance</a>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-xl-12">
            <div class="card mb-4">
                <div class="card-header"><i class="fas fa-chart-area mr-1"></i>Gastos</div>
                <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
            </div>
        </div>

        <br>

        <div class="col-xl-12">
            <div class="card mb-4">
                <div class="card-header"><i class="fas fa-chart-bar mr-1"></i>Gastos por tipo</div>
                <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
            </div>
        </div>
        <div class="row">



        </div>
    </div>
@endsection


@section('scripts')
    <script>
        // Set new default font family and font color to mimic Bootstrap's default styling
        Chart.defaults.global.defaultFontFamily =
            '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
        Chart.defaults.global.defaultFontColor = '#292b2c';

        // Area Chart Example
        var ctx = document.getElementById("myAreaChart");
        var myLineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [@php
                    foreach ($diasArr as $dia) {
                        echo '"' . $dia['d'] . '"' . ',';
                    }
                @endphp],
                datasets: [{
                    label: "Gasto",
                    lineTension: 0.3,
                    backgroundColor: "rgba(2,117,216,0.2)",
                    borderColor: "rgba(2,117,216,1)",
                    pointRadius: 5,
                    pointBackgroundColor: "rgba(2,117,216,1)",
                    pointBorderColor: "rgba(255,255,255,0.8)",
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(2,117,216,1)",
                    pointHitRadius: 50,
                    pointBorderWidth: 2,
                    data: [@php
                        foreach ($diasArr as $d) {
                            echo '"' . $d['m'] . '"' . ',';
                        }
                    @endphp],
                },],
            },
            options: {
                scales: {
                    xAxes: [{
                        time: {
                            unit: 'date'
                        },
                        gridLines: {
                            display: false
                        },
                        ticks: {
                            maxTicksLimit: 7
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            min: 0,
                            max: {{ $maxTr }},
                            maxTicksLimit: 4
                        },
                        gridLines: {
                            color: "rgba(0, 0, 0, .125)",
                        }
                    }],
                },
                legend: {
                    display: false
                }
            }
        });
    </script>

    <script>
        // Set new default font family and font color to mimic Bootstrap's default styling
        Chart.defaults.global.defaultFontFamily =
            '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
        Chart.defaults.global.defaultFontColor = '#292b2c';

        // Bar Chart Example
        var ctx = document.getElementById("myBarChart");
        var myLineChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [@php
                    foreach ($tipos as $tipo) {
                        echo '"' . $tipo->nombre . '"' . ',';
                    }
                @endphp],
                datasets: [{
                    label: "Gastos",
                    backgroundColor: "rgba(2,117,216,1)",
                    borderColor: "rgba(2,117,216,1)",
                    data: [@php
                        foreach ($tipos as $tipo) {
                            echo '"' . $tipo->monto . '"' . ',';
                        }
                    @endphp],
                }],
            },
            options: {
                scales: {
                    xAxes: [{
                        time: {
                            unit: 'month'
                        },
                        gridLines: {
                            display: false
                        },
                        ticks: {
                            maxTicksLimit: 12
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            min: 0,
                            max: {{ $maxTipo }},
                            maxTicksLimit: 4
                        },
                        gridLines: {
                            display: true
                        }
                    }],
                },
                legend: {
                    display: false
                }
            }
        });
    </script>
@endsection
