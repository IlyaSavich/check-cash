@extends('layouts.main')

@section('content')
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Создать новый счет</h3>
            </div>
            {!! Form::open(['route' => 'accounts.store', 'class' => 'form-horizontal']) !!}
            <div class="box-body">
                <div class="form-group">
                    {!! Form::label('name', 'Имя счета: ', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-9">
                        {!! Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'Имя']) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('description', 'Описание: ', ['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-9">
                        {!! Form::textarea('description', '', ['class' => 'form-control',
                         'rows' => '4', 'placeholder' => 'Описание']) !!}
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <a href="{{ asset('list') }}" class="btn btn-default">Отменить</a>
                {!! Form::submit('Создать', ['class' => 'btn btn-success pull-right']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@stop