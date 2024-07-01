@extends('layouts.adminApp')
@section('content')
        <div class="card">
            <div class="card-header">Create Plan
                <span class="float-right">
                <a class="btn btn-primary" href="{{ route('plan.index') }}">List</a>
            </span>
            </div>
            <div class="card-body">
                {!! Form::open(array('route' => 'plan.store','method'=>'POST')) !!}
                <div class="row mb-3">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="col-form-label">Plan Type</label> <span class="invalid">*</span>
                            {!! Form::select('plan_type', [null => 'Select', 'yearly' => 'Yearly','monthly' => 'Monthly'], null, ['class' => 'form-control']) !!}
                        </div>
                        @if ($errors->has('plan_type'))
                                <span class="invalid feedback" role="alert">
                                    <strong>{{ $errors->first('plan_type') }}.</strong>
                                </span>
                        @endif
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="col-form-label">Name</label> <span class="invalid">*</span>
                            {!! Form::text('plan_name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                        </div>
                        @if ($errors->has('plan_name'))
                                <span class="invalid feedback" role="alert">
                                    <strong>{{ $errors->first('plan_name') }}.</strong>
                                </span>
                        @endif
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="col-form-label">Amount</label> <span class="invalid">*</span>
                            {!! Form::text('amount', null, array('placeholder' => 'Amount','class' => 'form-control')) !!}
                        </div>
                        @if ($errors->has('amount'))
                                <span class="invalid feedback" role="alert">
                                    <strong>{{ $errors->first('amount') }}.</strong>
                                </span>
                        @endif
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="col-form-label">Description:</label>
                            {!! Form::textarea('description', null, array('placeholder' => 'Description','class' => 'form-control')) !!}
                        </div>
                        @if ($errors->has('description'))
                                <span class="invalid feedback" role="alert">
                                    <strong>{{ $errors->first('description') }}.</strong>
                                </span>
                        @endif
                    </div>
                        
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
                {!! Form::close() !!}
            </div>
        </div>
@endsection
