@extends('layouts.adminApp')
@section('content')
            <div class="card">
                <div class="card-header">Create post
                    <span class="float-right">
                    <a class="btn btn-primary" href="{{ route('posts.index') }}">Posts</a>
                </span>
                </div>
                <div class="card-body">
                    {!! Form::model($post, ['route' => ['posts.update', $post->id], 'method'=>'PATCH']) !!}
                    <div class="form-group">
                        <strong>Title:</strong>
                        {!! Form::text('title', null, array('placeholder' => 'Title','class' => 'form-control')) !!}
                    </div>
                    <div class="form-group">
                        <strong>Body:</strong>
                        {!! Form::textarea('body', null, array('placeholder' => 'Body','class' => 'form-control')) !!}
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    {!! Form::close() !!}
                </div>
            </div>
@endsection
