@extends('layouts.app')
@section('content')
    <div class="row">
        @include('account.navbar')
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">Third Parties</div>
                <div class="panel-body">
                    @if($user->hasTokenFor('google'))
                        <form action="{{ url('/third-parties/google/remove') }}" method="post">
                            {{ csrf_field() }}
                            <button class="btn btn-primary">
                                Disconnect From Google
                            </button>
                        </form>
                    @else
                        <a href="{{ url('/third-parties/google') }}" class="btn btn-primary">
                            Google Calender
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection