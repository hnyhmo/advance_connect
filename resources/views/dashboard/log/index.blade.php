@extends('layouts.dashboard')

@section('content')

<div class="main-content">
    <div class="card alert">
        <div class="card-header">
            
        </div>
        <div class="card-body">
            <div class="row m-b-15">
                <div class="col-sm-12 col-md-6">
                    <label>Showing {{($logs->currentPage()-1)* $logs->perPage()+($logs->total() ? 1:0)}} to {{($logs->currentPage()-1)*$logs->perPage()+count($logs)}}  of  {{$logs->total()}}  Results</label>
                </div>
                <div class="col-sm-12 col-md-6 text-right">
                    <a href="{{route('export')}}?table=logs&{{http_build_query(request()->all())}}" class='btn btn-primary btn-sm'><i class="ti-download"></i> Export</a>
                    <a href='#' class='btn btn-default btn-sm btn-outline filter' data-target='#filter-content'><i class="ti-filter"></i> Filter</a>
                </div>
            </div>

            <div class="d-none" id="filter-content">
                <form>
                    <input type="text" name="type" class="form-control input-rounded m-b-10" placeholder="Type" value="{{request()->type}}">
                    <input type="text" name="action" class="form-control input-rounded m-b-10" placeholder="Action" value="{{request()->action}}">
                    <input type="text" name="item" class="form-control input-rounded m-b-10" placeholder="Item" value="{{request()->item}}">
                    <select name='user_id' class="form-control input-rounded m-b-10">
                        <option value=''>User</option>
                        @foreach($users as $u)
                            <option value="{{$u->id}}" {{(request()->user_id == $u->id)?'selected':''}}>{{$u->name}}</option>
                        @endforeach
                    </select>
                </form>
            </div>
            <table class="table table-responsive  table-bordered  table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Type</th>
                        <th>Action</th>
                        <th>Item</th>
                        <th>User</th>
                        <th>Date & Time</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs as $k => $w)
                        <tr>
                            <th scope="row">{{$logs->firstItem() + $k}}</th>
                            <td>{{$w->type}}</td>
                            <td>{{$w->action}}</td>
                            <td>{{$w->item}}</td>
                            <td>{{$w->user->name}}</td>
                            <td>{{$w->created_at->format("F d, Y h:i a")}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="clearfix">
                <div class="pagination pull-right">
                    {!! $logs->links() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
