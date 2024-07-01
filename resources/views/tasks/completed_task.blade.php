@extends('layouts.adminApp')
@section('content')
  <!-- Basic Bootstrap Table -->
  <div class="card">
    <h5 class="card-header">{{$title}}</h5>
    <x-task-filter :writerList="$writerList" :sendUrl="$resetUrl=url('tasks/complete-tasks')" :buyerList="$buyerList" />
    <div class="table-responsive text-nowrap">
      <table class="table">
        <thead>
          <tr>
            <th>Sr.</th>
            @if(Auth()->user()->hasRole(['admin', 'Writer']))
            <th>Created By</th>
            @endif
            @if(Auth()->user()->hasRole(['admin', 'Buyer']))
            <th>Assi. Writer</th>
            @endif
            <th>Title</th>
            <th>WC</th>
            <th>WW</th>
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
                $ppw  =  isset($result->writer->ppw) ? $result->writer->ppw: 0;
                $inr  =  isset($result->writer->ppw)  ? $result->writer->ppw * $writtenword :0;
               ?>
                <tr>
                    <td>{{$sl++}}</td>
                    @if(Auth()->user()->hasRole(['admin', 'Writer']))
                    <td>{{ isset($result->user->user_name) ? strtoupper($result->user->user_name) :''}}</td>
                    @endif
                    @if(Auth()->user()->hasRole('admin') || Auth()->user()->hasRole('Buyer'))
                    <td>{{ isset($result->writer->name) ? strtoupper($result->writer->name) :'' }}</td>
                    @endif
                    <td>  <a  href="{{ route('articles.view',$result->id) }}" > {!! \Illuminate\Support\Str::limit($result->title, 50,'....')  !!} </a></td>
                    <td>{{ $result->word_count }}</td>
                    <td>{{ isset($result->article->article)? str_word_count(strip_tags(str_replace("&nbsp;","",$result->article->article))) : 0 }}</td>
                    <td>{{ $result->writer->ppw ?? '' }}</td>
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
                    {{--
                    <td>
                      <div class="d-flex align-items-center">
                          <a  href="{{ route('articles.view',$result->id) }}" data-bs-toggle="tooltip" class="text-body" data-bs-placement="top" title="" data-bs-original-title="View" aria-label="View">
                            <i class="bx bx-show mx-1"></i>
                          </a>                        
                      </div>
                    </td> --}}
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
