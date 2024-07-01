@extends('layouts.adminApp')
@section('content')
    <div class="card">
        <h5 class="card-header">Users</h5>
        <div class="table-responsive text-nowrap mb-3">
            <table class="table">
                <thead> 
                    
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>UserName</th>
                    <th>Email</th>
                    <th>Roles</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @if($data->count() > 0)    
                @php($sl = ($data->perPage() * $data->currentPage()) - ($data->perPage() - 1))   
                @foreach ($data as $key => $user)
                    <tr>
                        <td>{{$sl++}}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->user_name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if(!empty($user->getRoleNames()))
                                @foreach($user->getRoleNames() as $val)
                                    <span class="badge bg-label-info me-1">{{ $val }}</span>
                                @endforeach
                            @endif
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <a  href="{{ route('users.show',$user->id) }}" data-bs-toggle="tooltip" class="text-body" data-bs-placement="top" title="" data-bs-original-title="View" aria-label="View">
                                    <i class="bx bx-show mx-1"></i>
                                </a>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                    @can('user-edit')
                                    <a class="dropdown-item" href="{{ route('users.edit',$user->id) }}"
                                        ><i class="bx bx-edit-alt me-1"></i> Edit</a>
                                    @endcan
                                    @can('user-delete')
                                        @if(!$user->hasRole('admin'))
                                        <a class="dropdown-item delete-item" onclick="deleteItem('{{$user->id}}','{{ url("/users/".$user->id) }}')"  href="javascript:void(0)"><i class="bx bx-trash me-1"></i> Delete</a>
                                        @endif
                                    @endcan
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
            {!! $data->withQueryString()->links('pagination::bootstrap-5') !!}
        </div>
    </div>
@endsection
