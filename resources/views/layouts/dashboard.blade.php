<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="app-url" content="{{ env('APP_ADMIN_URL') }}" />
    <link rel="icon" href="/img/favicon.png">
    <title>{{ config('app.name', 'BestMac') }}</title>
    
    <link href="{{ asset('theme/fontAwesome/css/fontawesome-all.min.css')}}" rel="stylesheet">
    <link href="{{ asset('theme/css/lib/themify-icons.css')}}" rel="stylesheet">
    <link href="{{ asset('theme/css/lib/mmc-chat.css')}}" rel="stylesheet" />
    <link href="{{ asset('theme/css/lib/sidebar.css')}}" rel="stylesheet">
    <link href="{{ asset('theme/css/lib/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('theme/css/lib/nixon.css')}}" rel="stylesheet">
    <link href="{{ asset('theme/css/lib/toastr/toastr.min.css')}}" rel="stylesheet">
    <link href="{{ asset('theme/css/style.css')}}" rel="stylesheet">
    <link href="{{ asset('summernote/css/summernote-bs4.css')}}" rel="stylesheet">
    <link href="{{ asset('select2/css/select2.min.css')}}" rel="stylesheet">
    <link href="{{ asset('spectrum/spectrum.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('jconfirm/css/jquery-confirm.min.css')}}">
    <link href="{{ asset('custom/css/style.css')}}" rel="stylesheet">
</head>

