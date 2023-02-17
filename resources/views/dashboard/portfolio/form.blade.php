@extends('layouts.dashboard')

@section('content')

<div class="main-content">
    <div class="card alert">
        <div class="card-header">
            <ul class="nav nav-tabs">
                <li class="nav-item active">
                    <a class="nav-link" data-toggle="tab" href="#general">General</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#seo">SEO</a>
                </li>
            </ul>
            <div class="clearfix header-buttons text-right m-t-20">
                <a href="{{route('portfolio.index')}}" class="btn btn-default btn-sm btn-outline"><i class="ti-close"></i> Cancel</a>
                <a href="#" class="btn btn-primary btn-sm {{isset($d)?'update':'save'}}-form" data-callback="{{ route('portfolio.index') }}" data-status="1"  data-target="#main-form"><i class="ti-save"></i> Save</a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="card alert">
                    <div class="card-body">
                        <form id='main-form' data-url="{{ isset($d)?route('portfolio.update', ['portfolio' => $d->id]):route('portfolio.store') }}">
                            @if(isset($d))    
                                @method('PUT')
                            @endif
                            <input type="hidden" value="0" name="status" />
                            <div class="tab-content m-t-20">

                                <!-- GENERAL -->
                                <div class="tab-pane container active" id="general">
                                    <div class="col-lg-3 col-md-3 col-sm-12">
                                        <div class="card alert">
                                            <div class="card-header">
                                                <h4></h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="basic-form">
                                                    <div class="form-group">
                                                        <label>Portfolio Name</label>
                                                        <input type="text" name="name" class="form-control" value="{{ isset($d)?$d->name:''}}" placeholder="Portfolio Name" required>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label>Date</label>
                                                        <input type="date" name="date" class="form-control" value="{{ isset($d)?$d->date:date('Y-m-d')}}" placeholder="Date" required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label><input type="checkbox" name="publish" value="1" {{ ($d->publish ?? 0) == 1?'checked':'' }}> Publish</label>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label><input type="checkbox" name="featured" value="1" {{ ($d->featured ?? 0) == 1?'checked':'' }}> Featured</label>
                                                    </div>
                                                    
                                                    <div class="basic-form">
                                                        <div class="form-group parent">
                                                            <label>Upload Photo<label>
                                                            <input type="hidden" name="existing_file" value="{{!empty($d->photo)?$d->photo:''}}" />
                                                            <input type='file' onchange="selectImage(this, window.URL.createObjectURL(this.files[0]))"  name='photo' class='form-control input-sm m-b-30' accept="image/*" />
                                                            <img src="{{!empty($d->photo)?'/storage/images/'.$d->photo:'/img/default.png'}}" class="img-responsive"/>
                                                        </div>
                                                    </div>
                                                    <div class="basic-form">
                                                        <div class="form-group parent">
                                                            <label>Upload Banner<label>
                                                            <input type="hidden" name="existing_file" value="{{!empty($d->banner_photo)?$d->banner_photo:''}}" />
                                                            <input type='file' onchange="selectImage(this, window.URL.createObjectURL(this.files[0]))"  name='banner_photo' class='form-control input-sm m-b-30' accept="image/*" />
                                                            <img src="{{!empty($d->banner_photo)?'/storage/images/'.$d->banner_photo:'/img/default.png'}}" class="img-responsive"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-9 col-md-9 col-sm-12">
                                        <div class="card alert">
                                            <div class="card-header">
                                                <h4></h4>
                                            </div>
                                            <div class="card-body">
                                            
                                                <div class="form-group">
                                                    <label>Teaser Text</label>
                                                    <textarea name="teaser" class="form-control" placeholder="Type here...">{!! isset($d)?$d->teaser:'' !!}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label>Content</label>
                                                    <textarea name="content" data-height="300" class="form-control editor" placeholder="Type here...">{!! isset($d)?$d->content:'' !!}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    

                                </div>
  
                                <!-- SEO -->
                                <div class="tab-pane container" id="seo">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="card alert">
                                            <div class="card-header">
                                                <h4></h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="basic-form">
                                                    <div class="form-group">
                                                        <label>Meta Title</label>
                                                        <input type="text" name="meta_title" class="form-control" value="{{ isset($d)?$d->meta_title:''}}" placeholder="">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Meta Description</label>
                                                        <textarea name="meta_description" class="form-control" placeholder="Type here...">{!! isset($d)?$d->meta_description:'' !!}</textarea>
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
