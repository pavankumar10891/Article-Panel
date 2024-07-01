@extends('layouts.adminApp')
@section('content')
            <div class="card">
                <div class="card-header">Create permission
                    <span class="float-right">
                    <a class="btn btn-primary" href="{{ route('permissions.index') }}">Permissions</a>
                </span>
                </div>
                <div class="card-body">
                    {!! Form::open(array('route' => 'permissions.store','method'=>'POST')) !!}
                    <div class="form-group">
                         <label class="col-form-label">Name</label> <span class="invalid">*</span>
                        {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    {!! Form::close() !!}
                </div>
            </div>
@endsection
