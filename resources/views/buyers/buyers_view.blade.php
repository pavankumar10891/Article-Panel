@extends('layouts.adminApp')
@section('content')
            <div class="card">
                <div class="card-header">User
                    @can('role-create')
                        <span class="float-right">
                        <a class="btn btn-primary" href="{{ route('users.index') }}">Back</a>
                    </span>
                    @endcan
                </div>
                <div class="card-body">
                    <div class="lead">
                        <strong>Name:</strong>
                        {{ $model->name }}
                    </div>
                    <div class="lead">
                        <strong>User Name:</strong>
                        {{ $model->user_name }}
                    </div>
                    <div class="lead">
                        <strong>Email:</strong>
                        {{ $model->email }}
                    </div>
                    <div class="lead">
                        <strong>Designation:</strong>
                        {{ $model->designation }}
                    </div>
                    <div class="lead">
                        <strong>Bio:</strong>
                        {{ $model->bio }}
                    </div>
                </div>
            </div>
@endsection
