@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8 col-xs-12">
            @include('errors.account')
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Новый счет</h3>
                </div>
                {!! Form::open(['route' => 'accounts.store']) !!}
                <div class="box-body">
                    <div class="input-group input-field">
                        <span class="input-group-addon"><i class="fa fa-bookmark-o"></i></span>
                        {!! Form::text('name', '',
                        ['class' => 'form-control', 'placeholder' => 'Название']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::textarea('description', '', ['class' => 'form-control',
                        'rows' => '4', 'placeholder' => 'Описание ...']) !!}
                    </div>
                </div>
                <div class="box-footer">
                    <a href="{{ route('accounts') }}" class="btn btn-default">Отменить</a>
                    {!! Form::submit('Создать', ['class' => 'btn btn-success pull-right']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop