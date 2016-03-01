@extends('layouts.main')

@section('content')
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Новая транзакция</h3>
            </div>
            {!! Form::open(['route' => 'accounts.store', 'class' => 'form-horizontal']) !!}
            <div class="box-body">
                <div class="form-group">
                    {!! Form::label('money', 'Количество денег: ', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-9">
                        {!! Form::text('money', '', ['class' => 'form-control', 'placeholder' => '0']) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('description', 'Описание: ', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-9">
                        {!! Form::textarea('description', '', ['class' => 'form-control',
                         'rows' => '4', 'placeholder' => 'Описание']) !!}
                    </div>
                </div>
                {!! Form::hidden('account_id', $account->id) !!}
            </div>
            <div class="box-footer">
                <a href="{{ asset('list') }}" class="btn btn-default">Отменить</a>
                {!! Form::submit('Отправить', ['class' => 'btn btn-success pull-right']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@stop