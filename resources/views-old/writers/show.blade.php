@extends('layouts.adminApp')
@section('content')
            <div class="card">
                <div class="card-header header-elements">
                    <h5>View Writes</h5>
                    <div class="card-header-elements ms-auto">
                        <a class="btn btn-primary" href="{{ route('writers.index') }}"> Writers List</a>
                    </div>
                </div>
                <div class="card-body">
                        <div class="lead">
                            <strong>User Name:</strong>
                            {{ $model->user_name }}
                        </div>
                        <div class="lead">
                            <strong>Email:</strong>
                            {{ $model->email }}
                        </div>
                        <div class="lead">
                            <strong>Mobile:</strong>
                            {{ $model->mobile }}
                        </div>
                        <div class="lead">
                            <strong>Address:</strong>
                            {{ $model->address }}
                        </div>
                        <div class="lead">
                            <strong>Designation:</strong>
                            {{ $model->designation }}
                        </div>
                        <div class="lead">
                            <strong>PPW:</strong>
                            {{ $model->ppw }}
                        </div>
                        <div class="lead">
                            <strong>Bio:</strong>
                            {{ $model->bio }}
                        </div>
                        <div class="lead">
                            <strong>Expert Niche:</strong>
                            {{ $model->expert_niche }}
                        </div>
                        <div class="lead">
                            <strong>Daily Capecity:</strong>
                            {{ $model->daily_capecity }}
                        </div>
                        <div class="lead">
                            <strong>Experience:</strong>
                            {{ $model->experience }}
                        </div>
                        <div class="lead">
                            <strong>Created At:</strong>
                            {{ date('Y-m-d', strtotime($model->created_at)) }}
                        </div>
                    </div>
            </div>

            <!-- Basic Bootstrap Table -->
            <div class="card">
                <h5 class="card-header">Task List</h5>
                <div class="card-body"> 
                {!! Form::open(array('route' => 'tasks.assignTaskStore','method'=>'POST')) !!}
                <div class="table-responsive text-nowrap">
                
                    <table class="table">
                        <thead>
                        <tr>
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
                             <input type="hidden" name="user" value="{{ $model->id }}">
                            @if($results->count() > 0)
                            @php $sl = 1 @endphp
                            @foreach ($results as $key => $result)
                                <tr>
                                    <td><input type="checkbox" name="task[]" value="{{ $result->id }}"> {{$sl++}}</td>
                                    @if(Auth()->user()->hasRole('admin'))
                                    <td>{{ strtoupper($result->user->user_name)}}</td>
                                    @endif
                                    <td>{{ $result->title }}</td>
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
                    <div class="row mx-2">
                        {!! $results->withQueryString()->links('pagination::bootstrap-5') !!}
                    </div>
                </div>
            
                <button type="submit" class="btn btn-primary">Submit</button>
                {!! Form::close() !!}
                </div>
            </div>
            
            <!--/ Basic Bootstrap Table -->
@endsection
