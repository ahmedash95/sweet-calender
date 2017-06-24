@extends('layouts.app')
@section('content')
    <div class="row">
        @include('account.navbar')
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $title or null }}</div>
                <div class="panel-body">
                    {{ $message }}
                </div>
            </div>
        </div>
    </div>
@endsection