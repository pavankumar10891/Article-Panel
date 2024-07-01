@extends('layouts.adminApp')
@section('content')
            <div class="card">
                <div class="card-header">Post
                    @can('role-create')
                        <span class="float-right">
                        <a class="btn btn-primary" href="{{ route('posts.index') }}">Back</a>
                    </span>
                    @endcan
                </div>
                <div class="card-body">
                    <div class="lead">
                        <strong>Title:</strong>
                        {{ $post->title }}
                    </div>
                    <div class="lead">
                        <strong>Body:</strong>
                        {{ $post->body }}
                    </div>
                </div>
            </div>
@endsection
