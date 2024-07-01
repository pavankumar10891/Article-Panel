@extends('layouts.authApp')

@section('content')
<div class="container">
    <div class="authentication-wrapper authentication-basic container">
        <div class="row">
            <div class="card mb-2">
                <div class="card-body">
                    <!-- Logo -->
                    <div class="app-brand justify-content-center">
                        <a href="javascript:void(0)" class="app-brand-link gap-2">
                            <span class="app-brand-text demo text-body fw-bolder">Writer Signup</span>
                        </a>
                    </div>
                    <!-- /Logo -->
                    <form method="POST" action="{{ route('writerSignup') }}" class="mb-3">
                        @csrf
                        <div class="row ">
                            <div class="col-md-4 mb-2">
                                <label for="first_name" class="form-label text-md-end">{{ __('First Name') }}</label>
                                <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}"  autocomplete="first_name" autofocus>
                                @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-2">
                                <label for="last_name" class="form-label text-md-end">{{ __('Last Name') }}</label>
                                <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}"  autocomplete="last_name" autofocus>
                                @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-2">
                                <label for="email" class="form-label text-md-end">{{ __('Email Address') }}</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-2">
                                <label for="mobile" class="form-label text-md-end">{{ __('Mobile') }}</label>
                                <input id="mobile" type="text" class="form-control @error('mobile') is-invalid @enderror" name="mobile" value="{{ old('mobile') }}"  autocomplete="mobile" autofocus>
                                @error('mobile')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-2">
                                <label for="designation" class="form-label text-md-end">{{ __('Designation') }}</label>
                                <input id="designation" type="text" class="form-control @error('designation') is-invalid @enderror" name="designation" value="{{ old('designation') }}"  autocomplete="designation" autofocus>
                                @error('designation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-2">
                                <label for="ppw" class="form-label text-md-end">{{ __('PPW') }}</label>
                                <input id="ppw" type="text" class="form-control @error('ppw') is-invalid @enderror" name="ppw" value="{{ old('ppw') }}"  autocomplete="ppw" autofocus>
                                @error('ppw')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-2">
                                <label for="experience" class="form-label text-md-end">{{ __('Experience') }}</label>
                                <input id="experience" type="text" class="form-control @error('experience') is-invalid @enderror" name="experience" value="{{ old('experience') }}"  autocomplete="experience" autofocus>
                                @error('experience')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-2">
                                <label for="daily_capecity" class="form-label text-md-end">{{ __('Daily Capicity') }}</label>
                                <input id="daily_capecity" type="text" class="form-control @error('daily_capecity') is-invalid @enderror" name="daily_capecity" value="{{ old('daily_capecity') }}"  autocomplete="daily_capecity" autofocus>
                                @error('daily_capecity')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-2">
                                <label for="address" class="form-label text-md-end">{{ __('Address') }}</label>
                                <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}"  autocomplete="address" autofocus>
                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-2">
                                <label for="bio" class="form-label text-md-end">{{ __('Bio') }}</label>
                                <textarea class="form-control" name="bio" id="exampleFormControlTextarea1" rows="3">{{ old('daily_capecity') }}</textarea>
                                @error('bio')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-2">
                                <label for="expert_niche" class="form-label text-md-end">{{ __('Expert Niche') }}</label>
                                <textarea class="form-control" name="expert_niche" id="expert_niche" rows="3">{{ old('daily_capecity') }}</textarea>
                                @error('expert_niche')
                                    <span class="invalid-feedback" role="alert" style="display: block;">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                           

                            <div class="col-md-6 mb-2">
                                <label for="password" class="form-label text-md-end">{{ __('Password') }}</label>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"  autocomplete="current-password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>

                            <div class="col-md-6 mb-2">
                                <label for="password_confirmation" class="form-label text-md-end">{{ __('Confirm confirmed') }}</label>
                                    {!! Form::password('password_confirmation', array('placeholder' => 'Confirm Password','class' => 'form-control')) !!}
                                    @error('password_confirmation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>

                        </div>
                    

                        <div class="row mb-2" >
                            <div class="col-md-12">
                                <div class="app-brand justify-content-center ">
                                    <button type="submit" class="btn btn-primary ms-1 px-5">
                                        {{ __('Submit') }}
                                    </button>
                                    <a href="{{route('login')}}" class="btn btn-primary ms-1 px-5">
                                        {{ __('Login') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
