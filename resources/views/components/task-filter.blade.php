{!! Form::open(array('url' => $sendUrl ,'method'=>'GET', 'id' => 'scoreForm')) !!}
    <div class="card-body">
        <div class="col-sm-12 row mb-3 align-items-end">
            @if(Auth()->user()->hasRole('admin'))
            <div class="col-sm-3">
                <div class="form-group">
                    <label class="col-form-label">Created By</label>
                    {!! Form::select('created_by', ['' => 'Select'] + $buyerList,!empty($_GET['created_by']) ? $_GET['created_by']:null , array('data-live-search'=>'true', 'class' => 'form-control selectpicker', 'data-live-search'=>"true")) !!}
                </div>
            </div>
            @endif
            @if(Auth()->user()->hasRole('admin') || Auth()->user()->hasRole('Buyer'))
            <div class="col-sm-3">
                <div class="form-group">
                    <label class="col-form-label">Writer</label>
                    {!! Form::select('writer', ['' => 'Select'] + $writerList,!empty($_GET['writer']) ? $_GET['writer']:null , array('data-live-search'=>'true', 'class' => 'form-control selectpicker', 'data-live-search'=>"true")) !!}
                </div>
            </div>
            @endif
            <div class="col-sm-3">
                <div class="form-group">
                    <label class="col-form-label">Title</label>
                    {!! Form::text('title',!empty($_GET['title']) ? $_GET['title']:null , array('data-live-search'=>'true', 'class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label class="col-form-label">Status</label>
                    {!! Form::select('status', ['' => 'Select', 0=>'Pending', 1=>'Accept', 2=>'Cancel', 3=>'Approved', 4=>'Need corretion', 5=>'Rejected'] ,!empty($_GET['status']) ? $_GET['status']:null , array('data-live-search'=>'true', 'class' => 'form-control', 'data-live-search'=>"true")) !!}
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label class="col-form-label">Priority</label>
                    {!! Form::select('priority', ['' => 'Select', 1=>'Normal', 2=>'High', 3=>'Urgent'] ,!empty($_GET['priority']) ? $_GET['priority']:null , array('data-live-search'=>'true', 'class' => 'form-control', 'data-live-search'=>"true")) !!}
                </div>
            </div>
            <div class="col-sm-3 mt-3">
            <button type="submit" id="scoresubmit" class="btn btn-primary">Submit</button>
            <a href="{{ $sendUrl }}" class="btn btn-warning">Reset</a> 
            </div>
        </div>
    </div>
{!! Form::close() !!}    
