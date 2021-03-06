@extends('layouts.main')

@section('content')
    <div class="row">
        @foreach($accounts as $account)
            <div class="col-lg-3 col-xs-12">
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
        @endforeach
    </div>
@stop