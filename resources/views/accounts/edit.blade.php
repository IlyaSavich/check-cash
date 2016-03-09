@extends('layouts.main')

@section('content')
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Изменить счет</h3>
            </div>
            {!! Form::open() !!}
            <div class="box-body">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-bookmark-o"></i></span>
                    {!! Form::text('name', $account->name, ['class' => 'form-control', 'placeholder' => 'Название']) !!}
                </div>
                <div class="form-group">
                    {!! Form::textarea('description', $account->description, ['class' => 'form-control',
                     'rows' => '4', 'placeholder' => 'Описание ...']) !!}
                </div>
            </div>
            <div class="box-footer">
                <a href="{{ route('accounts.view', $account->id) }}" class="btn btn-default">Отменить</a>
                {!! Form::submit('Изменить', ['class' => 'btn btn-success pull-right']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@stop