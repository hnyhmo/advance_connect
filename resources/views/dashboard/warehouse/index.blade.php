@extends('layouts.dashboard')

@section('content')

<div class="main-content">
    <div class="card alert">
        <div class="card-header">
            
        </div>
        <div class="card-body">
            <div class="row m-b-15">
                <div class="col-sm-12 col-md-6">
                    <label>Showing {{($warehouse->currentPage()-1)* $warehouse->perPage()+($warehouse->total() ? 1:0)}} to {{($warehouse->currentPage()-1)*$warehouse->perPage()+count($warehouse)}}  of  {{$warehouse->total()}}  Results</label>
                </div>
                <div class="col-sm-12 col-md-6 text-right">
                    <a href="{{route('warehouse.create')}}" class='btn btn-warning btn-sm'><i class="ti-plus"></i> Add New</a>
                    <a href="{{route('export')}}?table=item&{{http_build_query(request()->all())}}" class='btn btn-primary btn-sm'><i class="ti-download"></i> Export</a>
                    <a href='#' class='btn btn-default btn-sm btn-outline filter' data-target='#filter-content'><i class="ti-filter"></i> Filter</a>

                    <div class="d-none" id="filter-content">
                        <form>
                            <input type="text" name="name" class="form-control input-rounded m-b-10" placeholder="Item Name" value="{{request()->name}}">
                            <input type="text" name="address" class="form-control input-rounded m-b-10" placeholder="Address" value="{{request()->address}}">
                        </form>
                    </div>
                </div>
            </div>
            <table class="table table-responsive  table-bordered  table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Warehouse Name</th>
                        <th>Address</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($warehouse as $k => $w)
                        <tr>
                            <th scope="row">{{$warehouse->firstItem() + $k}}</th>
                            <td>{{$w->name}}</td>
                            <td>{{$w->address}}</td>
                            <td class="options">
                                <a href="{{ route('warehouse.edit', ['warehouse' => $w->id]) }}" title="Edit Item"><span class="ti-pencil-alt color-primary"></span></a>
                                <a href='#' data-url="{{ route('warehouse.destroy', ['warehouse' => $w->id]) }}" title="Delete Item" class='delete'><span class="ti-trash color-danger"></span></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="clearfix">
                <div class="pagination pull-right">
                    {!! $warehouse->links() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
