@extends('layouts.adminApp')
@section('content')
            <div class="card">
                <div class="card-header">Permission
                    @can('role-create')
                        <span class="float-right">
                        <a class="btn btn-primary" href="{{ route('permissions.index') }}">Back</a>
                    </span>
                    @endcan
                </div>
                <div class="card-body">
                    <div class="lead">
                        <strong>Name:</strong>
                        {{ $permission->name }}
                    </div>
                </div>
            </div>
@endsection
