@extends('layouts.main')

@section('content')
    @foreach($accounts as $account)
        <a href="{{ route('accounts.view', $account->id) }}">
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fa fa-flag-o"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">{{ $account->name }}</span>
                        <span class="info-box-number"></span>
                    </div>
                </div>
            </div>
        </a>
    @endforeach
@stop