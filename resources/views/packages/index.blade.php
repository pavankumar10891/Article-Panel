@extends('layouts.adminApp')
@section('content')

    <!-- Basic Bootstrap Table -->
  <div class="card">
      <h5 class="card-header">Plans</h5>
      <div class="table-responsive text-nowrap">
        <table class="table">
          <thead>
            <tr>
              <th>#</th>
              <th>Plan Type</th>
              <th>Name</th>
              <th>Amount</th>
              <th>Status</th>
              <th>Created At</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody class="table-border-bottom-0">
              @if($packages->count() > 0)
              @php($sl = ($packages->perPage() * $packages->currentPage()) - ($packages->perPage() - 1))    
              @foreach ($packages as $key => $package)
            
                  <tr>
                      <td>{{$sl++}}</td>
                      <td>
                        {{ strtoupper($package->plan_type) }}

                      </td>
                      <td>{{ $package->plan_name }}</td>
                      <td >{{ $package->amount }}</td>
                      <td>
                          @if($package->is_active == 1)
                          <span class="badge bg-label-success me-1"> Active </span>
                          @elseif($package->is_active == 0)
                          <span class="badge bg-label-warning me-1">Inactive</span>
                          @endif
                      </td>
                      <td>{{ date('Y-m-d', strtotime($package->created_at)) }}</td>
                      <td>
                      <div class="d-flex align-items-center">                       
                            @if($package->is_active == 1)    
                              <a class="text-body" data-bs-placement="top" title="Inactive" data-bs-toggle="tooltip"  href="{{ route('plan.changeStatus',[$package->id,0]) }}"
                                  ><i class='bx bxs-adjust-alt me-1'></i></a
                              >
                              @elseif($package->is_active == 0)
                              
                              <a class="text-body" data-bs-placement="top" title="Active" data-bs-toggle="tooltip" href="{{ route('plan.changeStatus',[$package->id,1]) }}"
                                  ><i class='bx bx-check-circle me-1'></i></a
                              >
                              @endif
                              <a class="text-body" data-bs-placement="top" title="Edit" data-bs-toggle="tooltip" href="{{ route('plan.edit',$package->id) }}"
                                    ><i class="bx bx-edit-alt me-1"></i></a
                                >
                                <a class="text-body" data-bs-placement="top" title="Delete" data-bs-toggle="tooltip" onclick="deleteItem('{{$package->id}}','{{ url("/plan/".$package->id) }}')"  href="javascript:void(0)"><i class="bx bx-trash me-1"></i></a>
                      </div>
                      </td>
                  </tr>
              @endforeach
              @else
                <tr >
                  <td colspan="7" style="text-align:center"><span > No Record found </span></td>
                </tr>
              @endif

          </tbody>
        </table>
      </div>
      <div class="row mx-2">
        {!! $packages->withQueryString()->links('pagination::bootstrap-5') !!}
    </div>
  </div>
    <!--/ Basic Bootstrap Table -->
@endsection

