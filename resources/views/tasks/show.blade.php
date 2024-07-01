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
function formatMilliseconds($milliseconds) {
    $seconds = floor($milliseconds / 1000);
    $minutes = floor($seconds / 60);
    $hours = floor($minutes / 60);
    $milliseconds = $milliseconds % 1000;
    $seconds = $seconds % 60;
    $minutes = $minutes % 60;

    $format = '%u:%02u:%02u.%03u';
    $time = sprintf($format, $hours, $minutes, $seconds, $milliseconds);
    return rtrim($time, '0');
}
?>
<script>
    
</script>

            <div class="card">
               
                <div class="card-header">
                    <h5>View Task<span style="float: right;">
                        @if($model->status == 0)
                            @if(auth()->user()->hasRole('Writer')) 
                            <a href="javascript:void(0)" onclick="acceptTask('{{ route('tasks.status',[$model->id,1]) }}')" data-bs-toggle="tooltip" class="btn btn-sm btn-success" data-bs-placement="top" title="" data-bs-original-title="Accept" aria-label="Accept">
                            Accept
                            </a>
                            <a  href="javascript:void(0)" onclick="rejectTask('{{ route('tasks.status',[$model->id,2]) }}')" data-bs-toggle="tooltip" class="btn btn-sm btn-danger" data-bs-placement="top" title="" data-bs-original-title="Reject" aria-label="Reject">
                            Cancel
                            </a>
                            @endif
                        @endif
                        @if(Auth()->user()->hasRole('Writer'))
                            @if(($model->status == 1) || ($model->status == 4))
                            <a  href="{{ route('article.create',$model->id) }}" class="btn btn-sm btn-info"> Start Wrting </a>
                            @endif
                        @endif 
                           
                    </span></h5>
                </div>
                <div class="card-body">
                    <dl class="row mt-2">

                        <dt class="col-sm-3">Created BY </dt>
                        <dd class="col-sm-9">{{ ucfirst($model->user->name) }}</dd>

                        <dt class="col-sm-3">Title</dt>
                        <dd class="col-sm-9">{{ $model->title }}</dd>

                        <dt class="col-sm-3">Word Count</dt>
                        <dd class="col-sm-9">{{ $model->word_count }}</dd>

                        <dt class="col-sm-3 text-truncate">Status</dt>
                        <dd class="col-sm-9">
                            @if($model->status == 0)
                            <span class="badge bg-label-warning me-1">Pending</span>
                            @elseif($model->status == 1)
                            <span class="badge bg-label-success me-1">Accept</span>
                            @elseif($model->status == 2)
                                <span class="badge bg-label-danger me-1">Cancel</span>
                                @elseif($model->status == 3)
                                <span class="badge bg-label-success me-1">Approve</span>
                                @elseif($model->status == 4)
                                <span class="badge bg-label-warning me-1">Need corretion</span>
                                @elseif($model->status == 5)
                                <span class="badge bg-label-warning me-1">Reject</span>
                            @endif
                        </dd>
                        @if(($model->status == 4) || $model->status == 5)
                        <dt class="col-sm-3 text-truncate">Comment</dt>
                        <dd class="col-sm-9">
                                {{$model->article->comment}}
                        </dd>
                        @endif

                        <dt class="col-sm-3 text-truncate">Priority</dt>
                        <dd class="col-sm-9">
                            @if($model->priority == 1)
                                <span class="badge bg-label-success me-1">Normal</span>
                                @elseif($model->priority == 2)
                            <span class="badge bg-label-warning me-1">High</span>
                            @elseif($model->priority == 3)
                                <span class="badge bg-label-danger me-1">Urgent</span>
                            @endif 
                            </dd>
                        <dt class="col-sm-3">Guideline</dt>
                        <dd class="col-sm-9">{!! $model->guideline !!}</dd>

                        <dt class="col-sm-3">Content</dt>
                        <dd class="col-sm-9">{!! $model->content !!}</dd>

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
            @if(!empty($model->article->article_time))
            <?php 
                $articleTimeData = $model->article->article_time; 
                $arrayArray      = explode('__', $articleTimeData);
            ?>
            {{--
            <div class="card">
                <div class="card-header">
                    <h5>Consummed Time</h5>
                    <table class="table">
                        <tr>
                            <td>Date</td>
                            <td>Seconds</td>
                            <td>Word Count</td>
                        </tr>
                        @if(count($arrayArray) > 0)
                        @foreach(array_filter($arrayArray) as $arrayvalue)
                        <?php $explode = explode('_',$arrayvalue) ?>
                        <tr>
                            <td>{{ date('Y-m-d H:i:s', $explode[0])}}</td>
                            <td>{{$explode[1]}}</td>
                            <td>{{$explode[2]}}</td>
                        </tr>
                        @endforeach
                        @endif
                        
                    </table>
                </div>
            </div> --}}
            @endif

            <!-- Basic Bootstrap Table -->
            
            <!--/ Basic Bootstrap Table -->
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
        text: "You won't be able to accept this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, accept it!'
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
        text: "You won't be able to reject this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, reject it!'
        }).then(function(isConfirm) {
            if (isConfirm.value == true) {
                window.location.href=siteurl;
            }

    })
 }
</script>

@endsection



