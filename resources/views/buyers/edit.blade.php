@extends('layouts.adminApp')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="card-header">Profile Details</h5>
                <!-- Account -->
               
                <hr class="my-0" />
                <div class="card-body">
                    {!! Form::model($user, ['route' => ['buyers.edit', $user->id], 'method'=>'POST', 'files' => true]) !!}
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="firstName" class="form-label">Name</label>
                                <input
                                    class="form-control @error('name') is-invalid @enderror"
                                    type="text"
                                    id="name"
                                    name="name"
                                    value="{{$user->name}}"
                                    autofocus
                                />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="email" class="form-label">E-mail</label>
                                <input
                                    class="form-control @error('email') is-invalid @enderror"
                                    type="text"
                                    id="email"
                                    name="email"
                                    value="{{$user->email}}"
                                    placeholder="hello@example.com"
                                />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="firstName" class="form-label">Password</label>
                                <input
                                    class="form-control @error('password') is-invalid @enderror"
                                    type="password"
                                    id="password"
                                    name="password"
                                />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="firstName" class="form-label">Confirm Password</label>
                                <input
                                    class="form-control @error('password') is-invalid @enderror"
                                    type="password"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                />
                                @if ($errors->has('password'))
                                <span class="invalid feedback"role="alert">
                                    <strong>{{ $errors->first('password') }}.</strong>
                                </span>
                                @endif
                            </div>
                            
                           
                            <div class="col-sm-6 ">
                                <div class="form-group">
                                    <label class="form-label">User Name</label>
                                    {!! Form::text('user_name', null, array('placeholder' => 'User Name','class' => 'form-control', 'disabled' => true)) !!}
                                </div>
                            </div>
                            <div class="col-sm-6">   
                                <div class="form-group">
                                    <label class="form-label">Mobile</label>
                                    {!! Form::text('mobile', null, array('placeholder' => 'Mobile','class' => $errors->has('mobile') ? 'form-control is-invalid':'form-control',)) !!}
                                </div>
                            </div> 

                            <div class="col-sm-6"> 
                                <div class="form-group">
                                    <label class="form-label">Designation</label>
                                    {!! Form::text('designation', null, array('placeholder' => 'designation','class' => $errors->has('designation') ? 'form-control is-invalid':'form-control',)) !!}
                                </div>
                            </div>

                            <div class="col-sm-6"> 
                                <div class="form-group">
                                    <label class="form-label">Bio</label>
                                    {!! Form::textarea('bio', null, ['id' => 'bio', 'rows' => 4, 'class' => 'form-control',  'cols' => 54]) !!}
                                </div>
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
                                <img class="w-px-50 h-auto" src="{{asset('uploads/profile_pic/'.auth()->user()->image)}}" alt="">
                            </div>
                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary me-2">Save changes</button>
                                <button type="reset" class="btn btn-outline-secondary">Cancel</button>
                            </div>
                        </div>
                        
                        
                        
                    {!! Form::close() !!}
                </div>
                <!-- /Account -->
            </div>
            
        </div>
    </div>
@endsection
