@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{ $money }} $</h3>

                    <p>{{ $account->name }}</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer">
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>
    <a href="{{ route('accounts.transaction', $account->id) }}">
        <button class="btn btn-block btn-primary btn-lg">Пополнить счёт</button>
    </a>
    <button class="btn btn-block btn-warning btn-lg">Изменить</button>
@stop