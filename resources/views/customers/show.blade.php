@extends('layouts.adminApp')
@section('content')
            <div class="card">
                <div class="card-header">View
                    <span class="float-right">
                        <a class="btn btn-primary" href="{{ route('customer.index') }}"> Customer List</a>
                    </span>
                </div>
                <div class="card-body">
                        <div class="lead">
                            <strong>Name:</strong>
                            {{ $user->name }}
                        </div>
                        <div class="lead">
                            <strong>Email:</strong>
                            {{ $user->email }}
                        </div>
                        <div class="lead">
                            <strong>User Name:</strong>
                            {{ $user->user_name }}
                        </div>
                        <div class="lead">
                            <strong>Operator Email:</strong>
                            {{ $user->operator_email }}
                        </div>
                        <div class="lead">
                            <strong>Phone:</strong>
                            {{ $user->phone }}
                        </div>
                        <div class="lead">
                            <strong>Company number:</strong>
                            {{ $user->company_number }}
                        </div>
                        <div class="lead">
                            <strong>Website:</strong>
                            {{ $user->website }}
                        </div>

                        <div class="lead">
                            <strong>Created At:</strong>
                            {{ date('Y-m-d', strtotime($user->created_at)) }}
                        </div>
                    </div>
            </div>
            <!-- Basic Bootstrap Table -->
            <div class="card mt-3">
                <h5 class="card-header">Order List</h5>
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            @if(auth()->user()->hasRole('admin'))
                                <th>Customer Name</th>
                            @endif
                            <th>Plan Name</th>
                            <th>No. of Licences</th>
                            <th>Total Amount</th>
                            <th>Payment Mode</th>
                            <th>Payment Status</th>
                            <th>Order Status</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                        @if($orders->count() > 0)
                            @php($sl = ($orders->perPage() * $orders->currentPage()) - ($orders->perPage() - 1))
                            @foreach ($orders as $key => $order)

                                <tr>
                                    <td>{{$sl++}}</td>
                                    @if(auth()->user()->hasRole('admin'))
                                        <td>{{ $order->customer->name }}</td>
                                    @endif
                                    <td>@if(isset($order->plan))
                                            {{ $order->plan->plan_name }} ${{ $order->plan->amount }}/
                                            @if($order->plan_type == 'yearly')
                                                Year
                                            @elseif($order->plan_type == 'monthly')
                                                Month
                                            @endif
                                        @endif
                                    </td>
                                    <td>{{ $order->number_of_license }}</td>
                                    <td>${{ number_format($order->payment_amount,2) }}</td>
                                    <td>
                                        @if($order->payment_mode == 1)
                                            <span class="badge bg-label-success me-1"> Cash </span>
                                        @elseif($order->payment_mode == 0)
                                            <span class="badge bg-label-warning me-1">Pending</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($order->is_payment == 1)
                                            <span class="badge bg-label-success me-1"> Paid </span>
                                        @elseif($order->is_payment == 0)
                                            <span class="badge bg-label-warning me-1">Pending</span>
                                        @elseif($order->is_payment == 2)
                                            <span class="badge bg-label-danger me-1">Cancel</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($order->is_active == 1)
                                            <span class="badge bg-label-success me-1"> Active </span>
                                        @elseif($order->is_active == 0)
                                            <span class="badge bg-label-warning me-1">Inactive</span>
                                        @endif
                                    </td>
                                    <td>{{ date('Y-m-d', strtotime($order->created_at)) }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">

                                            <a  href="{{ route('license.show',$order->id) }}" data-bs-toggle="tooltip" class="text-body" data-bs-placement="top" title="" data-bs-original-title="View" aria-label="View">
                                                <i class="bx bx-show mx-1"></i></a>
                                            @if(auth()->user()->hasRole('admin'))
                                                @if($order->is_active == 1)
                                                    <a class="text-body" data-bs-placement="top" title="Inactive" data-bs-toggle="tooltip"  href="{{ route('license.orderStatus',[$order->id,0]) }}"
                                                    ><i class='bx bxs-adjust-alt me-1'></i></a
                                                    >
                                                @elseif($order->is_active == 0)
                                                    <a class="text-body" data-bs-placement="top" title="Unpaid" data-bs-toggle="tooltip" href="{{ route('license.orderStatus',[$order->id,1]) }}"
                                                    ><i class='bx bx-check-circle me-1'></i></a
                                                    >
                                                @endif
                                                @if($order->is_payment == 1)
                                                    <a class="text-body" data-bs-placement="top" title="Unpaid" data-bs-toggle="tooltip"  href="{{ route('license.payementStatus',[$order->id,0]) }}"
                                                    ><i class='bx bxs-adjust-alt me-1'></i></a
                                                    >
                                                @elseif($order->is_payment == 0)
                                                    <a class="text-body" data-bs-placement="top" title="Paid" data-bs-toggle="tooltip" href="{{ route('license.payementStatus',[$order->id,1]) }}"
                                                    ><i class='bx bx-check-circle me-1'></i></a
                                                    >
                                                @endif
                                                <div class="dropdown">
                                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                        <i class="bx bx-dots-vertical-rounded"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item delete-item" onclick="deleteItem('{{$order->id}}','{{ url("/license/".$order->id) }}')"  href="javascript:void(0)"><i class="bx bx-trash me-1"></i> Delete</a>
                                                    </div>
                                                </div>
                                            @endif
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
                    {!! $orders->withQueryString()->links('pagination::bootstrap-5') !!}
                </div>
            </div>
            <!--/ Basic Bootstrap Table -->
@endsection
