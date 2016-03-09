@extends('layouts.main')

@section('content')
    @foreach($accounts as $account)
        {{--<a href="{{ route('accounts.view', $account->id) }}">--}}
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{ $account->balance }} $</h3>

                    <p>{{ $account->name }}</p>
                </div>
                <div class="icon">
                    <i class="ion ion-briefcase"></i>
                </div>
                <a href="{{ route('accounts.view', $account->id) }}" class="small-box-footer">
                    Подробнее <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        {{--</a>--}}
    @endforeach
@stop