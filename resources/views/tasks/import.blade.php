@extends('layouts.adminApp')
@section('content')

<div class="card mb-4">
    
    <h5 class="card-header">Import Task</h5>
    <div class="card-body">
        @foreach($errors as $key => $error )
        <p class="text-danger text-center"> {{ $error }}</p>
        @endforeach

        {!! Form::open(array('route' => 'tasks.import','method'=>'POST', 'files'=> true)) !!}
        <div class="row gx-3 gy-2 justify-content-md-center">
            <div class="col-md-4 text-center">
                <input class="form-control" name="file" type="file" id="formFile">
            </div>
            <div class="col-md-2 text-center">
                <button id="showToastPlacement" class="btn btn-primary d-block" type="submit">Submit</button>
            </div>
        </div>
        {!! Form::close() !!}
        <div class="row gx-3 gy-2  text-center" ><a href="{{ route('tasks.downloadSample') }}">Download Sample</a></div>
    </div>
</div>
        
@endsection
