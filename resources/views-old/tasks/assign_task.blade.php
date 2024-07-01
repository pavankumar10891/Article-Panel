@extends('layouts.adminApp')
@section('content')
  <!-- Basic Bootstrap Table -->
  <div class="card">
    <h5 class="card-header">{{$title}}</h5>
  
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
            <th>Status</th>
            <th>Created At</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
            @if($results->count() > 0)
            @php($sl = ($results->perPage() * $results->currentPage()) - ($results->perPage() - 1))
            @foreach ($results as $key => $result)
                <tr>
                    <td>{{$sl++}}</td>
                    @if(Auth()->user()->hasRole('admin'))
                    <td>{{ strtoupper($result->user->user_name)}}</td>
                    @endif
                    @if(Auth()->user()->hasRole('admin') || Auth()->user()->hasRole('Buyer'))
                    <td>{{ isset($result->writer->name) ? strtoupper($result->writer->name) :'' }}</td>
                    @endif
                    <td> {!! \Illuminate\Support\Str::limit($result->title, 10,'....')  !!}</td>
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
                    </td>
                    <td>{{ date('Y-m-d', strtotime($result->created_at)) }}</td>
                    <td>
                    <div class="d-flex align-items-center">
                        <a  href="{{ route('tasks.show',$result->id) }}" data-bs-toggle="tooltip" class="text-body" data-bs-placement="top" title="" data-bs-original-title="View" aria-label="View">
                          <i class="bx bx-show mx-1"></i>
                        </a>
                        @if(($result->status == 1) || ($result->status == 4))
                        <a  href="{{ route('article.create',$result->id) }}" class="btn btn-sm btn-info"> Start Wrting </a>
                        @endif
                        {{--
                        @if($result->status == 0)
                        @if(auth()->user()->hasRole('Writer')) 
                        <a href="javascript:void(0)" onclick="acceptTask('{{ route('tasks.status',[$result->id,1]) }}')" data-bs-toggle="tooltip" class="text-body" data-bs-placement="top" title="" data-bs-original-title="Accept" aria-label="Accept">
                          <i class="bx bx-check-circle mx-1"></i>
                        </a>
                        <a  href="javascript:void(0)" onclick="rejectTask('{{ route('tasks.status',[$result->id,2]) }}')" data-bs-toggle="tooltip" class="text-body" data-bs-placement="top" title="" data-bs-original-title="Reject" aria-label="Reject">
                          <i class="bx bx-block mx-1"></i>
                        </a>
                        @endif
                        @endif --}}
                        @if(auth()->user()->hasRole(['admin', 'Buyer'])) 
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                            <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('tasks.edit',$result->id) }}"
                                ><i class="bx bx-edit-alt me-1"></i> Edit</a>
                            <a class="dropdown-item delete-item" onclick="deleteItem('{{$result->id}}','{{ url("/customer/".$result->id) }}')"  href="javascript:void(0)"><i class="bx bx-trash me-1"></i> Delete</a>
                            </div>
                        </div>
                        @endif
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
<script>
  function acceptTask(siteurl){
    var token = $("meta[name='csrf-token']").attr("content");
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
