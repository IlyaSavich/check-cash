@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{ $account->currentMonthIncome }} $</h3>
                    <p>За этот месяц</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#history" class="small-box-footer">Подробнее</a>
            </div>
        </div>

        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{ $account->balance }} $</h3>
                    <p>Остаток на счёте</p>
                </div>
                <div class="icon">
                    <i class="ion ion-briefcase"></i>
                </div>
                <a href="{{ route('transaction.create', $account->id) }}"
                   class="small-box-footer">Пополнить счёт</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div id="income-graph-data">{{ $chartData }}</div>
        <div class="col-md-6">
            <div class="box box-solid bg-teal-gradient">
                <div class="box-header ui-sortable-handle">
                    <i class="fa fa-th"></i>
                    <h3 class="box-title graph-income-title">Доход</h3>

                    <div class="box-tools pull-right">
                        <button class="btn bg-teal btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body border-radius-none">
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
                            {{ Form::text('income', null,
                            ['class' => 'form-control pull-right', 'id' => 'reservation',]) }}
                        </div>
                    </div>
                    <div class="col-md-4">
                        {{ Form::submit('Показать', ['class' => 'btn btn-block btn-primary']) }}
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
                            {{ Form::text('recexp', null,
                            ['class' => 'form-control pull-right', 'id' => 'reservation',]) }}
                        </div>
                    </div>
                    <div class="col-md-4">
                        {{ Form::submit('Показать', ['class' => 'btn btn-block btn-primary']) }}
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-md-6">
            <div class="box" id="history">
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
                    {{--<ul class="pagination pagination-sm no-margin pull-right">--}}
                    {{--<li><a href="{{ $history->previousPageUrl() }}">&laquo;</a></li>--}}
                    {{--<li><a href="#">{{ $history->currentPage() }}</a></li>--}}
                    {{--<li><a href="#">next num</a></li>--}}
                    {{--<li><a href="{{ $history->nextPageUrl() }}">&raquo;</a></li>--}}
                    {{--</ul>--}}
                    <div class="pagination-sm no-margin pull-right pagin">
                        {{ $history->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <a href="{{ route('accounts.edit', $account->id) }}">
                <button class="btn btn-block btn-warning btn-lg">Изменить</button>
            </a>
        </div>
        <div class="col-md-6">
            <a href="{{ route('accounts.delete', $account->id) }}">
                <button class="btn btn-block btn-danger btn-lg">Удалить</button>
            </a>
        </div>
    </div>
@stop