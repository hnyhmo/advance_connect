@extends('layouts.dashboard')

@section('content')

<div class="main-content">
    <div class="card alert">
        <div class="card-header">
            
        </div>
        <div class="card-body">
            <div class="row m-b-15">
                <div class="col-sm-12 col-md-6">
                    <label>Showing {{($users->currentPage()-1)* $users->perPage()+($users->total() ? 1:0)}} to {{($users->currentPage()-1)*$users->perPage()+count($users)}}  of  {{$users->total()}}  Results</label>
                </div>
                <div class="col-sm-12 col-md-6 text-right">
                    <a href="{{route('user.create')}}" class='btn btn-warning btn-sm'><i class="ti-plus"></i> Add New</a>
                    <a href='#' class='btn btn-default btn-sm btn-outline filter' data-target='#filter-content'><i class="ti-filter"></i> Filter</a>

                    <div class="d-none" id="filter-content">
                        <form>
                            <input type="text" name="title" class="form-control input-rounded m-b-10" placeholder="Name" value="{{request()->title}}">
                            <input type="text" name="url" class="form-control input-rounded m-b-10" placeholder="URL" value="{{request()->url}}">
                            <select name='status' class="form-control input-rounded m-b-10">
                                @php $stat = (!is_null(request()->status))?request()->status:null; @endphp
                                <option value=''>Status</option>
                                <option value="1" {{($stat == 1 && !is_null(request()->status))?'selected':''}}>Pulished</option>
                                <option value="0" {{($stat == 0 &&!is_null(request()->status))?'selected':''}}>Unpulished</option>
                            </select>
                        </form>
                    </div>
                </div>
            </div>
            <table class="table table-responsive  table-bordered  table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th class='text-center'>Status</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $k => $w)
                        <tr>
                            <th scope="row">{{$users->firstItem() + $k}}</th>
                            <td>{{$w->name}}</td>
                            <td>{{$w->email}}</td>
                            <td class='text-center'>
                                @if($w->status == 0)
                                    <span class="badge badge-danger ticker-option" data-id="{{$w->id}}" data-val="1" data-table="users" data-type="status">Inactive</span>
                                @else
                                    <span class="badge badge-success ticker-option" data-id="{{$w->id}}" data-val="0" data-table="users" data-type="status">Active</span>
                                @endif
                            </td>
                            <td class="options">
                                <a href="{{ route('user.edit', ['user' => $w->id]) }}"><span class="ti-pencil-alt color-primary"></span></a>
                                <a href='#' data-url="{{ route('user.destroy', ['user' => $w->id]) }}" class='delete'><span class="ti-trash color-danger"></span></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="clearfix">
                <div class="pagination pull-right">
                    {!! $users->links() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
