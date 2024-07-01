@extends('layouts.adminApp')
@section('content')
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
        <div class="card mb-4">
            <div class="card-header"> Article Writing
                <span class="float-right" style="float: right;">
                <a class="btn btn-primary" href="{{ route('tasks.assign') }}">List</a>
            </span>
            </div>
            <div class="card-body">
                @if(($article->task->status == 5) && $article->comment != '')
                    <p style="color:red">Rejected:  {{ $article->comment }}</p>
                @endif
                {!! Form::open(array('route' => 'article.store','method'=>'POST', 'files'=> true)) !!}
                <div class="row mb-3">
                    
                    <div class="col-sm-12">
                        <div class="form-group">
                             <label class="col-form-label">Title</label> <span class="invalid">*</span>
                            {!! Form::text('titletext', $article->task->title ?? null, array('placeholder' => 'Title','class' => 'form-control', 'disabled')) !!}
                            
                        </div>
                        @if ($errors->has('title'))
                                <span class="invalid feedback"role="alert">
                                    <strong>{{ $errors->first('title') }}.</strong>
                                </span>
                        @endif
                    </div>
                    <?php $statusArray = [1,4]; ?>
                    <div class="col-sm-12">
                        <input type="hidden" name="task_id" value="{{$id}}">
                        <div class="form-group">
                             <label class="col-form-label">Article <span class="invalid">*</span></label>
                                @if(($article->task->status == 4) && $article->comment != '')
                                        <p style="color:red">Need to correction:  {{ $article->comment }}</p>
                                @endif
                                @if(in_array($article->task->status,$statusArray))
                                 {{ Form::textarea("article",$article->article ?? '', ['class' => 'form-control form-control-solid form-control-lg', 'keypress' =>'typingAction()', 'id' => 'article']) }}
                                 @else
                                 <p>{!! $article->article  !!}</p>
                                 @endif
                              <!-- <div id="charCount">Characters: 0</div> -->
                              @if(Auth()->user()->hasRole('admin'))
                              <div id="timeElapsed">Time Elapsed: 0 seconds</div>
                              @endif
                        </div>
                        @if ($errors->has('article'))
                                <span class="invalid feedback"role="alert">
                                    <strong>{{ $errors->first('article') }}.</strong>
                                </span>
                        @endif

                        <script>
                            CKEDITOR.replace(<?php echo 'article'; ?>,
                            {
                                filebrowserUploadUrl : '<?php echo URL::to('base/uploder'); ?>',
                                enterMode : CKEDITOR.ENTER_BR,
                                removeButtons:'sourcearea,contextmenu,liststyle,tabletools,Source,Copy,Cut,Paste,Undo,Redo,Print,Form,TextField,Textarea,SelectAll,Table,PasteText,PasteFromWord,Select,HiddenField',
                                on: {
                                    instanceReady: function(ev) {
                                        // Autosave but no more frequent than 5 sec.
                                        var editor = ev.editor;
                                        
                                        editor.editable().attachListener( editor.editable(), 'contextmenu', function( evt ) {
                                            //console.log( evt.data.getTarget() );
                                            console.log(evt.wordCount);
                                            evt.stop();
                                            evt.data.preventDefault();
                                        }, null, null, 0 );
                                        editor.on('paste', function(even) {
                                        // even.data.dataValue = '';
                                            even.cancel();
                                        });
                                        editor.on('copy', function(even) {
                                        // even.data.dataValue = '';
                                            even.cancel();
                                        });
                                        editor.on('cut', function(even) {
                                        // even.data.dataValue = '';
                                            even.cancel();
                                        });
                                        // var buffer = CKEDITOR.tools.eventsBuffer( 5000, function() {

                                        //     //ajax
                                        // });         

                                        //this.on( 'change', buffer.input);
                                    }
                                }

                            });
                            CKEDITOR.config.allowedContent = false;	
                            CKEDITOR.config.disableNativeSpellChecker = false;

                            //CKEDITOR.config.disallowedContent = 'br';

                            // Set up initial character count and time elapsed
                            let charCount = 0;
                            let startTime = new Date().getTime();
                            const charCountElement = document.querySelector('#charCount');
                            const timeElapsedElement = document.querySelector('#timeElapsed');
                            //charCountElement.textContent = `Characters: ${charCount}`;
                            timeElapsedElement.textContent = `Time Elapsed: 0 seconds`;

                            // Function to count characters and update the count
                            function countCharacters() {
                            const editorData = CKEDITOR.instances.article.getData();
                            charCount = editorData.replace(/<[^>]*>/g, '').length;
                             //charCountElement.textContent = `Characters: ${charCount}`;
                            }

                            // Function to calculate and update time elapsed
                            let countWordTime = 0;
                            function updateTimeElapsed() {
                            const currentTime = new Date().getTime();
                            const elapsedTime = Math.floor((currentTime - startTime) / 1000);
                            countWordTime = elapsedTime;
                            timeElapsedElement.textContent = `Time Elapsed: ${elapsedTime} seconds`;
                            }
                            const autosaveDelay = 5000; // Set your desired delay here
                            // Set up an interval to count characters and update time every 10 seconds
                            // setInterval(() => {
                            // countCharacters();
                            // updateTimeElapsed();
                            //     //saveData(countWordTime,charCount);
                            // }, 10000);
                            
                            // Function to save the editor content
                            function saveContent() {
                               //const editorData = CKEDITOR.instances.article.getData();
                                //console.log("Autosaved content:", editorDetail);
                                // Perform an AJAX request or any other method to save the data
                                // For demonstration purposes, we'll simply log the content to the console
                                //console.log("Autosaved content:", editorData);
                               // 
                               
                            }

                            let autosaveTimer;
                            CKEDITOR.instances.article.on('change', function(evd) {
                               
                            clearTimeout(autosaveTimer); // Clear the previous autosave timer

                            // Set a new timer to trigger the autosave after the specified delay
                            autosaveTimer = setTimeout(function() {
                                const editorDetail = CKEDITOR.instances.article;  
                                //console.log();
                                countCharacters();
                                updateTimeElapsed();
                                saveContent();
                                saveData(countWordTime,editorDetail.wordCount.wordCount);
                            }, autosaveDelay);
                            });
                        </script>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-form-label">Meta Title</label> <span class="invalid">*</span>
                            @if(in_array($article->task->status,$statusArray))
                            {!! Form::text('meta_title', $article->meta_title ?? null, array('placeholder' => 'Meta Title','class' => 'form-control')) !!}
                            @else
                            <p>{!! $article->meta_title !!}</p>
                            @endif
                        </div>
                        @if ($errors->has('meta_title'))
                                <span class="invalid feedback is-invalid " role="alert">
                                    <strong>{{ $errors->first('meta_title') }}.</strong>
                                </span>
                        @endif
                    </div>  
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-form-label">Meta Keywords</label> <span class="invalid">*</span>
                            @if(in_array($article->task->status,$statusArray))
                            {!! Form::text('meta_keyword', $article->meta_keyword ?? null, array('placeholder' => 'Meta Keywords','class' => 'form-control')) !!}
                            @else
                            <p>{!! $article->meta_keyword !!}</p>
                            @endif
                        </div>
                        @if ($errors->has('meta_keyword'))
                                <span class="invalid feedback is-invalid " role="alert">
                                    <strong>{{ $errors->first('meta_keyword') }}.</strong>
                                </span>
                        @endif
                    </div>
                    
                    <div class="col-sm-12">
                        <div class="form-group">
                             <label class="col-form-label">Meta Description</label> <span class="invalid">*</span>
                             @if(in_array($article->task->status,$statusArray))
                             {{ Form::textarea("meta_desc", $article->meta_desc ?? '', ['class' => 'form-control form-control-solid form-control-lg','id' => 'meta_desc']) }}
                             @else
                             <p>{!! $article->meta_keyword !!}</p>
                             @endif
                        </div>
                        @if ($errors->has('meta_desc'))
                                <span class="invalid feedback"role="alert">
                                    <strong>{{ $errors->first('meta_desc') }}.</strong>
                                </span>
                        @endif

                        <script>
                            /* CKEDITOR for description */
                            CKEDITOR.replace( <?php echo 'meta_desc'; ?>,
                            {
                                filebrowserUploadUrl : '<?php echo URL::to('base/uploder'); ?>',
                                enterMode : CKEDITOR.ENTER_BR,
                                removeButtons:'sourcearea,contextmenu,liststyle,tabletools,Source,Copy,Cut,Paste,Undo,Redo,Print,Form,TextField,Textarea,SelectAll,CreateDiv,Table,PasteText,PasteFromWord,Select,HiddenField',
                                on: {
                                    instanceReady: function(ev) {
                                        // Autosave but no more frequent than 5 sec.
                                        var editor = ev.editor;
                                        editor.editable().attachListener( editor.editable(), 'contextmenu', function( evt ) {
                                            console.log( evt.data.getTarget() );
                                            evt.stop();
                                            evt.data.preventDefault();
                                        }, null, null, 0 );
                                        editor.on('paste', function(even) {
                                        // even.data.dataValue = '';
                                            even.cancel();
                                        });
                                        editor.on('copy', function(even) {
                                        // even.data.dataValue = '';
                                            even.cancel();
                                        });
                                        editor.on('cut', function(even) {
                                        // even.data.dataValue = '';
                                            even.cancel();
                                        });
                                        var buffer = CKEDITOR.tools.eventsBuffer( 5000, function() {

                                            //ajax
                                        });         

                                        this.on( 'change', buffer.input);
                                    }
                                }

                            });
                            CKEDITOR.config.allowedContent = true;	
                        </script>
                    </div>  
                   {{--
                    <div class="col-sm-6">
                        <div class="form-group">
                             <label class="col-form-label">Feature Image</label> 
                             <!-- <span class="invalid">*</span> -->
                             <input type="file" class="form-control"  name="image"/>
                        </div>
                        @if ($errors->has('image'))
                                <span class="invalid feedback"role="alert">
                                    <strong>{{ $errors->first('image') }}.</strong>
                                </span>
                        @endif
                    </div> --}}
                     
                </div>
                @if(in_array($article->task->status,$statusArray))
                <button type="submit" name="savetodraft" class="btn btn-primary">Save to Draft</button> 
                <button type="submit" class="btn btn-primary" name="finalsubmit" value="finalsubmit">Final Submit</button> 
                @endif
                {!! Form::close() !!}
            </div>
        </div>
        
