@extends('layouts.adminApp')
@section('content')
  <!-- Basic Bootstrap Table -->
  <div class="card">
    <h5 class="card-header">{{$title}}</h5>
    
    <div class="table-responsive text-nowrap">
      <table class="table">
        <thead>
          <tr>
            <td></td>
            <th>#</th>
            @if(Auth()->user()->hasRole('admin'))
            <th>Created By</th>
            @endif
            <th>Title</th>
            <th>Word Count</th>
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
                   <td> <input type="checkbox" name="" id=""> </td>
                    <td>{{$sl++}}</td>
                    @if(Auth()->user()->hasRole('admin'))
                    <td>{{ strtoupper($result->user->user_name)}}</td>
                    @endif
                    <td> {!! \Illuminate\Support\Str::limit($result->title, 10,'....')  !!}</td>
                    <td>{{ $result->word_count }}</td>
                    <td>
                      @if($result->status == 0)
                      <span class="badge bg-label-warning me-1">Pending</span>
                      @elseif($result->status == 1)
                       <span class="badge bg-label-success me-1">Active</span>
                       @elseif($result->status == 2)
                        <span class="badge bg-label-danger me-1">Inactive</span>
                      @endif
                    </td>
                    <td>{{ date('Y-m-d', strtotime($result->created_at)) }}</td>
                    <td>
                    <div class="d-flex align-items-center">
                        <a  href="{{ route('tasks.show',$result->id) }}" data-bs-toggle="tooltip" class="text-body" data-bs-placement="top" title="" data-bs-original-title="View" aria-label="View">
                          <i class="bx bx-show mx-1"></i>
                        </a>
                        @if(auth()->user()->hasRole('admin')) 
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

