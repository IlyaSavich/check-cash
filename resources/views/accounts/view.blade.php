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
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="{{ route('transaction.create', $account->id) }}" class="small-box-footer">Пополнить счёт</a>
            </div>
        </div>
    </div>

    <a href="{{ route('accounts.edit', $account->id) }}">
        <button class="btn btn-block btn-warning btn-lg">Изменить</button>
    </a>
@stop