@extends('layouts.dashboard')

@section('content')

<div class="main-content">
    <div class="card alert">
        <div class="card-header">
            
        </div>
        <div class="card-body">
            <div class="row m-b-15">
                <div class="col-sm-12 col-md-6">
                    <label>Showing {{($websites->currentPage()-1)* $websites->perPage()+($websites->total() ? 1:0)}} to {{($websites->currentPage()-1)*$websites->perPage()+count($websites)}}  of  {{$websites->total()}}  Results</label>
                </div>
                <div class="col-sm-12 col-md-6 text-right">
                    @if(permissionShow(8, "Add"))
                        <a href="{{route('website.create')}}" class='btn btn-warning btn-sm'><i class="ti-plus"></i> Add New</a>
                    @endif
                    
                    @if(permissionShow(8, "Export"))
                        <a href="{{route('export')}}?table=websites&{{http_build_query(request()->all())}}" class='btn btn-primary btn-sm'><i class="ti-download"></i> Export</a>
                    @endif
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
                        <th>URL</th>
                        <th class='text-center'>Status</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($websites as $k => $w)
                        <tr>
                            <th scope="row">{{$websites->firstItem() + $k}}</th>
                            <td>{{$w->title}}</td>
                            <td>{{$w->url}}</td>
                            <td class='text-center'>
                                @if($w->status == 0)
                                    <span class="badge badge-danger ticker-option" data-id="{{$w->id}}" data-val="1" data-table="websites" data-type="status">Unpublished</span>
                                @else
                                    <span class="badge badge-success ticker-option" data-id="{{$w->id}}" data-val="0" data-table="websites" data-type="status">Published</span>
                                @endif
                            </td>
                            <td class="options">
                                <a href="{{ route('website.edit', ['website' => $w->id]) }}"><span class="ti-pencil-alt color-primary"></span></a>
                                <a href='#' data-url="{{ route('website.destroy', ['website' => $w->id]) }}" class='delete'><span class="ti-trash color-danger"></span></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="clearfix">
                <div class="pagination pull-right">
                    {!! $websites->links() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
