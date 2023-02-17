@extends('layouts.dashboard')

@section('content')

<div class="main-content">
    <div class="card alert">
        <div class="card-header">
            
        </div>
        <div class="card-body">
            <div class="row m-b-15">
                <div class="col-sm-12 col-md-6">
                    <label>Showing {{($products->currentPage()-1)* $products->perPage()+($products->total() ? 1:0)}} to {{($products->currentPage()-1)*$products->perPage()+count($products)}}  of  {{$products->total()}}  Results</label>
                </div>
                <div class="col-sm-12 col-md-6 text-right">
                    <a href="{{route('product.create')}}" class='btn btn-primary btn-sm'><i class="ti-plus"></i> Add New</a>
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
                        <th>Product Name</th>
                        <th>Type</th>
                        <th>Date</th>
                        <th>Featured</th>
                        <th>Status</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $k => $w)
                        <tr>
                            <th scope="row">{{$products->firstItem() + $k}}</th>
                            <td><a href="{{ route('product.edit', ['product' => $w->id]) }}" title="Edit Item">{{$w->name}}</a></td>
                            <td>{{ucfirst($w->type)}}</td>
                            <td>{{$w->date}}</td>
                            <td class='text-center'>
                                @if($w->featured == 0)
                                    <span class="badge badge-default ticker-option" data-id="{{$w->id}}" data-val="1" data-table="product" data-type="featured">No</span>
                                @else
                                    <span class="badge badge-success ticker-option" data-id="{{$w->id}}" data-val="0" data-table="product" data-type="featured">Yes</span>
                                @endif
                            </td>
                            <td class='text-center'>
                                @if($w->publish == 0)
                                    <span class="badge badge-danger ticker-option" data-id="{{$w->id}}" data-val="1" data-table="product" data-type="publish">Inactive</span>
                                @else
                                    <span class="badge badge-success ticker-option" data-id="{{$w->id}}" data-val="0" data-table="product" data-type="publish">Active</span>
                                @endif
                            </td>
                            <td class="options">
                                <a href="{{ route('product.edit', ['product' => $w->id]) }}" title="Edit Item"><span class="ti-pencil-alt color-primary"></span></a>
                                <a href='#' data-url="{{ route('product.destroy', ['product' => $w->id]) }}" title="Delete Product" class='delete'><span class="ti-trash color-danger"></span></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="clearfix">
                <div class="pagination pull-right">
                    {!! $products->links() !!}
                </div>
            </div>
        </div>
    </div>
    
@endsection
