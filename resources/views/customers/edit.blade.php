@extends('layouts.adminApp')
@section('content')
        <div class="card">
            <div class="card-header">Edit Customer
                <span class="float-right">
                <a class="btn btn-primary" href="{{ route('customer.index') }}">List</a>
            </span>
            </div>

            <div class="card-body">
                {!! Form::model($user, ['route' => ['customer.update', $user->id], 'method'=>'PATCH', 'files' => true]) !!}
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
                             <label class="col-form-label">User Name</label> <span class="invalid">*</span>
                            {!! Form::text('user_name', null, array('placeholder' => 'User Name','class' => 'form-control')) !!}
                        </div>
                        @if ($errors->has('user_name'))
                                <span class="invalid feedback"role="alert">
                                    <strong>{{ $errors->first('user_name') }}.</strong>
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
                             <label class="col-form-label">Operator Email</label>
                            {!! Form::text('operator_email', null, array('placeholder' => 'Operator Email','class' => 'form-control')) !!}
                        </div>
                        @if ($errors->has('operator_email'))
                                <span class="invalid feedback"role="alert">
                                    <strong>{{ $errors->first('operator_email') }}.</strong>
                                </span>
                        @endif
                    </div>   
                    <div class="col-sm-6">   
                        <div class="form-group">
                            <label class="col-form-label">Phone</label> <span class="invalid">*</span>
                            {!! Form::text('phone', null, array('placeholder' => 'Phone','class' => 'form-control')) !!}
                        </div>
                        @if ($errors->has('phone'))
                                <span class="invalid feedback"role="alert">
                                    <strong>{{ $errors->first('phone') }}.</strong>
                                </span>
                        @endif
                    </div>
                    <div class="col-sm-6"> 
                        <div class="form-group">
                            <label class="col-form-label">Company number</label>
                            {!! Form::text('company_number', null, array('placeholder' => 'Company number','class' => 'form-control')) !!}
                        </div> 
                        @if ($errors->has('company_number'))
                                <span class="invalid feedback"role="alert">
                                    <strong>{{ $errors->first('company_number') }}.</strong>
                                </span>
                        @endif
                    </div>
                    <div class="col-sm-12"> 
                        <div class="form-group">
                            <label class="col-form-label">Website</label>
                            {!! Form::text('website', null, array('placeholder' => 'Website','class' => 'form-control')) !!}
                        </div>
                        @if ($errors->has('website'))
                                <span class="invalid feedback"role="alert">
                                    <strong>{{ $errors->first('website') }}.</strong>
                                </span>
                        @endif 
                    </div>
                    <div class="col-sm-6"> 
                        <div class="form-group">
                            <label class="col-form-label">Password</label>
                            {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control')) !!}
                        </div>
                        @if ($errors->has('confirm_password'))
                                <span class="invalid feedback"role="alert">
                                    <strong>{{ $errors->first('password') }}.</strong>
                                </span>
                        @endif
                    </div>    
                    <div class="col-sm-6">     
                        <div class="form-group">
                            <label class="col-form-label">Confirm Password</label>
                            {!! Form::password('confirm_password', array('placeholder' => 'Confirm Password','class' => 'form-control')) !!}
                        </div>
                        @if ($errors->has('confirm_password'))
                                <span class="invalid feedback"role="alert">
                                    <strong>{{ $errors->first('confirm_password') }}.</strong>
                                </span>
                        @endif
                    </div> 
                    <div class="col-sm-6"> 
                        <div class="form-group">   
                            <label class="form-label">Profile Pic</label>   
                                {!! Form::file('image', array('class' => 'form-control')) !!} 
                            </div> 
                            @if ($errors->has('image'))
                                <span class="invalid feedback"role="alert">
                                    <strong>{{ $errors->first('image') }}.</strong>
                                </span>
                            @endif
                        </div>
                        <img class="w-px-50 h-auto" src="{{asset('uploads/profile_pic/'.$user->image)}}" alt="">
                    </div>
                <button type="submit" class="btn btn-primary">Submit</button>
                {!! Form::close() !!}
            </div>
        </div>
@endsection
