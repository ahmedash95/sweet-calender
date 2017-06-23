@extends('layouts.app')
@section('content')
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">
                UPDATE EVENT
            </div>
            <div class="panel-body">
                <form action="{{ url("/events/{$event->id}") }}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="_method" value="put">
                    <div class="form-group col-md-12">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $event->name }}">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="description">Description</label>
                        <textarea type="text" name="description" class="form-control" rows="4">{{ $event->description }}</textarea>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <label for="when">When</label>
                        </div>
                        <div class="col-md-6">
                            <div>Date:</div>
                            <input type="date" name="date" class="form-control" value="{{ $event->date }}">
                        </div>
                        <div class="col-md-6">
                            <div>At:</div>
                            <input type="time" name="time" class="form-control" value="{{ $event->time }}">
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="form-group">
                        <hr>
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