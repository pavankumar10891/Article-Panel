@extends('layouts.adminApp')
@section('content')
  <!-- Basic Bootstrap Table -->
  <div class="card">
    <h5 class="card-header">Writers List</h5>
    <div class="table-responsive text-nowrap">
      <table class="table">
        <thead>
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>PPW</th>
            <th>Daily capacity</th>
            <th>Niches</th>
            <th>Pending task</th>
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
                    <td>{{ $result->name }}</td>
                    <td>{{ $result->ppw }}</td>
                    <td>{{ $result->daily_capecity }}</td>
                    <td>{{ $result->expert_niche }}</td>
                    <td>{{ $result->writer_task_count }}</td>
                    <td>{{ date('Y-m-d', strtotime($result->created_at)) }}</td>
                    <td>
                    <div class="d-flex align-items-center">
                        <a  href="{{ route('writers.edit',$result->id) }}" data-bs-toggle="tooltip" class="text-body" data-bs-placement="top" title="" data-bs-original-title="Edit" aria-label="Edit">
                          <i class="bx bx-edit mx-1"></i>
                        </a>
                        <a  href="{{ route('writers.show',$result->id) }}" data-bs-toggle="tooltip" class="text-body" data-bs-placement="top" title="" data-bs-original-title="Assign Task" aria-label="Assign Task">
                          Assign Task
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