<body>
    <div class="sidebar sidebar-hide-to-small sidebar-shrink sidebar-gestures">
        <div class="nano">
            <div class="nano-content">
                <ul>
                    <li>
                        <a href="{{route('page.index')}}"><i class="ti-files"></i> Page</a>
                    </li>
                    <li>
                        <a href="{{route('product.index')}}"><i class="ti-layers"></i> Products & Services</a>
                        <!-- <ul>
                            <li><a href="{{route('product.create')}}"> + Add New</a></li>
                            <li><a href="{{route('product.index')}}"> * Show List</a></li>
                        </ul> -->
                    </li>
                    <li>
                        <a href="{{route('news.index')}}"><i class="ti-menu-alt"></i> News & Awards</a>
                    </li>
                    <li>
                        <a href="{{route('portfolio.index')}}"><i class="ti-folder"></i> Portfolio</a>
                    </li>
                    <li>
                        <a href="{{route('team.index')}}"><i class="ti-briefcase"></i> The Team</a>
                    </li>
                    <li>
                        <a href="{{route('brand.index')}}"><i class="ti-gallery"></i> Trusted Brands</a>
                    </li>

                    <li>
                        <a href="{{route('user.index')}}"><i class="ti-user"></i> Users</a>
                        <!-- <ul>
                            <li><a href="{{route('user.create')}}"> + Add New</a></li>
                            <li><a href="{{route('user.index')}}"> * Show List</a></li>
                        </ul> -->
                    </li>
                    <!-- <li><a href="{{ route('sales') }}"><i class="ti-bar-chart"></i> Reports</a></li> -->
                    <li><a href="{{ route('log') }}"><i class="ti-bar-chart"></i> System Logs</a></li>
                
                </ul>
            </div>
        </div>
    </div>
    <!-- /# sidebar -->
    <div class="header">
        <div class="pull-left">
            <div class="logo">
                <a href="/" target='_blank'>
                    <img id="logoImg" src="/img/logo.png" data-logo_big="/img/logo.png" data-logo_small="/img/logo-small.png" alt="{{ env('APP_NAME') }}" />
                </a>
            </div>
            <div class="hamburger sidebar-toggle">
                <span class="ti-menu"></span>
            </div>
        </div>
        <div class="pull-right p-r-15">
            <ul>
                <li class="header-icon dib">
                    <img class="avatar-img" src="/theme/images/avatar/1.jpg" alt="" /> <span class="user-avatar">{{auth()->user()->name}} <i class="ti-angle-down f-s-10"></i></span>
                    <div class="drop-down dropdown-profile">
                        <div class="dropdown-content-body">
                            <ul>
                                <!-- <li><a href="change_password"><i class="ti-lock"></i> <span>Change Password</span></a></li> -->
                                <li><a href="#" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="ti-power-off"></i> <span>Logout</span></a></li>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </ul>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="chat-sidebar">
        <!-- BEGIN chat -->
        <div id="mmc-chat" class="color-default">
            <!-- BEGIN CHAT BOX -->
            <div class="chat-box">
                <!-- BEGIN CHAT BOXS -->
                <ul class="boxs"></ul>
                <!-- END CHAT BOXS -->
                <div class="icons-set">
                    <div class="stickers">
                        <div class="had-container">
                            <div class="row">
                                <div class="s12">
                                    <ul class="tabs" style="width: 100%;height: 60px;">
                                        <li class="tab col s3">
                                            <a href="#tab1" class="active">
                                                <img src="/theme/images/1.png" alt="" />
                                            </a>
                                        </li>
                                        <li class="tab col s3"><a href="#tab2">Test 2</a></li>
                                    </ul>
                                </div>
                                <div id="tab1" class="s12 tab-content">
                                    <ul>
                                        <li><img src="/theme/images/1.png" alt="" /></li>
                                        <li><img src="/theme/images/1.png" alt="" /></li>
                                        <li><img src="/theme/images/1.png" alt="" /></li>
                                        <li><img src="/theme/images/1.png" alt="" /></li>
                                        <li><img src="/theme/images/1.png" alt="" /></li>
                                        <li><img src="/theme/images/1.png" alt="" /></li>
                                        <li><img src="/theme/images/1.png" alt="" /></li>
                                        <li><img src="/theme/images/1.png" alt="" /></li>
                                        <li><img src="/theme/images/1.png" alt="" /></li>
                                        <li><img src="/theme/images/1.png" alt="" /></li>
                                        <li><img src="/theme/images/1.png" alt="" /></li>
                                        <li><img src="/theme/images/1.png" alt="" /></li>
                                        <li><img src="/theme/images/1.png" alt="" /></li>
                                    </ul>
                                </div>
                                <div id="tab2" class="s12 tab-content">Test 2</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END CHAT BOX -->
            <!-- BEGIN SIDEBAR -->
            <div id="sidebar" class="right scroll">
                <div class="had-container">
                    <!-- BEGIN USERS -->
                    <div class="users">
                        <ul class="user-list">
                            <!-- BEGIN USER-->
                            <li class="user-tooltip" data-id="1" data-status="online" data-username="Rufat Askerov" data-position="left" data-filter-item data-filter-name="rufat askerov">
                                <!-- BEGIN USER IMAGE-->
                                <div class="user-image">
                                    <img src="/theme/images/avatar/1.jpg" class="avatar" alt="Rufat Askerov" />
                                </div>
                                <!-- END USER IMAGE-->
                                <!-- BEGIN USERNAME-->
                                <span class="user-name">Rufat Askerov</span>
                                <span class="user-show"></span>
                                <!-- END USERNAME-->
                            </li>
                            <!-- END USER-->
                            <!-- BEGIN USER-->
                            <li class="user-tooltip" data-id="3" data-status="online" data-username="Alice" data-position="left" data-filter-item data-filter-name="alice">
                                <div class="user-image">
                                    <img src="/theme/images/avatar/1.jpg" class="avatar" alt="Alice" />
                                </div>
                                <span class="user-name">Alice</span>
                                <span class="user-show"></span>
                            </li>
                            <!-- BEGIN USER-->
                            <li class="user-tooltip" data-id="7" data-status="offline" data-username="Michael Scofield" data-position="left" data-filter-item data-filter-name="michael scofield">
                                <div class="user-image">
                                    <img src="/theme/images/avatar/1.jpg" class="avatar" alt="Michael Scofield" />
                                </div>
                                <span class="user-name">Michael Scofield</span>
                                <span class="user-show"></span>
                            </li>
                            <!-- BEGIN USER-->
                            <li class="user-tooltip" data-id="5" data-status="online" data-username="Irina Shayk" data-position="left" data-filter-item data-filter-name="irina shayk">
                                <div class="user-image">
                                    <img src="/theme/images/avatar/1.jpg" class="avatar" alt="Irina Shayk" />
                                </div>
                                <span class="user-name">Irina Shayk</span>
                                <span class="user-show"></span>
                            </li>
                            <!-- BEGIN USER-->
                            <li class="user-tooltip" data-id="6" data-status="offline" data-username="Sara Tancredi" data-position="left" data-filter-item data-filter-name="sara tancredi">
                                <div class="user-image">
                                    <img src="/theme/images/avatar/1.jpg" class="avatar" alt="Sara Tancredi" />
                                </div>
                                <span class="user-name">Sara Tancredi</span>
                                <span class="user-show"></span>
                            </li>
                            <!-- BEGIN USER-->
                            <li class="user-tooltip" data-id="7" data-status="offline" data-username="Jane" data-position="left" data-filter-item data-filter-name="Jane">
                                <div class="user-image">
                                    <img src="/theme/images/avatar/1.jpg" class="avatar" alt="Jane" />
                                </div>
                                <span class="user-name">Jane</span>
                                <span class="user-show"></span>
                            </li>
                        </ul>
                        <div class="chat-user-search">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="ti-search"></i></span>
                                <input type="text" class="form-control" placeholder="Search" data-search />
                            </div>
                        </div>
                    </div>
                    <!-- END USERS -->
                </div>
            </div>
            <!-- END SIDEBAR -->
        </div>
        <!-- END chat -->
    </div>
    <!-- END chat Sidebar-->
    <div class="content-wrap">
        <div class="main">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-8 p-0">
                        <div class="page-header">
                            <div class="page-title">
                                <h1>{{isset($title)?$title:''}}</h1>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                    <div class="col-lg-4 p-0">
                        <div class="page-header">
                            <div class="page-title">
                                &nbsp;
                                <ol class="breadcrumb text-right">
                                    <!-- <li><a href="#">Dashboard</a></li>
                                    <li class="active">Home</li> -->
                                </ol>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                </div>
                @if(session()->has('message'))
                    <div class="alert alert-{{session()->get('message')['type']}} alert-dismissable">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                        <strong>{{ucfirst(session()->get('message')['type'])}}</strong> {!! session()->get('message')['msg'] !!}
                    </div>
                @endif
                <!-- /# row -->
                    @yield('content')
                 <!-- /# card -->

                 <!-- Footer -->
                 <footer>
                    <div class="text-right">
                            <p>©{{date('Y')}} All Rights Reserved. </p>
                            
                    </div>
                    <div class="clearfix"></div>
                </footer>
             </div>
             <!-- /# column -->
         </div>
         <!-- /# row -->
     </div>
     <!-- /# main content -->
 </div>
 <!-- /# container-fluid -->