@endsection
@section('script')
<script>
// $(document).bind("contextmenu",function(e){
//     return false;
// });
// $(document).ready(function () {
//    $('body').bind('cut copy paste', function (e) {
//       e.preventDefault();
//    });
// });
jQuery('input.disablePaste').keydown(function(event) {
    var forbiddenKeys = new Array('c', 'x', 'v');
    var keyCode = (event.keyCode) ? event.keyCode : event.which;
    var isCtrl;
    isCtrl = event.ctrlKey
    if (isCtrl) {
        for (i = 0; i < forbiddenKeys.length; i++) {
            if (forbiddenKeys[i] == String.fromCharCode(keyCode).toLowerCase()) {
                 return false;
            }
        }
    }
    return true;
});

function saveData(starttime, wordcount){
    var text = CKEDITOR.instances['article'].getData();
    var taskId      = '{{ $id }}';
    var cleanText   = text.replace(/\s+/g, ' ');
    cleanText = cleanText.replace(/<br>/gi, '');


    //countWords
    $.ajax({
            type: "POST",
            url: "{{route('addArticle')}}",
            data:{"_token": "{{ csrf_token() }}",text:text,taskId:taskId,starttime:starttime,wordcount:wordcount,cleanText:cleanText},
            success: function(result) {
                //console.log(result);
            }
    });
    
 }

 function countWords(s){
    s = s.replace(/(^\s*)|(\s*$)/gi,"");//exclude  start and end white-space
    s = s.replace(/[ ]{2,}/gi," ");//2 or more space to 1
    s = s.replace(/\n /,"\n"); // exclude newline with a start spacing
    return s.split(' ').filter(function(str){return str!="";}).length;
    //return s.split(' ').filter(String).length; - this can also be used
}


function typingAction(){
    // clearTimeout();
    // setTimeout(()=>{
    //     console.log(text);  
    // $('#typing').text(' user stopped typing.....'); //**can call your function here**
        
    // },5000);
    alert();
}   

</script>
@endsection