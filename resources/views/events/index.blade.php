@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                Events List
                <div class="pull-right">
                    <a href="{{ url('/events/create') }}" class="btn btn-primary btn-xs">
                        CREATE EVENT
                    </a>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body">
                @if(!Auth::user()->hasTokenFor('google'))
                    <div class="alert alert-danger">
                        You need to setup your google calender account
                    </div>
                @endif
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Event Name</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($events as $event)
                        <tr>
                            <td>{{ $event->name }}</td>
                            <td>{{ $event->date }}</td>
                            <td>{{ date('h:i:s a',strtotime($event->time)) }}</td>
                            <td>
                                <a href="{{ url("/events/{$event->id}/edit") }}" class="btn btn-primary btn-xs">EDIT</a>
                                <form action="{{ url("/events/{$event->id}") }}" method="post" style="display: inline-block;">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="_method" value="delete">
                                    <button class="btn btn-danger btn-xs">DELETE</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection