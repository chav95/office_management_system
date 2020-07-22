<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{str_replace('_', ' ', config('app.name'))}}</title>

  <link rel="stylesheet" href="{{asset('css/app.css')}}">
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-footer-fixed scrollbar-black">
<div class="wrapper" id="app">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href=""><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        {{-- <button class="btn btn-outline-primary ml-3" data-toggle="modal" data-target="#UploadMusic">Upload</button> --}}
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      {{-- <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li> --}}
      <!-- Notifications Dropdown Menu -->
      {{-- <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li> --}}
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#"><i
            class="fas fa-th-large"></i></a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <router-link to="/" class="brand-link sidebar-app-logo">
      <img src="{{asset('storage/app_image/logo.png')}}" alt="Office Management Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Office Management</span>
    </router-link>

    <!-- Sidebar -->
    <div class="sidebar scrollbar-black">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('storage/app_image/profile_default.png')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <router-link to="/profile" class="d-block text-capitalize">{{Auth::user()->name}}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <router-link to="/dashboard" class="nav-link">
              <i class="nav-icon fas fa-chart-bar color-teal"></i>
              <p>Dashboard</p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/manage-rooms" class="nav-link">
              <i class="nav-icon fas fa-building color-purple"></i>
              <p>Manage Rooms <i class="right fas fa-angle-left"></i></p>
            </router-link>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/manage-rooms/pending-list" class="nav-link">
                  <i class="nav-icon fas fa-list-alt color-purple"></i>
                  <p>Pending Booking</p>  
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/manage-rooms/booking-list" class="nav-link">
                  <i class="nav-icon fas fa-list-alt color-purple"></i>
                  <p>Booking List</p>  
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/manage-rooms/settings" class="nav-link">
                  <i class="nav-icon fas fa-wrench color-purple"></i>
                  <p>Settings</p>  
                </router-link>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <router-link to="/manage-cars" class="nav-link">
              <i class="fas fa-car nav-icon color-blue"></i>
              <p>Manage Cars <i class="right fas fa-angle-left"></i></p>
            </router-link>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/manage-cars/pending-list" class="nav-link">
                  <i class="nav-icon fas fa-list-alt color-blue"></i>
                  <p>Pending Booking</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/manage-cars/booking-list" class="nav-link">
                  <i class="nav-icon fas fa-list-alt color-blue"></i>
                  <p>Booking List</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/manage-cars/settings" class="nav-link">
                  <i class="nav-icon fas fa-wrench color-blue"></i>
                  <p>Car Settings</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/manage-cars/driver-settings" class="nav-link">
                  <i class="nav-icon fas fa-wrench color-blue"></i>
                  <p>Driver Settings</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/manage-cars/vendor-settings" class="nav-link">
                  <i class="nav-icon fas fa-wrench color-blue"></i>
                  <p>Vendor Settings</p>
                </router-link>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <!--<a href="#" class="nav-link active">-->
            <router-link to="/manage-docs" class="nav-link">
              <i class="nav-icon fas fa-clipboard-list color-orange"></i>
              <p>Manage Documents</p>
            </router-link>
            {{-- <playlist-sidebar :playlist="{{$playlist}}"></playlist-sidebar>--}}
          </li>
          <li class="nav-item has-treeview">
            <router-link to="/maintenance" class="nav-link">
              <i class="nav-icon fas fa-recycle color-green"></i>
              <p>Maintenance</p>
            </router-link>
          </li>
          <li class="nav-item has-treeview">
            <router-link to="/hrd" class="nav-link">
              <i class="nav-icon fas fa-users color-light-red"></i>
              <p>Human Resource <i class="right fas fa-angle-left"></i></p>
            </router-link>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/hrd/salary-slip" class="nav-link">
                  <i class="nav-icon fas fa-file-invoice-dollar color-light-red"></i>
                  <p>Salary Slip</p>
                </router-link>
              </li>
            </ul>
          </li>
          @if(Auth::user()->privilege == 'admin' || Auth::user()->privilege == 'super_admin')
            <li class="nav-item has-treeview">
              <router-link to="/manage-users" class="nav-link">
                <i class="fas fa-user-cog nav-icon color-yellow"></i>
                <p>Manage Users <i class="right fas fa-angle-left"></i></p>
              </router-link>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <router-link to="/manage-users/users" class="nav-link">
                    <i class="fas fa-user-cog nav-icon color-yellow"></i>
                    <p>User Settings</p>
                  </router-link>
                </li>
                <li class="nav-item">
                  <router-link to="/manage-users/divisions" class="nav-link">
                    <i class="fas fa-user-cog nav-icon color-yellow"></i>
                    <p>Division Settings</p>
                  </router-link>
                </li>
              </ul>
            </li>
          @endif
          {{-- @if(Auth::user()->privilege == 'admin')
            <li class="nav-item">
              <router-link to="/app-settings" class="nav-link">
                <i class="nav-icon fas fa-cog color-green"></i>
                <p>Settings</p>
              </router-link>
            </li>
          @endif --}}
          <li class="nav-item">
            <a class="nav-link" href="{{ route('logout') }}"
              onclick="event.preventDefault();
              document.getElementById('logout-form').submit();">
              <i class="fas fa-power-off nav-icon color-red"></i>
              <p>{{ __('Logout') }}</p>
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
            </form>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <div class="content">
      {{-- <div class="container-fluid"> --}}
        <!-- Display Main Content Here-->
        <!-- component matched by the route will render here -->
        <router-view></router-view>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer no-print">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Company Name
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2020.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<script src="{{asset('js/app.js')}}"></script>
</body>
</html>