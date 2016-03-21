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
        <div id="income-graph-data">{{ $chartData }}</div>
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Доход</h3>

                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="chart">
                        <canvas id="income-graph"></canvas>
                    </div>
                </div>
                <div class="box-footer">
                    {{ Form::open(['route' => ['accounts.view', $account->id], 'method' => 'GET']) }}
                    <div class="col-md-8">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            {{ Form::text('daterange', null,
                            ['class' => 'form-control pull-right', 'id' => 'reservation',]) }}
                        </div>
                    </div>
                    <div class="col-md-4">
                        {{ Form::submit('Показать', ['class' => 'btn btn-block btn-danger']) }}
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Приход и Расход</h3>

                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="chart">
                        <canvas id="incexp-graph"></canvas>
                    </div>
                </div>
                <div class="box-footer">
                    {{ Form::open(['route' => ['accounts.view', $account->id], 'method' => 'GET']) }}
                    <div class="col-md-8">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            {{ Form::text('daterange', null,
                            ['class' => 'form-control pull-right', 'id' => 'reservation',]) }}
                        </div>
                    </div>
                    <div class="col-md-4">
                        {{ Form::submit('Показать', ['class' => 'btn btn-block btn-danger']) }}
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">История</h3>

                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool"
                                data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tr>
                            <th>ID</th>
                            <th>Money</th>
                            <th>Created at</th>
                            <th>Description</th>
                            <th>Currency</th>
                        </tr>
                        @foreach($history as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->money }}</td>
                                <td>{{ $item->created_at }}</td>
                                <td>{{ $item->description }}</td>
                                <td>{{ $item->currency }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <div class="box-footer clearfix">
                    <ul class="pagination pagination-sm no-margin pull-right">
                        <li><a href="#">&laquo;</a></li>
                        <li><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">&raquo;</a></li>
                    </ul>
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