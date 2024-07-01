@extends('layouts.adminApp')
@section('content')
<script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>

        <div class="card">
            <div class="card-header">Edit Task
                <span class="float-right">
                    <a class="btn btn-primary" href="{{ route('tasks.index') }}">List</a>
                </span>
            </div>

            <div class="card-body">
            {!! Form::model($model, ['route' => ['tasks.update', $model->id], 'method'=>'PATCH', 'files' => true]) !!}
                <div class="row mb-3">
                    <div class="col-sm-6">
                        <div class="form-group">
                             <label class="col-form-label">Title</label> <span class="invalid">*</span>
                            {!! Form::text('title', null, array('placeholder' => 'Title','class' => 'form-control')) !!}
                        </div>
                        @if ($errors->has('title'))
                                <span class="invalid feedback"role="alert">
                                    <strong>{{ $errors->first('title') }}.</strong>
                                </span>
                        @endif
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-form-label">Keywords</label> <span class="invalid">*</span>
                            {!! Form::text('keyword', null, array('placeholder' => 'keyword','class' => 'form-control')) !!}
                        </div>
                        @if ($errors->has('name'))
                                <span class="invalid feedback is-invalid " role="alert">
                                    <strong>{{ $errors->first('keyword') }}.</strong>
                                </span>
                        @endif
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                             <label class="col-form-label">Word Count</label> <span class="invalid">*</span>
                            {!! Form::text('word_count', null, array('placeholder' => 'Word Count','class' => 'form-control')) !!}
                        </div>
                        @if ($errors->has('word_count'))
                                <span class="invalid feedback"role="alert">
                                    <strong>{{ $errors->first('word_count') }}.</strong>
                                </span>
                        @endif
                    </div>
                    <div class="col-sm-6"> 
                        <div class="form-group">
                            <label class="col-form-label">Priority</label> <span class="invalid">*</span>
                            {!! Form::select('priority', ['1'=>'Normal','2'=>'High', '3'=>'Urgent',],$model->priority, array('class' => 'form-control selectpicker')) !!}
                        </div>
                        @if ($errors->has('priority'))
                                <span class="invalid feedback"role="alert">
                                    <strong>{{ $errors->first('priority') }}.</strong>
                                </span>
                        @endif
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                             <label class="col-form-label">Guideline</label>
                             {{ Form::textarea("guideline", $model->guideline ?? '', ['class' => 'form-control form-control-solid form-control-lg','id' => 'guideline']) }}
                        </div>
                        @if ($errors->has('operator_email'))
                                <span class="invalid feedback"role="alert">
                                    <strong>{{ $errors->first('operator_email') }}.</strong>
                                </span>
                        @endif

                        <script>
                            /* CKEDITOR for description */
                            CKEDITOR.replace( <?php echo 'guideline'; ?>,
                            {
                                filebrowserUploadUrl : '<?php echo URL::to('base/uploder'); ?>',
                                enterMode : CKEDITOR.ENTER_BR,
                                removePlugins: 'sourcearea',
                            });
                            CKEDITOR.config.allowedContent = true;	
                        </script>
                    </div>   
                    <div class="col-sm-12">
                        <div class="form-group">
                             <label class="col-form-label">Content</label>
                             {{ Form::textarea("content",$model->content ?? '', ['class' => 'form-control form-control-solid form-control-lg','id' => 'content']) }}
                        </div>
                        @if ($errors->has('operator_email'))
                                <span class="invalid feedback"role="alert">
                                    <strong>{{ $errors->first('operator_email') }}.</strong>
                                </span>
                        @endif

                        <script>
                            /* CKEDITOR for description */
                            CKEDITOR.replace( <?php echo 'content'; ?>,
                            {
                                filebrowserUploadUrl : '<?php echo URL::to('base/uploder'); ?>',
                                enterMode : CKEDITOR.ENTER_BR,
                                removePlugins: 'sourcearea',
                            });
                            CKEDITOR.config.allowedContent = true;	
                        </script>
                    </div>  
                </div>
                <button type="submit" class="btn btn-primary">Update</button> 
                {!! Form::close() !!}
            </div>
        </div>
@endsection
