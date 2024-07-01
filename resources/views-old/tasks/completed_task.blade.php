@extends('layouts.adminApp')
@section('content')
  <!-- Basic Bootstrap Table -->
  <div class="card">
    <h5 class="card-header">{{$title}}</h5>

    <form method="GET" action="{{ url('tasks/complete-tasks') }}" accept-charset="UTF-8" id="scoreForm">
        <div class="card-body">
          <div class="col-sm-12 row mb-3">

              <div class="col-sm-4">
                  <div class="form-group">
                      <label class="col-form-label">Ttile </label>
                      <input id="name" placeholder="" class="form-control" name="name" type="text">
                  </div>
              </div>
              <div class="col-sm-4">
                  <div class="form-group">
                      <label class="col-form-label">Status</label>
                      <input id="m_ship_no" placeholder="" class="form-control" name="m_ship_no" type="text">
                  </div>
              </div>
              
          </div>
          <button type="submit" id="scoresubmit" class="btn btn-primary">Submit</button>
          <a href="{{ url('tasks/complete-tasks') }}" class="btn btn-warning">Reset</a> 
          <a href="" class="btn btn-warning">Export</a> 
          <a href="" class="btn btn-warning">Export All</a> 

        </div>
      </form>
  
    <div class="table-responsive text-nowrap">
      <table class="table">
        <thead>
          <tr>
            <th>#</th>
            @if(Auth()->user()->hasRole('admin'))
            <th>Created By</th>
            @endif
            @if(Auth()->user()->hasRole(['admin', 'Buyer']))
            <th>Assigned Writer</th>
            @endif
            <th>Title</th>
            <th>Word Count</th>
            <th>Written Word</th>
            <th>PPw</th>
            <th>Inr</th>
            <th>Status</th>
            <th>Created At</th>
            <!-- <th>Action</th> -->
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
            @if($results->count() > 0)
            @php($sl = ($results->perPage() * $results->currentPage()) - ($results->perPage() - 1))
            @foreach ($results as $key => $result)
               <?php 
                $writtenword = isset($result->article->article)? str_word_count(strip_tags(str_replace("&nbsp;","",$result->article->article))) : 0; 
                $ppw  =  $result->writer->ppw ??0;
                $inr  = $result->writer->ppw * $writtenword;
               ?>
                <tr>
                    <td>{{$sl++}}</td>
                    @if(Auth()->user()->hasRole(['admin']))
                    <td>{{ strtoupper($result->user->user_name)}}</td>
                    @endif
                    @if(Auth()->user()->hasRole('admin') || Auth()->user()->hasRole('Buyer'))
                    <td>{{ isset($result->writer->name) ? strtoupper($result->writer->name) :'' }}</td>
                    @endif
                    <td> {!! \Illuminate\Support\Str::limit($result->title, 10,'....')  !!}</td>
                    <td>{{ $result->word_count }}</td>
                    <td>{{ isset($result->article->article)? str_word_count(strip_tags(str_replace("&nbsp;","",$result->article->article))) : 0 }}</td>
                    <td>{{ $result->writer->ppw }}</td>
                    <td>{{ $inr }}</td>
                    <td>
                      @if($result->status == 0)
                      <span class="badge bg-label-warning me-1">Pending</span>
                      @elseif($result->status == 1)
                       <span class="badge bg-label-success me-1">Accept</span>
                       @elseif($result->status == 2)
                        <span class="badge bg-label-danger me-1">Reject</span>
                        @elseif($result->status == 3)
                        <span class="badge bg-label-success me-1">Approve</span>
                        @elseif($result->status == 4)
                        <span class="badge bg-label-warning me-1">Need corretion</span>
                        @elseif($result->status == 5)
                        <span class="badge bg-label-warning me-1">Reject</span>
                      @endif
                      {{--
                      @if(Auth()->user()->hasRole('admin'))
                        {!! Form::select('status', ['0' => 'Pending', '1' => 'Accept', '2' => 'Cancel', '3' => 'Approve', '4' => 'Need corretion',  '5' => 'Reject'],$result->status, array('data-id' => $result->id, 'class' => 'selectpicker chnageStatus', 'data-live-search'=>"true")) !!}
                      @endif --}}
                    </td>
                    <td>{{ date('Y-m-d', strtotime($result->created_at)) }}</td>
                    <td>
                    <div class="d-flex align-items-center">
                        <a  href="{{ route('articles.view',$result->id) }}" data-bs-toggle="tooltip" class="text-body" data-bs-placement="top" title="" data-bs-original-title="View" aria-label="View">
                          <i class="bx bx-show mx-1"></i>
                        </a>                        
                    </div>
                    </td>
                </tr>
            @endforeach
            @else
              <tr >
                <td colspan="5" style="text-align:center"><span > No Record found </span></td>
              </tr>
            @endif

        </tbody>
      </table>
    </div>
    <div class="row mx-2">
      {!! $results->withQueryString()->links('pagination::bootstrap-5') !!}
    </div>
  </div>
    
  <!--/ Basic Bootstrap Table -->
@endsection
@section('script')
@endsection
