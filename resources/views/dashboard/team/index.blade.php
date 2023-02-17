@extends('layouts.dashboard')

@section('content')

<div class="main-content">
    <div class="card alert">
        <div class="card-header">
            
        </div>
        <div class="card-body">
            <div class="row m-b-15">
                <div class="col-sm-12 col-md-6">
                    <label>Showing {{($team->currentPage()-1)* $team->perPage()+($team->total() ? 1:0)}} to {{($team->currentPage()-1)*$team->perPage()+count($team)}}  of  {{$team->total()}}  Results</label>
                </div>
                <div class="col-sm-12 col-md-6 text-right">
                    <a href="{{route('team.create')}}" class='btn btn-primary btn-sm'><i class="ti-plus"></i> Add New</a>
                    <a href='#' class='btn btn-default btn-sm btn-outline filter' data-target='#filter-content'><i class="ti-filter"></i> Filter</a>

                    <div class="d-none" id="filter-content">
                        <form>
                            <input type="text" name="name" class="form-control input-rounded m-b-10" placeholder="Item Name" value="{{request()->name}}">
                            <input type="text" name="date" class="form-control input-rounded m-b-10" placeholder="Date" value="{{request()->date}}">
                        </form>
                    </div>
                </div>
            </div>
            <table class="table table-responsive  table-bordered  table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($team as $k => $w)
                        <tr>
                            <th scope="row">{{$team->firstItem() + $k}}</th>
                            <td><a href="{{ route('team.edit', ['team' => $w->id]) }}" title="Edit Item">{{$w->name}}</a></td>
                            <td>{{$w->date}}</td>
                            <td class='text-center'>
                                @if($w->publish == 0)
                                    <span class="badge badge-danger ticker-option" data-id="{{$w->id}}" data-val="1" data-table="team" data-type="publish">Inactive</span>
                                @else
                                    <span class="badge badge-success ticker-option" data-id="{{$w->id}}" data-val="0" data-table="team" data-type="publish">Active</span>
                                @endif
                            </td>
                            <td class="options">
                                <a href="{{ route('team.edit', ['team' => $w->id]) }}" title="Edit Item"><span class="ti-pencil-alt color-primary"></span></a>
                                <a href='#' data-url="{{ route('team.destroy', ['team' => $w->id]) }}" title="Delete team" class='delete'><span class="ti-trash color-danger"></span></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="clearfix">
                <div class="pagination pull-right">
                    {!! $team->links() !!}
                </div>
            </div>
        </div>
    </div>
    
@endsection
