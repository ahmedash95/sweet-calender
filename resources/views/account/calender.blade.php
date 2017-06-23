@extends('layouts.app')
@section('content')
@include('account.navbar')
<div class="col-md-9">
    <div class="panel panel-default">
        <div class="panel-heading">Calender Settings</div>
        <div class="panel-body">
            <form action="{{ url('/settings/calender') }}" method="post">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="calender">Select Calender:</label>
                    <select name="calender" id="calender" class="form-control">
                        @foreach($calenderList as $item)
                            <option value="{{ $item['id'] }}"
                                    @if($current_calender_id == $item['id'])
                                        selected
                                    @endif
                            >
                                {{ $item['name'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <div class="text-right">
                        <button class="btn btn-primary">
                            UPDATE
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection