@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{ $account->balance }} $</h3>

                    <p>{{ $account->name }}</p>
                </div>
                <div class="icon">
                    <i class="ion ion-briefcase"></i>
                </div>
                <a href="{{ route('transaction.create', $account->id) }}" class="small-box-footer">Пополнить счёт</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <!-- AREA CHART -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Доход</h3>

                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="chart">
                        <canvas id="areaChart" style="height:250px"></canvas>
                        <div id="areaChartData">{{ $chartData }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <a href="{{ route('accounts.edit', $account->id) }}">
            <button class="btn btn-block btn-warning btn-lg">Изменить</button>
        </a>
    </div>
@stop