<?php
$seg1 = Request::segment(1);
$seg2 = Request::segment(2);
$seg3 = Request::segment(3);
$segs = [
  1 => Request::segment(1),
  2 => Request::segment(2),
  3 => Request::segment(3),
  4 => Request::segment(4),
  5 => Request::segment(5),
];
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="UTF-8" />
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport" />

  <title>JOBS</title>

  <meta name="csrf-token" content="{{ Session::token() }}">
  <!-- General CSS Files - starting -->
  <link rel="stylesheet" href="{{asset('assets/modules/bootstrap/css/bootstrap.min.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/modules/fontawesome/css/all.min.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/modules/izitoast/css/iziToast.min.css')}}" />

  <link rel="stylesheet" href="{{asset('assets/modules/bootstrap-daterangepicker/daterangepicker.css')}}">
  <link rel="stylesheet" href="{{asset('assets/modules/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}">
  <!-- General CSS Files - ending -->

  @if($seg1=='dashboard')
  <link rel="stylesheet" href="{{asset('assets/modules/jqvmap/dist/jqvmap.min.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/modules/weather-icon/css/weather-icons.min.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/modules/weather-icon/css/weather-icons-wind.min.css')}}" />
  @endif

  <link rel="stylesheet" href="{{asset('assets/modules/summernote/summernote-bs4.css')}}" />
  <!-- <link rel="stylesheet" href="{{asset('assets/modules/jquery-selectric/selectric.css')}}" /> -->
  <link rel="stylesheet" href="{{asset('assets/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/modules/select2/dist/css/select2.min.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/modules/dropzonejs/dropzone.css')}}">
  <link rel="stylesheet" href="https://cdn.datatables.net/2.0.6/css/dataTables.dataTables.css" />

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{asset('assets/css/style.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/css/components.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/css/custom.css')}}" />

  <!-- Start GA -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'UA-94034622-3');
  </script>
  <!-- /END GA -->
</head>

<body>



  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <form class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <?php /*
          <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
        */ ?>
          </ul>

        </form>
        <ul class="navbar-nav navbar-right">
          <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link nav-link-lg message-toggle beep"><i class="far fa-envelope"></i></a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right" style="border: 1px solid #6777ef;">
              <div class="dropdown-header">Messages
                <div class="float-right">
                  <a href="#">Mark All As Read</a>
                </div>
              </div>
              <div class="dropdown-list-content dropdown-list-message">
                <a href="#" class="dropdown-item dropdown-item-unread">
                  <div class="dropdown-item-avatar">
                    <img alt="image" src="{{asset('assets/img/avatar/avatar-1.png')}}" class="rounded-circle">
                    <div class="is-online"></div>
                  </div>
                  <div class="dropdown-item-desc">
                    <b>Kusnaedi</b>
                    <p>Hello, Bro!</p>
                    <div class="time">10 Hours Ago</div>
                  </div>
                </a>
                <a href="#" class="dropdown-item dropdown-item-unread">
                  <div class="dropdown-item-avatar">
                    <img alt="image" src="{{asset('assets/img/avatar/avatar-2.png')}}" class="rounded-circle">
                  </div>
                  <div class="dropdown-item-desc">
                    <b>Dedik Sugiharto</b>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit</p>
                    <div class="time">12 Hours Ago</div>
                  </div>
                </a>
                <a href="#" class="dropdown-item dropdown-item-unread">
                  <div class="dropdown-item-avatar">
                    <img alt="image" src="{{asset('assets/img/avatar/avatar-3.png')}}" class="rounded-circle">
                    <div class="is-online"></div>
                  </div>
                  <div class="dropdown-item-desc">
                    <b>Agung Ardiansyah</b>
                    <p>Sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    <div class="time">12 Hours Ago</div>
                  </div>
                </a>
                <a href="#" class="dropdown-item">
                  <div class="dropdown-item-avatar">
                    <img alt="image" src="{{asset('assets/img/avatar/avatar-4.png')}}" class="rounded-circle">
                  </div>
                  <div class="dropdown-item-desc">
                    <b>Ardian Rahardiansyah</b>
                    <p>Duis aute irure dolor in reprehenderit in voluptate velit ess</p>
                    <div class="time">16 Hours Ago</div>
                  </div>
                </a>
                <a href="#" class="dropdown-item">
                  <div class="dropdown-item-avatar">
                    <img alt="image" src="{{asset('assets/img/avatar/avatar-5.png')}}" class="rounded-circle">
                  </div>
                  <div class="dropdown-item-desc">
                    <b>Alfa Zulkarnain</b>
                    <p>Exercitation ullamco laboris nisi ut aliquip ex ea commodo</p>
                    <div class="time">Yesterday</div>
                  </div>
                </a>
              </div>
              <div class="dropdown-footer text-center">
                <a href="#">View All <i class="fas fa-chevron-right"></i></a>
              </div>
            </div>
          </li>
          <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg beep"><i class="far fa-bell"></i></a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right" style="border: 1px solid #6777ef;">
              <div class="dropdown-header">Notifications
                <div class="float-right">
                  <a href="#">Mark All As Read</a>
                </div>
              </div>
              <div class="dropdown-list-content dropdown-list-icons">
                <a href="#" class="dropdown-item dropdown-item-unread">
                  <div class="dropdown-item-icon bg-primary text-white">
                    <i class="fas fa-code"></i>
                  </div>
                  <div class="dropdown-item-desc">
                    Template update is available now!
                    <div class="time text-primary">2 Min Ago</div>
                  </div>
                </a>
                <a href="#" class="dropdown-item">
                  <div class="dropdown-item-icon bg-info text-white">
                    <i class="far fa-user"></i>
                  </div>
                  <div class="dropdown-item-desc">
                    <b>You</b> and <b>Dedik Sugiharto</b> are now friends
                    <div class="time">10 Hours Ago</div>
                  </div>
                </a>
                <a href="#" class="dropdown-item">
                  <div class="dropdown-item-icon bg-success text-white">
                    <i class="fas fa-check"></i>
                  </div>
                  <div class="dropdown-item-desc">
                    <b>Kusnaedi</b> has moved task <b>Fix bug header</b> to <b>Done</b>
                    <div class="time">12 Hours Ago</div>
                  </div>
                </a>
                <a href="#" class="dropdown-item">
                  <div class="dropdown-item-icon bg-danger text-white">
                    <i class="fas fa-exclamation-triangle"></i>
                  </div>
                  <div class="dropdown-item-desc">
                    Low disk space. Let's clean it!
                    <div class="time">17 Hours Ago</div>
                  </div>
                </a>
                <a href="#" class="dropdown-item">
                  <div class="dropdown-item-icon bg-info text-white">
                    <i class="fas fa-bell"></i>
                  </div>
                  <div class="dropdown-item-desc">
                    Welcome to Stisla template!
                    <div class="time">Yesterday</div>
                  </div>
                </a>
              </div>
              <div class="dropdown-footer text-center">
                <a href="#">View All <i class="fas fa-chevron-right"></i></a>
              </div>
            </div>
          </li>
          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
              <img alt="image" src="{{asset('assets/img/avatar/avatar-1.png')}}" class="rounded-circle mr-1">
              <div class="d-sm-none d-lg-inline-block">Hi, <?= Auth::user()->name; ?></div>
            </a>
            <div class="dropdown-menu dropdown-menu-right" style="background: #f9fcfa;border: 1px solid #6777ef;">
              <?php /*
              <div class="dropdown-title">Logged in 5 min ago</div>
              <a href="/profile" class="dropdown-item has-icon">
                <i class="far fa-user"></i> Profile
              </a>
              <a href="/activities" class="dropdown-item has-icon">
                <i class="fas fa-bolt"></i> Activities
              </a>
              <a href="/settings" class="dropdown-item has-icon">
                <i class="fas fa-cog"></i> Settings
              </a>
              <div class="dropdown-divider"></div>
              */ ?>
              <a href="/logout" class="dropdown-item has-icon text-danger">
                <i class="fas fa-sign-out-alt"></i> Logout
              </a>
            </div>
          </li>
        </ul>
      </nav>
      <div class="main-sidebar sidebar-style-2 bg-primary">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="/">
              <img src="{{asset('assets/img/bilal_logo.jpg')}}" alt="logo" class="mt-2" style="width: 100%;
    height: auto;
    padding: 10px;
    margin-top: 0px !important;
    background: #fff;
    height: 75px;" />

            </a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="/">
              <img src="{{asset('assets/img/bilal_favicon.jpg')}}" alt="logo" class="mt-2" height="60" />
            </a>
          </div>
          <ul class="sidebar-menu">

            <li>
              <hr />
            </li>

            <?php if (has_category_permission(1)) { ?>
            <li>
              <a href="{{route('dashboard')}}" class="nav-link">
                <i class="fa fa-th"></i>
                <span>Dashboard</span>
              </a>
            </li>
            <?php } ?>

            <li class="menu-header">Operations</li>
            <?php if (has_category_permission(2)) { ?>
            <li class="dropdown">
              <a href="#" class="nav-link has-dropdown">
                <i class="fas fa-users"></i>
                <span>Jobs Manager</span>
              </a>
              <ul class="dropdown-menu" @if(($seg1=='jobs' && $seg2!='receipts') || $seg1=='work-orders' ) style="display: block;" @endif>

                <?php if (has_permission(67)) { ?>
                  <li class="@if($seg1=='jobs' && $seg2=='') active @endif"><a class="nav-link" href="{{route('jobs')}}">Job Queue</a></li>
                <?php } ?>

                <?php if (has_permission(68)) { ?>
                  <li class="@if($seg1=='jobs' && $seg2=='add') active @endif"><a class="nav-link" href="{{route('create-job')}}">Add New Job</a></li>
                <?php } ?>

                <?php if (has_permission(98)) { ?>
                  <li class="@if($seg1=='jobs' && $seg2=='receipts' && $seg3 == '') active @endif">
                    <a class="nav-link" href="{{route('create-job-receipt')}}">Add Job Receipt</a>
                  </li>
                <?php } ?>

                <?php if (has_permission(50)) { ?>
                  <li class="@if($seg1=='jobs' && $seg2=='payments') active @endif">
                    <a class="nav-link" href="{{route('create-job-payment')}}">Add Job Payments</a>
                  </li>
                <?php } ?>
                <?php if (has_permission(250)) { ?>
                  <li class="@if($seg1=='work-orders' && $seg2=='all') active @endif">
                    <a class="nav-link" href="{{route('work-orders')}}">Work Orders</a>
                  </li>
                <?php } ?>
              </ul>
            </li>
            <?php } ?>
                <!-- Added Bookings tab-->
            <?php if (has_category_permission(8)) { ?>
            <li class="dropdown">
              <a href="#" class="nav-link has-dropdown">
                <i class="fas fa-users"></i>
                <span>Bookings Manager</span>
              </a>
              <ul class="dropdown-menu" @if($seg1=='bookings' ) style="display: block;" @endif>

                <?php if (has_permission(252)) { ?>
                  <li class="@if($seg1=='bookings' && $seg2=='') active @endif"><a class="nav-link" href="{{route('bookings')}}">Booking Queue</a></li>
                <?php } ?>

                <?php if (has_permission(253)) { ?>
                  <li class="@if($seg1=='bookings' && $seg2=='add') active @endif"><a class="nav-link" href="{{route('create-booking')}}">Add New Booking</a></li>
                <?php } ?>

                <?php if (has_permission(252)) { ?>
                  <li class="@if($seg1=='bookings' && $seg2=='summary') active @endif"><a class="nav-link" href="{{route('booking-summary')}}">Booking Summary</a></li>
                <?php } ?>
                
              </ul>
            </li>
            <?php } ?>

            <?php if (has_category_permission(1)) { ?>
            <li>
              <a href="{{route('journal-vouchers')}}" class="nav-link">
                <i class="fa fa-th"></i>
                <span>Journal Vouchers</span>
              </a>
            </li>
            <?php } ?>
            <?php if (has_group_permission(17)) { ?>
            <li class="dropdown">
              <a href="#" class="nav-link has-dropdown">
                <i class="fas fa-fire"></i>
                <span>Job Receipt</span>
              </a>
              <ul class="dropdown-menu" @if($seg1=='jobs' && $seg2=='receipts' ) style="display: block;" @endif>

                <?php if (has_permission(97)) { ?>
                  <li @if($seg2=='receipts' && $seg3=='' ) class="active" @endif>
                    <a class="nav-link" href="{{route('job-receipts')}}">
                      View All
                    </a>
                  </li>
                <?php } ?>

                <?php if (has_permission(98)) { ?>
                  <li @if($seg2=='receipts' && $seg3=='add' ) class="active" @endif>
                    <a class="nav-link" href="{{route('create-job-receipt')}}">
                      Add New
                    </a>
                  </li>
                <?php } ?>

                <?php if (has_permission(97)) { ?>
                  <li @if($seg2=='receipts' && $seg3=='summary' ) class="active" @endif>
                    <a class="nav-link" href="{{route('job-receipts-summary')}}">
                      Summary
                    </a>
                  </li>
                <?php } ?>
              </ul>
            </li>
            <?php } ?>

            <?php if (has_group_permission(45)) { ?>
            <li class="dropdown">
              <a href="#" class="nav-link has-dropdown">
                <i class="fas fa-fire"></i>
                <span>Job Payments</span>
              </a>
              <ul class="dropdown-menu" @if($seg1=='jobs' && $seg2=='payments' ) style="display: block;" @endif>

                <?php if (has_permission(49)) { ?>
                  <li @if($seg2=='payments' && $seg3=='' ) class="active" @endif>
                    <a class="nav-link" href="{{route('job-payments')}}">
                      View All
                    </a>
                  </li>
                <?php } ?>

                <?php if (has_permission(50)) { ?>
                  <li @if($seg2=='payments' && $seg3=='add' ) class="active" @endif>
                    <a class="nav-link" href="{{route('create-job-payment')}}">
                      Add New
                    </a>
                  </li>
                <?php } ?>
              </ul>
            </li>
            <?php } ?>




            <?php if (has_category_permission(3)) { ?>
            <li class="dropdown">
              <a href="#" class="nav-link has-dropdown">
                <i class="fas fa-water"></i>
                <span>Fuel Management</span>
              </a>
              <ul class="dropdown-menu" @if($seg1=='fuel-purchases' || $seg1=='fuel-issue' ) style="display: block;" @endif>

                <?php if (has_permission(121)) { ?>
                  <li><a class="nav-link" href="{{route('fuel-purchases')}}">Purchase</a></li>
                <?php } ?>

                <?php if (has_permission(115)) { ?>
                  <li><a class="nav-link" href="{{route('fuel-issue')}}">Issuance</a></li>
                <?php } ?>


                <li><a class="nav-link" href="#">Consumption</a></li>

              </ul>
            </li>
            <?php } ?>

            <?php if (has_category_permission(7)) { ?>
            <li class="menu-header">REPORTS</li>
            <li class="dropdown">
              <a href="#" class="nav-link has-dropdown">
                <i class="fas fa-fire"></i>
                <span>Reports</span>
              </a>
              <ul class="dropdown-menu" @if($seg1=='reports' ) style="display: block;" @endif>


                <?php if (has_permission(239)) { ?>
                  <li>
                    <a href="{{route('customer-ledger')}}" class="nav-link">
                      <i class="fa fa-file"></i>
                      <span>Customer Ledger</span>
                    </a>
                  </li>
                <?php } ?>
                <?php if (has_permission(240)) { ?>
                  <li>
                    <a href="{{route('vendor-ledger')}}" class="nav-link">
                      <i class="fa fa-file"></i>
                      <span>Vendor Ledger</span>
                    </a>
                  </li>
                <?php } ?>
                <?php if (has_permission(242)) { ?>
                  <li>
                    <a href="{{route('general-ledger')}}" class="nav-link">
                      <i class="fa fa-file"></i>
                      <span>General Ledger</span>
                    </a>
                  </li>
                <?php } ?>
                <?php if (has_permission(241)) { ?>
                  <li>
                    <a href="{{route('bank-ledger')}}" class="nav-link">
                      <i class="fa fa-file"></i>
                      <span>Bank Ledger</span>
                    </a>
                  </li>
                <?php } ?>
                <li>
                  <a href="{{route('party-wise-surplus-deficit')}}" class="nav-link">
                    <i class="fa fa-file"></i>
                    <span>Party wise Surplus Deficit </span>
                  </a>
                </li>
                <?php if (has_permission(246)) { ?>
                  <li>
                    <a href="{{route('job-wise-pnl')}}" class="nav-link">
                      <i class="fa fa-file"></i>
                      <span>Job wise PnL</span>
                    </a>
                  </li>
                <?php } ?>
                <?php /* ?>                                
                <?php if (has_permission(243)) { ?>
                  <li>
                    <a href="{{route('transactions')}}" class="nav-link">
                      <i class="fa fa-file"></i>
                      <span>Transaction List</span>
                    </a>
                  </li>
                <?php } ?>
                <?php if (has_permission(244)) { ?>
                  <li>
                    <a href="{{route('collection')}}" class="nav-link">
                      <i class="fa fa-file"></i>
                      <span>Collection Report</span>
                    </a>
                  </li>
                <?php } ?>
                <?php if (has_permission(245)) { ?>
                  <li>
                    <a href="{{route('adjustment')}}" class="nav-link">
                      <i class="fa fa-file"></i>
                      <span>Adjustment</span>
                    </a>
                  </li>
                <?php } ?>
                
                <?php if (has_permission(247)) { ?>
                  <li>
                    <a href="{{route('customers')}}" class="nav-link">
                      <i class="fa fa-file"></i>
                      <span>Customers List</span>
                    </a>
                  </li>
                <?php } ?>
                <?php if (has_permission(248)) { ?>
                  <li>
                    <a href="{{route('vendors')}}" class="nav-link">
                      <i class="fa fa-file"></i>
                      <span>Vendors List</span>
                    </a>
                  </li>
                <?php } ?>

                <?php */ ?>
              </ul>
            </li>
            <?php } ?>


            <?php if (has_category_permission(6)) { ?>
            <li class="menu-header">Master Setup</li>
            <li class="dropdown">
              <a href="#" class="nav-link has-dropdown">
                <i class="fas fa-fire"></i>
                <span>Tanks Management</span>
              </a>
              <ul class="dropdown-menu" @if($seg1=='tanks' ) style="display: block;" @endif>

                <?php if (has_permission(209)) { ?>
                  <li class=active><a class="nav-link" href="{{route('tanks')}}">View All</a></li>
                <?php } ?>

                <?php if (has_permission(210)) { ?>
                  <li><a class="nav-link" href="{{route('create-tank')}}">Add New</a></li>
                <?php } ?>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="nav-link has-dropdown">
                <i class="fas fa-car"></i>
                <span>Fleets Management</span>
              </a>
              <ul class="dropdown-menu" @if($seg1=='fleets' ) style="display: block;" @endif>

                <?php if (has_permission(149)) { ?>
                  <li class="@if($seg2=='') active @endif">
                    <a class="nav-link" href="{{route('fleets')}}">View All Fleets</a>
                  </li>
                <?php } ?>

                <?php if (has_permission(150)) { ?>
                  <li class="@if($seg2=='add') active @endif">
                    <a class="nav-link" href="{{route('create-fleet')}}">Add New Fleet</a>
                  </li>
                <?php } ?>

                <?php if (has_permission(227)) { ?>
                  <li class="@if($seg2=='manufacturers' && $seg3=='') active @endif">
                    <a class="nav-link" href="{{route('fleet-manufacturers')}}">Manufacturers</a>
                  </li>
                <?php } ?>

                <?php if (has_permission(228)) { ?>
                  <li class="@if($seg2=='manufacturers' && $seg3=='add') active @endif">
                    <a class="nav-link" href="{{route('create-fleet-manufacturer')}}">Add Manufacturer</a>
                  </li>
                <?php } ?>

                <?php if (has_permission(221)) { ?>
                  <li class="@if($seg2=='types' && $seg3=='') active @endif">
                    <a class="nav-link" href="{{route('fleet-types')}}">Fleet Types</a>
                  </li>
                <?php } ?>

                <?php if (has_permission(222)) { ?>
                  <li class="@if($seg2=='types' && $seg3=='add') active @endif">
                    <a class="nav-link" href="{{route('create-fleet-type')}}">Add Fleet Type</a>
                  </li>
                <?php } ?>

              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="nav-link has-dropdown">
                <i class="fas fa-users"></i>
                <span>Users Management</span>
              </a>
              <ul class="dropdown-menu" @if($seg1=='users' ) style="display: block;" @endif>

                <?php if (has_permission(127)) { ?>
                  <li class="@if($seg1=='users' && $seg2=='') active @endif">
                    <a class="nav-link" href="{{route('designations')}}">View All</a>
                  </li>
                <?php } ?>

                <?php if (has_permission(128)) { ?>
                  <li class="@if($seg1=='users' && $seg2=='add') active @endif">
                    <a class="nav-link" href="{{route('create-user')}}">Add New</a>
                  </li>
                <?php } ?>

                <?php if (has_permission(133)) { ?>
                  <li class="@if($seg1=='users' && $seg2=='designations') active @endif">
                    <a class="nav-link" href="{{route('designations')}}">Designations</a>
                  </li>
                <?php } ?>

                <?php if (has_permission(139)) { ?>
                  <li class="@if($seg1=='user-roles') active @endif">
                    <a class="nav-link" href="{{route('user-roles')}}">Roles</a>
                  </li>
                <?php } ?>
              </ul>
            </li>


            <li class="dropdown">
              <a href="#" class="nav-link has-dropdown">
                <i class="fas fa-cogs"></i>
                <span>System Management</span>
              </a>
              <?php
              $items = ['users-status', 'locations', 'operations', 'fuel-types', 'projects', 'account-natures', 'account-titles', 'job-types', 'sales-tax-territories', 'companies', 'parties', 'banks'];
              ?>
              <ul class="dropdown-menu" @if(in_array($seg1, $items)) style="display: block;" @endif>

                <?php if (has_permission(215)) { ?>
                  <li class="@if($seg1=='user-status') active @endif">
                    <a class="nav-link" href="{{route('users-status')}}">User Status</a>
                  </li>
                <?php } ?>

                <?php if (has_permission(155)) { ?>
                  <li class="@if($seg1=='locations') active @endif">
                    <a class="nav-link" href="{{route('locations')}}">Locations</a>
                  </li>
                <?php } ?>

                <?php if (has_permission(161)) { ?>
                  <li class="@if($seg1=='operations') active @endif">
                    <a class="nav-link" href="{{route('operations')}}">Operations</a>
                  </li>
                <?php } ?>

                <?php if (has_permission(167)) { ?>
                  <li class="@if($seg1=='fuel-types') active @endif">
                    <a class="nav-link" href="{{route('fuel-types')}}">Fuel Types</a>
                  </li>
                <?php } ?>

                <?php if (has_permission(173)) { ?>
                  <li class="@if($seg1=='projects') active @endif">
                    <a class="nav-link" href="{{route('projects')}}">Projects</a>
                  </li>
                <?php } ?>

                <?php if (has_permission(1)) { ?>
                  <li class="@if($seg1=='account-natures') active @endif">
                    <a class="nav-link" href="{{route('account-natures')}}">Nature of Accounts</a>
                  </li>
                <?php } ?>

                <?php if (has_permission(7)) { ?>
                  <li class="@if($seg1=='account-titles') active @endif">
                    <a class="nav-link" href="{{route('account-titles')}}">Chart of Accounts</a>
                  </li>
                <?php } ?>

                <?php if (has_permission(179)) { ?>
                  <li class="@if($seg1=='job-types') active @endif">
                    <a class="nav-link" href="{{route('job-types')}}">Job Types</a>
                  </li>
                <?php } ?>

                <?php if (has_permission(185)) { ?>
                  <li class="@if($seg1=='sales-tax-territories') active @endif">
                    <a class="nav-link" href="{{route('sales-tax-territories')}}">Sales Tax Territories</a>
                  </li>
                <?php } ?>

                <?php if (has_permission(191)) { ?>
                  <li class="@if($seg1=='companies') active @endif">
                    <a class="nav-link" href="{{route('companies')}}">Companies</a>
                  </li>
                <?php } ?>

                <?php if (has_permission(197)) { ?>
                  <li class="@if($seg1=='parties') active @endif">
                    <a class="nav-link" href="{{route('parties')}}">Parties</a>
                  </li>
                <?php } ?>

                <?php if (has_permission(25)) { ?>
                  <li class="@if($seg1=='banks') active @endif">
                    <a class="nav-link" href="{{route('banks')}}">Banks</a>
                  </li>
                <?php } ?>

                <?php if(has_permission(25)) { ?>
                  <li class="@if($seg1=='container') active @endif">
                    <a class="nav-link" href="{{route('container-sizes')}}">Container Size</a>
                  </li>
                <?php } ?>

                <?php if (has_permission(19)) { ?>
                  <li class="@if($seg1=='bank-accounts') active @endif">
                    <a class="nav-link" href="{{route('bank-accounts')}}">Bank Accounts</a>
                  </li>
                <?php } ?>

                <?php //if (has_permission(179)) { 
                ?>
                <li class="@if($seg1=='voucher-types') active @endif">
                  <a class="nav-link" href="{{route('voucher-types')}}">Voucher Types</a>
                </li>
                <?php //} 
                ?>

              </ul>
            </li>
            <?php } ?>

          </ul>
        </aside>
      </div>

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{ucfirst(str_replace('-',' ', $seg1)).'-'.ucfirst(str_replace('-',' ', rtrim($seg2, 's')))}}</h1>
          </div>

          {{$slot}}

        </section>
      </div>
      <?php /*
      <footer class="main-footer">
        <div class="footer-left">
          Copyright &copy; 2018 <div class="bullet"></div> Design By <a href="https://nauval.in/">Muhamad Nauval Azhar</a>
        </div>
        <div class="footer-right">

        </div>
      </footer>
      */ ?>
    </div>
  </div>



  <!-- General JS Scripts  - starting -->
  <script src="{{asset('assets/modules/jquery.min.js')}}"></script>
  <script src="{{asset('assets/modules/popper.js')}}"></script>
  <script src="{{asset('assets/modules/tooltip.js')}}"></script>
  <script src="{{asset('assets/modules/bootstrap/js/bootstrap.min.js')}}"></script>
  <script src="{{asset('assets/modules/nicescroll/jquery.nicescroll.min.js')}}"></script>
  <script src="{{asset('assets/modules/moment.min.js')}}"></script>
  <script src="{{asset('assets/modules/izitoast/js/iziToast.min.js')}}"></script>
  <script src="{{asset('assets/modules/jquery-ui/jquery-ui.min.js')}}"></script>

  <script src="{{asset('assets/modules/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
  <script src="{{asset('assets/modules/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"></script>
  <!-- General JS Scripts  - ending -->

  @if($seg1=='dashboard')
  <script src="{{asset('assets/modules/simple-weather/jquery.simpleWeather.min.js')}}"></script>
  <script src="{{asset('assets/modules/chart.min.js')}}"></script>
  <script src="{{asset('assets/modules/jqvmap/dist/jquery.vmap.min.js')}}"></script>
  <script src="{{asset('assets/modules/jqvmap/dist/maps/jquery.vmap.world.js')}}"></script>
  <script src="{{asset('assets/js/page/index-0.js')}}"></script>
  @endif

  <script src="https://cdn.datatables.net/2.0.6/js/dataTables.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.0.2/js/dataTables.buttons.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.dataTables.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.print.min.js"></script>

  <script>
    $(".data-table").dataTable({
      dom: "Bfrltip",
      serverSide: false,
      paging: true,
      pageLength: 100,
      bRetrieve: true,
      layout: {
        topStart: {
          buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
        }
      },

    });
    $(".data-table-no-paging").dataTable({
      dom: "Bfrltip",
      serverSide: false,
      paging: false,
      pageLength: 10,
      bRetrieve: true,
      layout: {
        topStart: {
          buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
        }
      },

    });
    $(".report-datatable").dataTable({
      dom: "Bfrltip",
      serverSide: false,
      paging: true,
      pageLength: 100,
      bRetrieve: true,
      layout: {
        topStart: {
          buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
        }
      },

    });
  </script>

  <script src="{{asset('assets/modules/summernote/summernote-bs4.js')}}"></script>
  <!-- <script src="{{asset('assets/modules/jquery-selectric/jquery.selectric.min.js')}}"></script> -->
  <script src="{{asset('assets/modules/upload-preview/assets/js/jquery.uploadPreview.min.js')}}"></script>
  <script src="{{asset('assets/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js')}}"></script>
  <script src="{{asset('assets/modules/select2/dist/js/select2.full.min.js')}}"></script>

  <script src="{{asset('assets/modules/dropzonejs/min/dropzone.min.js')}}"></script>
  <script src="{{asset('assets/js/page/components-multiple-upload.js')}}"></script>
  <script>
    "use strict";
    //$("select").selectric();
    $.uploadPreview({
      input_field: "#image-upload", // Default: .image-upload
      preview_box: "#image-preview", // Default: .image-preview
      label_field: "#image-label", // Default: .image-label
      label_default: "Choose File", // Default: Choose File
      label_selected: "Change File", // Default: Change File
      no_label: false, // Default: false
      success_callback: null // Default: null
    });
    $(".inputtags").tagsinput('items');
    $('.daterange').daterangepicker({
      locale: {
        format: 'YYYY-MM-DD'
      },
      drops: 'down',
      opens: 'right'
    });
  </script>

  <script src="{{asset('assets/modules/chocolat/dist/js/jquery.chocolat.min.js')}}"></script>

  <!-- Template JS File -->
  <script src="{{asset('assets/js/stisla.js')}}"></script>
  <script src="{{asset('assets/js/scripts.js')}}"></script>
  <script src="{{asset('assets/js/custom.js')}}"></script>


  @if(Session::has('message'))
  <script>
    var type = "{{ Session::get('alert-type', 'info') }}";
    switch (type) {
      case 'info':
        iziToast.info({
          title: 'Info!',
          message: "{{ Session::get('message') }}",
          position: 'topRight'
        });
        break;
      case 'success':
        iziToast.success({
          title: 'Success!',
          message: "{{ Session::get('message') }}",
          position: 'topRight'
        });
        break;
      case 'warning':
        iziToast.warning({
          title: 'Warning!',
          message: "{{ Session::get('message') }}",
          position: 'topRight'
        });
        break;
      case 'error':
        iziToast.error({
          title: 'Error!',
          message: "{{ Session::get('message') }}",
          position: 'topRight'
        });
        break;
    }
  </script>
  @endif

  <script>
    $(document).ready(function() {

      $(".auto_select").on("click", function() {
        $(this).select();
      });

      $(":submit").click(function() {
        $(this).addClass('btn-progress');
      });

      $('.float').keypress(function(event) {
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
          event.preventDefault();
        }
      });

    });

    function showIt(ref) {
      $(ref).removeClass('hide');
    }

    function hideIt(ref) {
      $(ref).addClass('hide');
    }

    function showModal(ref) {
      $(ref).modal('show');
    }
    $('.daterange-cus').daterangepicker({
      locale: {
        format: 'YYYY-MM-DD'
      },
      drops: 'down',
      opens: 'right'
    });


    function calculate_amount_by_rate_qty() {
      $("#amount").val('');
      var qty = parseInt($("#qty").val());
      var rate = parseInt($("#rate").val());

      if (qty && rate) {
        $("#amount").val(parseInt(qty) * parseInt(rate));
      }
    }

    function get_random_number(max = 10000, min = 1) {
      return Math.floor(Math.random() * (max - min) + min);
    }
 
    /*
    function refreshPage(ref){
      location.href = ref;
      return location.replace(ref)
    }
    */
  </script>
  

  @yield('exfooter');


</body>

</html>