</div>
<!-- /# main -->
</div>

<div class='busy d-none'>
    <div class="spinner-container">
        <img src='/img/spinner.gif' />
    </div>
</div>
<!-- /# content wrap -->
<script src="{{ asset('theme/js/lib/jquery.min.js')}}"></script>
<!-- jquery vendor -->
<script src="{{ asset('theme/js/lib/jquery.nanoscroller.min.js')}}"></script>
<!-- nano scroller -->
<script src="{{ asset('theme/js/lib/sidebar.js')}}"></script>
<!-- sidebar -->
<script src="{{ asset('theme/js/lib/bootstrap.min.js')}}"></script>
<!-- bootstrap -->
<!-- <script src="{{ asset('theme/js/lib/mmc-common.js')}}"></script> -->
<!-- <script src="{{ asset('theme/js/lib/mmc-chat.js')}}"></script> -->
<!--  Chart js -->
<script src="{{ asset('theme/js/lib/chart-js/Chart.bundle.js')}}"></script>
<script src="{{ asset('theme/js/lib/chart-js/chartjs-init.js')}}"></script>
<!-- // Chart js -->
<!--  Datamap -->
<script src="{{ asset('theme/js/lib/datamap/d3.min.js')}}"></script>
<script src="{{ asset('theme/js/lib/datamap/topojson.js')}}"></script>
<!-- <script src="{{ asset('theme/js/lib/datamap/datamaps.world.min.js')}}"></script> -->
<!-- <script src="{{ asset('theme/js/lib/datamap/datamap-init.js')}}"></script> -->
<script src="{{ asset('theme/lib/lobipanel/js/lobipanel.js')}}"></script>

<script src="{{ asset('theme/js/lib/toastr/toastr.min.js')}}"></script>

<script src="{{ asset('summernote/js/summernote-bs4.min.js')}}"></script>
<script src="{{ asset('select2/js/select2.min.js')}}"></script>
<script src="{{ asset('spectrum/spectrum.min.js')}}"></script>
<!-- // Datamap -->
<script src="{{ asset('theme/js/scripts.js')}}"></script>
<script src="{{ asset('jconfirm/js/jquery-confirm.min.js')}}"></script>
<script src="{{ asset('custom/js/script.js')}}"></script>
<!-- scripit init-->

@yield('additional_script')

<script>
    $(document).ready(function() {
        $('#lobipanel-custom-control').lobiPanel({
            reload: false,
            close: false,
            editTitle: false
        });
    });
</script>
</body>
