@extends('layouts.adminApp')
@section('content')
  <!-- Basic Bootstrap Table -->
  <div class="card">
    <h5 class="card-header">{{$title}}</h5>
  
    <div class="table-responsive text-nowrap">
      <table class="table">
        <thead>
          <tr>
            <th>Sr.</th>
            @if(Auth()->user()->hasRole('admin'))
            <th>Created By</th>
            @endif
            @if(Auth()->user()->hasRole(['admin', 'Buyer']))
            <th>Assigned Writer</th>
            @endif
            <th>Title</th>
            <th>WC</th>
            <th>WW</th>
            <th>Status</th>
            <th>Created At</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
            @if($results->count() > 0)
            @php($sl = ($results->perPage() * $results->currentPage()) - ($results->perPage() - 1))
            @foreach ($results as $key => $result)
                <tr>
                    <td>{{$sl++}}</td>
                    @if(Auth()->user()->hasRole(['admin']))
                    <td>{{ isset($result->user->user_name) ?  strtoupper($result->user->user_name) :''}}</td>
                    @endif
                    @if(Auth()->user()->hasRole('admin') || Auth()->user()->hasRole('Buyer'))
                    <td>{{ isset($result->writer->name) ? strtoupper($result->writer->name) :'' }}</td>
                    @endif
                    <td> <a  href="{{ route('articles.view',$result->id) }}" > {!! \Illuminate\Support\Str::limit($result->title, 50,'....')  !!} </a></td>
                    <td>{{ $result->word_count }}</td>
                    <td>{{ isset($result->article->article)? str_word_count(strip_tags(str_replace("&nbsp;","",$result->article->article))) : 0 }}</td>
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
                      {{--
                    <div class="d-flex align-items-center">
                         <a  href="{{ route('article.create',$result->id) }}" class="btn btn-sm btn-primary">Edit Article</a>
                        @if(auth()->user()->hasRole(['admin', 'Buyer']))
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                            <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('tasks.edit',$result->id) }}"
                                ><i class="bx bx-edit-alt me-1"></i> Edit</a
                            >
                            <a class="dropdown-item delete-item" onclick="deleteItem('{{$result->id}}','{{ url("/customer/".$result->id) }}')"  href="javascript:void(0)"><i class="bx bx-trash me-1"></i> Delete</a>
                            </div>
                        </div>
                        @endif
                    </div> --}}
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
    <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalCenterTitle">Comment</h5>
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
              
                  <input type="hidden" name="taskId" value="" id="taskId">
                 <!-- <label for="nameWithTitle" class="form-label">Name</label> -->
                 <textarea name="comment" id="" cols="30" rows="10"></textarea>
                
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
          {!! Form::close() !!}
        </div>
      </div>
    </div>
  <!--/ Basic Bootstrap Table -->
@endsection
@section('script')
<script>
  $('.chnageStatus').change(function(){
     var id     =     $(this).data('id');
     var status =     $(this).val();
     $('#taskId').val(id);
    var siteurl = '{{ route('tasks.status',['','']) }}/'+id+'/'+status;
    var message = '';
    $('#modalCenter').modal('hide');
    if(status == 4){
      $('#modalCenter').modal('show');
    }else{
      swal({
          title: 'Are you sure?',
          text: "You won't be able to approve this!",
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
    
  });
</script>
@endsection
