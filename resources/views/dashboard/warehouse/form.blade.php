@extends('layouts.dashboard')

@section('content')

<div class="main-content">
    <div class="card alert">
        <div class="card-header">
            <ul class="nav nav-tabs">
                <li class="nav-item active">
                    <a class="nav-link" data-toggle="tab" href="#general">General</a>
                </li>
            </ul>
            <div class="clearfix header-buttons text-right m-t-20">
                <a href="{{route('item.index')}}" class="btn btn-default btn-sm btn-outline"><i class="ti-close"></i> Cancel</a>
                <a href="#" class="btn btn-primary btn-sm {{isset($d)?'update':'save'}}-form" data-callback="{{ route('item.index') }}" data-status="1"  data-target="#main-form"><i class="ti-save"></i> Save</a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="card alert">
                    <div class="card-body">
                        <form id='main-form' data-url="{{ isset($d)?route('item.update', ['item' => $d->id]):route('item.store') }}">
                            @if(isset($d))    
                                @method('PUT')
                            @endif
                            <input type="hidden" value="0" name="status" />
                            <div class="tab-content m-t-20">

                                <!-- GENERAL -->
                                <div class="tab-pane container active" id="general">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="card alert">
                                            <div class="card-header">
                                                <h4></h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="basic-form">
                                                    <div class="form-group">
                                                        <input type="text" name="name" class="form-control" value="{{ isset($d)?$d->name:''}}" placeholder="Item Name" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <textarea name="address" class="form-control" placeholder="Address">{{ isset($d)?$d->address:''}}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
  
                            </div>
                            
                        </form>
                    </div>
                </div>
                
            </div>
            
        </div>
    </div>
@endsection
