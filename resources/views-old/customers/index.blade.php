@extends('layouts.adminApp')
@section('content')
  <!-- Basic Bootstrap Table -->
  <div class="card">
    <h5 class="card-header">Customers List</h5>
    <div class="table-responsive text-nowrap">
      <table class="table">
        <thead>
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Created At</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
            @if($customers->count() > 0)
            @php($sl = ($customers->perPage() * $customers->currentPage()) - ($customers->perPage() - 1))
            @foreach ($customers as $key => $customer)
                <tr>
                    <td>{{$sl++}}</td>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ date('Y-m-d', strtotime($customer->created_at)) }}</td>
                    <td>
                    <div class="d-flex align-items-center">
                        <a  href="{{ route('customer.show',$customer->id) }}" data-bs-toggle="tooltip" class="text-body" data-bs-placement="top" title="" data-bs-original-title="View" aria-label="View">
                          <i class="bx bx-show mx-1"></i>
                        </a>
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                            <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('customer.edit',$customer->id) }}"
                                ><i class="bx bx-edit-alt me-1"></i> Edit</a
                            >
                            <a class="dropdown-item delete-item" onclick="deleteItem('{{$customer->id}}','{{ url("/customer/".$customer->id) }}')"  href="javascript:void(0)"><i class="bx bx-trash me-1"></i> Delete</a>
                            </div>
                        </div>
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
      {!! $customers->withQueryString()->links('pagination::bootstrap-5') !!}
    </div>
  </div>
  <!--/ Basic Bootstrap Table -->
@endsection

