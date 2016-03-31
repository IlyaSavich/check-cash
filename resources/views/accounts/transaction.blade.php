@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            @include('errors.account')
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Новая транзакция</h3>
                </div>
                {!! Form::open(['class' => '']) !!}
                <div class="box-body">
                    <div class="input-group input-field">
                        <span class="input-group-addon"><i class="fa fa-exchange"></i></span>
                        {!! Form::select('transaction_type', [0 => 'Приход', 1 => 'Расход'], 0,
                        ['class' => 'form-control']) !!}
                    </div>
                    <div class="input-group input-field">
                        <span class="input-group-addon"><i class="fa fa-bank"></i></span>
                        {!! Form::number('money', '', ['class' => 'form-control',
                        'placeholder' => '0', 'step' => '5', 'min' => 0]) !!}
                    </div>
                    <div class="input-group input-field">
                        <span class="input-group-addon"><i class="fa fa-money"></i></span>
                        {!! Form::select('currency_id', [1 => 'USD', 2 => 'EUR', 3 => 'RUR', 4 => 'BLR'], 1,
                        ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::textarea('description', '', ['class' => 'form-control',
                         'rows' => '4', 'placeholder' => 'Описание ...']) !!}
                    </div>
                    {!! Form::hidden('account_id', $account->id) !!}
                </div>
                <div class="box-footer">
                    <a href="{{ route('accounts.view', $account->id) }}" class="btn btn-default">Отменить</a>
                    {!! Form::submit('Отправить', ['class' => 'btn btn-success pull-right']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop