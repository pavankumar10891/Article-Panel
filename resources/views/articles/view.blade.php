@extends('layouts.adminApp')
@section('content')
<script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
<style>
    .cke_skin_kama .cke_charcount {
display:block;
float:right;
margin-top:5px;
margin-right:3px;
color:#60676A;
}
.cke_charcount span.cke_charcount_count,
.cke_charcount span.cke_charcount_limit  {
font-style: italic;
}
</style>
<?php
function formatseconds($seconds) {
    $minutes = floor($seconds / 60);
    $hours = floor($minutes / 60);
    $remainingMinutes = $minutes % 60;
    $remainingSeconds = $seconds % 60;
   return  "Hours: " . $hours . ", Minutes: " . $remainingMinutes . ", Seconds: " . $remainingSeconds;

}
function time_diff($startDateTime, $endDateTime) {
    $datetime1 = new DateTime($startDateTime);
    $datetime2 = new DateTime($endDateTime);
    $interval = $datetime1->diff($datetime2);

    return $interval->format('%H:%I:%S');
}
?>
<script>
    
</script>

            <div class="card">
               
                <div class="card-header">
                    <h5>View Article<span style="float: right;">
                    
                        @if(Auth()->user()->hasRole('Writer'))
                            @if(($model->task->status == 1) || ($model->task->status == 4))
                            <a  href="{{ route('article.create',$model->task_mangement_id) }}" class="btn btn-sm btn-info"> Start Wrting </a>
                            @endif
                        @else
                           @if($model->task->status != 5)
                                <a  href="{{ route('article.download', [$model->task_mangement_id]) }}" class="btn btn-sm btn-info">Download Article </a>
                                @if($model->task->status != 3)
                                <a href="javascript:void(0)" onclick="acceptTask('{{ route('tasks.status',[$model->task_mangement_id,3]) }}')" data-bs-toggle="tooltip" class="btn btn-sm btn-success" data-bs-placement="top" title="" data-bs-original-title="Accept" aria-label="Accept">
                                    Approve
                                </a>
                                <a  href="javascript:void(0)" onclick="rejectTask()" data-bs-toggle="tooltip" class="btn btn-sm btn-danger" data-bs-placement="top" title="" data-bs-original-title="Reject" aria-label="Reject">
                                    Reject
                                </a>
                                <a  href="javascript:void(0)" onclick="needCorection()" class="btn btn-sm btn-info"> Correction </a>
                                @endif
                            @endif
                        @endif 
                           
                    </span></h5>
                </div>
                <div class="card-body">
                    <dl class="row mt-2">
                        <dt class="col-sm-3">Title</dt>
                        <dd class="col-sm-9">{{ $model->task->title }}</dd>

                        <dt class="col-sm-3">Article</dt>
                        <dd class="col-sm-9">{!! $model->article !!}</dd>

                        

                        <dt class="col-sm-3">Meta Title</dt>
                        <dd class="col-sm-9">{!! $model->meta_title !!}</dd>

                        <dt class="col-sm-3">Meta Keywords</dt>
                        <dd class="col-sm-9">{!! $model->meta_keyword !!}</dd>


                        <dt class="col-sm-3">Meta Description</dt>
                        <dd class="col-sm-9">{!! $model->meta_desc !!}</dd>


                        <dt class="col-sm-3">Created At</dt>
                        <dd class="col-sm-9">{{ date('Y-m-d', strtotime($model->created_at)) }}</dd>
                    </dl>
                     {{--
                    <div class="col-sm-12">
                        
                        <div class="form-group">
                            <p style="text-align:right">Time:{{formatMilliseconds($model->article_time)}}</p>
                             <label class="col-form-label">Article</label>
                             {{ Form::textarea("article", $model->article ?? '', ['oninput' =>'typingAction()', 'class' => 'form-control form-control-solid form-control-lg content','id' => 'content']) }}
                             <p id="total_word_count"></p>
                        </div>
                        @if ($errors->has('operator_email'))
                                <span class="invalid feedback"role="alert">
                                    <strong>{{ $errors->first('operator_email') }}.</strong>
                                </span>
                        @endif
                        <script>
                           

                            CKEDITOR.replace( <?php echo 'content'; ?>,
                            {
                                filebrowserUploadUrl : '<?php echo URL::to('base/uploder'); ?>',
                                enterMode : CKEDITOR.ENTER_BR,
                                removeButtons:'contextmenu,liststyle,tabletools,Source,Copy,Cut,Paste,Undo,Redo,Print,Form,TextField,Textarea,SelectAll,NumberedList,BulletedList,CreateDiv,Table,PasteText,PasteFromWord,Select,HiddenField',
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
                                            
                                        });         

                                        this.on( 'change', buffer.input);
                                    }
                                }
                            });
                            CKEDITOR.config.allowedContent = true;	



                            
                           
                        </script>
                    </div>  --}}
                </div>


            </div>
            @if(!empty($model->article_time))
            <?php 
                $articleTimeData = $model->article_time; 
                $arrayArray      = explode('__', $articleTimeData);
                $totalTime       = 0;
                $totalWord       = 0;
            ?>
                @if(Auth()->user()->hasRole(['admin', 'Buyer']))
                    <div class="card">
                        <div class="card-header">
                            <h5>Consummed Time</h5>
                            <table class="table">
                                <tr>
                                    <th>Date</td>
                                    <th>Seconds</td>
                                    <th>Word Count</td>
                                </tr>
                                

                                
                                @if(count($arrayArray) > 0)
                                @php 
                                $totalTime  = 0;
                                $totalWord  = 0;
                                $startTime  = '';
                                $EndTime    = '';
                                @endphp
                                @foreach(array_filter($arrayArray) as $arrayvalue)
                                @php
                                     $explode    = explode('_',$arrayvalue);
                                    @endphp
                                    @if ($loop->first)
                                       @php 
                                        $startTime    = $explode[0];
                                       @endphp 
                                    @endif
                                    @if ($loop->last)
                                        @php 
                                        $EndTime    = $explode[0];
                                       @endphp 
                                    @endif
                                <?php 
                                    $explode    = explode('_',$arrayvalue);
                                    $time      = explode(':',$explode[1]);
                                    $word      = explode(':',$explode[2]);
                                    $timeGap   = $totalTime - $time[1];
                                    $totalTime = $totalTime + $time[1];
                                    if($word[1] > 0){
                                        $totalWord = $totalWord + $word[1];
                                    }else{
                                        $totalWord = $totalWord + 0; 
                                    }
                                    
                                ?>
                                <tr>
                                    <td>{{ date('Y-m-d H:i:s', $explode[0])}}</td>
                                    <td>{{$explode[1]}}</td>
                                    <td>{{$explode[2]}}</td>
                                </tr>
                                @endforeach
                                <tr>
                                    <th>{{ time_diff(date('Y-m-d H:i:s', $startTime),date('Y-m-d H:i:s', $EndTime)) }}</td>
                                    <th>{{ formatseconds ($totalTime) }} </td>
                                    <th>{{ $totalWord }}</td>
                                </tr>
                                @endif
                                
                            </table>
                        </div>
                    </div>
                @endif
            @endif

            <!-- Basic Bootstrap Table -->
            <!-- Reason Models -->
            <!--/ Basic Bootstrap Table -->
            <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Reason</h5>
                        <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                        ></button>
                    </div>
                    {!! Form::open(array('route' => 'articles.comment','method'=>'POST', 'files'=> true)) !!}
                    <div class="modal-body">
                        <div class="row">
                        
                            <input type="hidden" name="taskId" value="{{ $model->task_mangement_id }}" id="taskId">
                                <!-- <label for="nameWithTitle" class="form-label">Name</label> -->
                                <textarea name="reject" id="reject" cols="30" rows="10" required></textarea>
                            <script>
                           

                            CKEDITOR.replace( <?php echo 'reject'; ?>,
                            {
                                filebrowserUploadUrl : '<?php echo URL::to('base/uploder'); ?>',
                                enterMode : CKEDITOR.ENTER_BR,
                                removeButtons:'contextmenu,liststyle,tabletools,Source,Copy,Cut,Paste,Undo,Redo,Print,Form,TextField,Textarea,SelectAll,CreateDiv,Table,PasteText,PasteFromWord,Select,HiddenField',
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
                                            
                                        });         

                                        this.on( 'change', buffer.input);
                                    }
                                }
                            });
                            CKEDITOR.config.allowedContent = true;	
                           
                        </script>
                            
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                    {!! Form::close() !!}
                    </div>
                </div>
            </div>
            <!-- correction Models -->
            <div class="modal fade" id="correctionmodalCenter" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="correctionmodalCenterTitle">Comment</h5>
                        <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                        ></button>
                    </div>
                    {!! Form::open(array('route' => 'articles.comment','method'=>'POST', 'files'=> true)) !!}
                    <div class="modal-body">
                        <div class="row">
                        
                            <input type="hidden" name="taskId" value="{{ $model->task_mangement_id }}" id="taskId">
                                <!-- <label for="nameWithTitle" class="form-label">Name</label> -->
                                <textarea name="comment" id="comment" cols="30" rows="10" required></textarea>
                            <script>
                           

                            CKEDITOR.replace( <?php echo 'comment'; ?>,
                            {
                                filebrowserUploadUrl : '<?php echo URL::to('base/uploder'); ?>',
                                enterMode : CKEDITOR.ENTER_BR,
                                removeButtons:'contextmenu,liststyle,tabletools,Source,Copy,Cut,Paste,Undo,Redo,Print,Form,TextField,Textarea,SelectAll,CreateDiv,Table,PasteText,PasteFromWord,Select,HiddenField',
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
                                            
                                        });         

                                        this.on( 'change', buffer.input);
                                    }
                                }
                            });
                            CKEDITOR.config.allowedContent = true;	
                           
                        </script>
                            
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                    {!! Form::close() !!}
                    </div>
                </div>
            </div>
