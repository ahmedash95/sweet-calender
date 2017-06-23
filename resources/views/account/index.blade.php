@extends('layouts.app')
@section('content')
<div class="row">
    @include('account.navbar')
    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-heading">Account Settings</div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" class="form-control" name="name" value="{{ $user->name }}">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" name="email" value="{{ $user->email }}">
                </div>
                <div class="form-group">
                    <label for="name">Password</label>
                    <input type="password" class="form-control" name="password">
                </div>
                <div class="form-group">
                    <div class="text-right">
                        <button class="btn btn-primary">UPDATE</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection