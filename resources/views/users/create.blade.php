@extends('layouts.adminApp')
@section('content')

        <div class="card mb-4">
            <div class="card-header">Create user
                <span class="float-right">
                    <a class="btn btn-primary" href="{{ route('users.index') }}">Users</a>
                </span>
            </div>

            <div class="card-body">
                {!! Form::open(array('route' => 'users.store','method'=>'POST')) !!}
                <div class="row mb-3">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-form-label">Name</label> <span class="invalid">*</span>
                            {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                        </div>
                        @if ($errors->has('name'))
                                <span class="invalid feedback is-invalid " role="alert">
                                    <strong>{{ $errors->first('name') }}.</strong>
                                </span>
                        @endif
                    </div>  
                    <div class="col-sm-6">  
                        <div class="form-group">
                            <label class="col-form-label">Email</label> <span class="invalid">*</span>
                            {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control')) !!}
                        </div>
                        @if ($errors->has('email'))
                                <span class="invalid feedback"role="alert">
                                    <strong>{{ $errors->first('email') }}.</strong>
                                </span>
                        @endif 
                    </div>
                    <div class="col-sm-6"> 
                        <div class="form-group">
                            <label class="col-form-label">Password</label> <span class="invalid">*</span>
                            {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control')) !!}
                        </div> 
                        @if ($errors->has('password'))
                                <span class="invalid feedback"role="alert">
                                    <strong>{{ $errors->first('password') }}.</strong>
                                </span>
                        @endif
                    </div>
                    <div class="col-sm-6"> 
                        <div class="form-group">
                            <label class="col-form-label">Confirm Password</label> <span class="invalid">*</span>
                            {!! Form::password('password_confirmation', array('placeholder' => 'Confirm Password','class' => 'form-control')) !!}
                        </div>
                        @if ($errors->has('password_confirmation'))
                                <span class="invalid feedback"role="alert">
                                    <strong>{{ $errors->first('password_confirmation') }}.</strong>
                                </span>
                        @endif
                    </div>
                    <div class="col-sm-6"> 
                        <div class="form-group">
                            <label class="col-form-label">Role</label> <span class="invalid">*</span>
                            {!! Form::select('roles[]', $roles,[], array('class' => 'form-control selectpicker', 'data-live-search'=>"true")) !!}
                        </div>
                        @if ($errors->has('roles'))
                                <span class="invalid feedback"role="alert">
                                    <strong>{{ $errors->first('roles') }}.</strong>
                                </span>
                        @endif
                    </div>

                </div>    
                <button type="submit" class="btn btn-primary">Submit</button>
                {!! Form::close() !!}
            </div>
        </div>
@endsection
@section('script')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
<script>
    $('select').selectpicker();
</script>
@endsection