@endsection
@section('script')
<script>
   

CKEDITOR.instances.content.on('change', function () { 
    var text = this.getData();
    var chractor = this.getData().replace(/<[^>]*>/g, '').replace(/\s+/g, ' ').replace(/&\w+;/g ,'X').replace(/^\s*/g, '').replace(/\s*$/g, '').length;
    $('#total_word_count').html('Total charator '+ chractor);
});


// function saveData(starttime){
//     var text = CKEDITOR.instances['content'].getData();
//     var taskId = '{{ $model->id }}';
//     $.ajax({
//             type: "POST",
//             url: "{{route('addArticle')}}",
//             data:{"_token": "{{ csrf_token() }}",text:text,taskId:taskId,starttime:starttime},
//             success: function(result) {
//                 console.log(result);
//             }
//     });
    
//  } 
function typingAction(){
    clearTimeout();
    setTimeout(()=>{
    var text = this.val();
    $('#typing').text(' user stopped typing.....'); //**can call your function here**
        console.log(text);   
    },5000);
}   



</script>
<script>
  function acceptTask(siteurl){
    var token = $("meta[name='csrf-token']").attr("content");
    swal({
        title: 'Are you sure?',
        //text: "You won't be able to approve this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, approve it!'
        }).then(function(isConfirm) {
            if (isConfirm.value == true) {
                window.location.href=siteurl;
            }
    })
 }
 function rejectTask(siteurl){
    var token = $("meta[name='csrf-token']").attr("content");
    swal({
        title: 'Are you sure?',
        //text: "You won't be able to reject this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, reject it!'
        }).then(function(isConfirm) {
            if (isConfirm.value == true) {
                $('#modalCenter').modal('show');
            }
    })
 }
 function needCorection(siteurl){
    var token = $("meta[name='csrf-token']").attr("content");
    swal({
        title: 'Are you sure?',
        //text: "You won't be able to needed correction this!", "you won't be able to needed correction this"
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, needed correction it!'
        }).then(function(isConfirm) {
            if (isConfirm.value == true) {
                $('#correctionmodalCenter').modal('show');
            }
        
    })
 }
</script>

@endsection



