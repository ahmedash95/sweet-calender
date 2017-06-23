@extends('layouts.app')
@section('content')
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">
                CREATE EVENT
            </div>
            <div class="panel-body">
                <form action="{{ url('/events') }}" method="post">
                    {{ csrf_field() }}
                    <div class="form-group col-md-12">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="description">Description</label>
                        <textarea type="text" name="description" class="form-control" rows="4"></textarea>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <label for="when">When</label>
                        </div>
                        <div class="col-md-6">
                            <div>Date:</div>
                            <input type="date" name="date" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <div>At:</div>
                            <input type="time" name="time" class="form-control">
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="form-group">
                        <hr>
                        <div class="text-right">
                            <button class="btn btn-primary">
                                SAVE
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection