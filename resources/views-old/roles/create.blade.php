@extends('layouts.adminApp')
@section('content')
            <div class="card">
                <div class="card-header">Create role
                    <span class="float-right">
                    <a class="btn btn-primary" href="{{ route('roles.index') }}">Roles</a>
                </span>
                </div>
                <div class="card-body">
                    {!! Form::open(array('route' => 'roles.store','method'=>'POST')) !!}
                    <div class="form-group">
                         <label class="col-form-label">Name</label> <span class="invalid">*</span>
                        {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Permission</label> <span class="invalid">*</span>
                        @foreach($permission as $value)
                            <label>{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}
                                {{ $value->name }}</label>
                            <br/>
                        @endforeach
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    {!! Form::close() !!}
                </div>
            </div>
@endsection
