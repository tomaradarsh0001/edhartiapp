<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="csrf-token" content="content">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--favicon-->
    <link rel="icon" href="{{ asset('assets/images/logo-icon.png') }}" type="image/png" />
    <!--plugins-->
    <link href="{{ asset('assets/plugins/vectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/bs-stepper/css/bs-stepper.css') }}" rel="stylesheet" />
    <!-- loader-->

    <link href="{{ asset('assets/css/pace.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('assets/js/pace.min.js') }}"></script>
    <!-- Bootstrap CSS -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/bootstrap-extended.css') }}" rel="stylesheet">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
    <!-- <link href="{{ asset('assets/css/multiple/app.css') }}" rel="stylesheet"> -->
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet">
    <!-- Theme Style CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/dark-theme.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/semi-dark.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/header-colors.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/range.css') }}">
    <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" />
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <!-- <link href="{{asset('assets/css/multiple/bs-stepper.css')}}" rel="stylesheet" /> -->
    <title>e-Dharti | @yield('title')</title>
</head>

<body>
    <!--wrapper-->
    <div class="wrapper toggled">
        <!--sidebar wrapper -->
        <div class="sidebar-wrapper" data-simplebar="true">
            <div class="sidebar-header">
                <div>
                    <img src="{{ asset('assets/images/logo-icon.png') }}" class="logo-icon" alt="logo icon">
                </div>
                <div>
                    <h4 class="logo-text">e-Dharti</h4>
                </div>
                <div class="toggle-icon mobile-toggle"><i class='bx bx-menu'></i></div>
                <!-- <div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
                </div> -->
            </div>
            <!--navigation-->
            <ul class="metismenu" id="menu">
                <li class="{{ request()->is('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}">
                        <div class="parent-icon"><i class='bx bx-home-circle'></i>
                        </div>
                        <div class="menu-title">Dashboard</div>
                    </a>
                </li>
                @haspermission('view reports')
                <li>
                    <a href="javascript:;" class="has-arrow">
                        <div class="parent-icon"><i class="bx bx-message-square-edit"></i>
                        </div>
                        <div class="menu-title">Reports</div>
                    </a>
                    <ul>
                        <li class="{{ request()->is('reports') ? 'active' : '' }}"> <a
                                href="{{ route('reports.index') }}"><i class="bx bx-right-arrow-alt"></i>Reports</a>
                        </li>
                        <li class="{{ request()->is('tabular-record') ? 'active' : '' }}"> <a
                                href="{{ route('tabularRecord') }}"><i class="bx bx-right-arrow-alt"></i>Tabular
                                Record</a>
                        </li>
                    </ul>
                </li>
                @endhaspermission
                <li>
                    <a href="javascript:;" class="has-arrow">
                        <div class="parent-icon"><i class="bx bx-category"></i>
                        </div>
                        <div class="menu-title">MIS</div>
                    </a>
                    <ul>
                        <li class="{{ request()->is('property-form') ? 'active' : '' }}"> <a
                                href="{{ route('mis.index') }}"><i class="bx bx-right-arrow-alt"></i>Add Property</a>
                        </li>
                        @haspermission('add.multiple.property')
                        <li class="{{ request()->is('property-form-multiple') ? 'active' : '' }}"> <a
                                href="{{ route('mis.form.multiple') }}"><i class="bx bx-right-arrow-alt"></i>Add
                                Multiple Property</a>
                        </li>
                        @endhaspermission
                        @haspermission('viewDetails')
                        <li class="{{ request()->is('property-details') ? 'active' : '' }}"> <a
                                href="{{ route('propertDetails') }}"><i class="bx bx-right-arrow-alt"></i>View
                                Details</a>
                        </li>
                        @endhaspermission

                    </ul>
                </li>
                <!-- <li class="menu-label">UI Elements</li>
                <li>
                    <a href="widgets.html">
                        <div class="parent-icon"><i class='bx bx-cookie'></i>
                        </div>
                        <div class="menu-title">Widgets</div>
                    </a>
                </li>
                <li>
                    <a href="javascript:;" class="has-arrow">
                        <div class="parent-icon"><i class='bx bx-cart'></i>
                        </div>
                        <div class="menu-title">eCommerce</div>
                    </a>
                    <ul>
                        <li> <a href="ecommerce-products.html"><i class="bx bx-right-arrow-alt"></i>Products</a>
                        </li>
                        <li> <a href="ecommerce-products-details.html"><i class="bx bx-right-arrow-alt"></i>Product
                                Details</a>
                        </li>
                        <li> <a href="ecommerce-add-new-products.html"><i class="bx bx-right-arrow-alt"></i>Add New
                                Products</a>
                        </li>
                        <li> <a href="ecommerce-orders.html"><i class="bx bx-right-arrow-alt"></i>Orders</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a class="has-arrow" href="javascript:;">
                        <div class="parent-icon"><i class='bx bx-bookmark-heart'></i>
                        </div>
                        <div class="menu-title">Components</div>
                    </a>
                    <ul>
                        <li> <a href="component-alerts.html"><i class="bx bx-right-arrow-alt"></i>Alerts</a>
                        </li>
                        <li> <a href="component-accordions.html"><i class="bx bx-right-arrow-alt"></i>Accordions</a>
                        </li>
                        <li> <a href="component-badges.html"><i class="bx bx-right-arrow-alt"></i>Badges</a>
                        </li>
                        <li> <a href="component-buttons.html"><i class="bx bx-right-arrow-alt"></i>Buttons</a>
                        </li>
                        <li> <a href="component-cards.html"><i class="bx bx-right-arrow-alt"></i>Cards</a>
                        </li>
                        <li> <a href="component-carousels.html"><i class="bx bx-right-arrow-alt"></i>Carousels</a>
                        </li>
                        <li> <a href="component-list-groups.html"><i class="bx bx-right-arrow-alt"></i>List Groups</a>
                        </li>
                        <li> <a href="component-media-object.html"><i class="bx bx-right-arrow-alt"></i>Media
                                Objects</a>
                        </li>
                        <li> <a href="component-modals.html"><i class="bx bx-right-arrow-alt"></i>Modals</a>
                        </li>
                        <li> <a href="component-navs-tabs.html"><i class="bx bx-right-arrow-alt"></i>Navs & Tabs</a>
                        </li>
                        <li> <a href="component-navbar.html"><i class="bx bx-right-arrow-alt"></i>Navbar</a>
                        </li>
                        <li> <a href="component-paginations.html"><i class="bx bx-right-arrow-alt"></i>Pagination</a>
                        </li>
                        <li> <a href="component-popovers-tooltips.html"><i class="bx bx-right-arrow-alt"></i>Popovers
                                & Tooltips</a>
                        </li>
                        <li> <a href="component-progress-bars.html"><i class="bx bx-right-arrow-alt"></i>Progress</a>
                        </li>
                        <li> <a href="component-spinners.html"><i class="bx bx-right-arrow-alt"></i>Spinners</a>
                        </li>
                        <li> <a href="component-notifications.html"><i
                                    class="bx bx-right-arrow-alt"></i>Notifications</a>
                        </li>
                        <li> <a href="component-avtars-chips.html"><i class="bx bx-right-arrow-alt"></i>Avatrs &
                                Chips</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a class="has-arrow" href="javascript:;">
                        <div class="parent-icon"><i class="bx bx-repeat"></i>
                        </div>
                        <div class="menu-title">Content</div>
                    </a>
                    <ul>
                        <li> <a href="content-grid-system.html"><i class="bx bx-right-arrow-alt"></i>Grid System</a>
                        </li>
                        <li> <a href="content-typography.html"><i class="bx bx-right-arrow-alt"></i>Typography</a>
                        </li>
                        <li> <a href="content-text-utilities.html"><i class="bx bx-right-arrow-alt"></i>Text
                                Utilities</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a class="has-arrow" href="javascript:;">
                        <div class="parent-icon"> <i class="bx bx-donate-blood"></i>
                        </div>
                        <div class="menu-title">Icons</div>
                    </a>
                    <ul>
                        <li> <a href="icons-line-icons.html"><i class="bx bx-right-arrow-alt"></i>Line Icons</a>
                        </li>
                        <li> <a href="icons-boxicons.html"><i class="bx bx-right-arrow-alt"></i>Boxicons</a>
                        </li>
                        <li> <a href="icons-feather-icons.html"><i class="bx bx-right-arrow-alt"></i>Feather Icons</a>
                        </li>
                    </ul>
                </li>
                <li class="menu-label">Forms & Tables</li>
                <li>
                    <a class="has-arrow" href="javascript:;">
                        <div class="parent-icon"><i class='bx bx-message-square-edit'></i>
                        </div>
                        <div class="menu-title">Forms</div>
                    </a>
                    <ul>
                        <li> <a href="form-elements.html"><i class="bx bx-right-arrow-alt"></i>Form Elements</a>
                        </li>
                        <li> <a href="form-input-group.html"><i class="bx bx-right-arrow-alt"></i>Input Groups</a>
                        </li>
                        <li> <a href="form-radios-and-checkboxes.html"><i class="bx bx-right-arrow-alt"></i>Radios &
                                Checkboxes</a>
                        </li>
                        <li> <a href="form-layouts.html"><i class="bx bx-right-arrow-alt"></i>Forms Layouts</a>
                        </li>
                        <li> <a href="form-validations.html"><i class="bx bx-right-arrow-alt"></i>Form Validation</a>
                        </li>
                        <li> <a href="form-wizard.html"><i class="bx bx-right-arrow-alt"></i>Form Wizard</a>
                        </li>
                        <li> <a href="form-text-editor.html"><i class="bx bx-right-arrow-alt"></i>Text Editor</a>
                        </li>
                        <li> <a href="form-file-upload.html"><i class="bx bx-right-arrow-alt"></i>File Upload</a>
                        </li>
                        <li> <a href="form-date-time-pickes.html"><i class="bx bx-right-arrow-alt"></i>Date
                                Pickers</a>
                        </li>
                        <li> <a href="form-select2.html"><i class="bx bx-right-arrow-alt"></i>Select2</a>
                        </li>
                        <li> <a href="form-repeater.html"><i class="bx bx-right-arrow-alt"></i>Form Repeater</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a class="has-arrow" href="javascript:;">
                        <div class="parent-icon"><i class="bx bx-grid-alt"></i>
                        </div>
                        <div class="menu-title">Tables</div>
                    </a>
                    <ul>
                        <li> <a href="table-basic-table.html"><i class="bx bx-right-arrow-alt"></i>Basic Table</a>
                        </li>
                        <li> <a href="table-datatable.html"><i class="bx bx-right-arrow-alt"></i>Data Table</a>
                        </li>
                    </ul>
                </li>
                <li class="menu-label">Pages</li>
                <li>
                    <a class="has-arrow" href="javascript:;">
                        <div class="parent-icon"><i class="bx bx-lock"></i>
                        </div>
                        <div class="menu-title">Authentication</div>
                    </a>
                    <ul>
                        <li><a class="has-arrow" href="javascript:;"><i class="bx bx-right-arrow-alt"></i>Basic</a>
                            <ul>
                                <li><a href="auth-basic-signin.html" target="_blank"><i
                                            class="bx bx-right-arrow-alt"></i>Sign In</a></li>
                                <li><a href="auth-basic-signup.html" target="_blank"><i
                                            class="bx bx-right-arrow-alt"></i>Sign Up</a></li>
                                <li><a href="auth-basic-forgot-password.html" target="_blank"><i
                                            class="bx bx-right-arrow-alt"></i>Forgot Password</a></li>
                                <li><a href="auth-basic-reset-password.html" target="_blank"><i
                                            class="bx bx-right-arrow-alt"></i>Reset Password</a></li>
                            </ul>
                        </li>
                        <li><a class="has-arrow" href="javascript:;"><i class="bx bx-right-arrow-alt"></i>Cover</a>
                            <ul>
                                <li><a href="auth-cover-signin.html" target="_blank"><i
                                            class="bx bx-right-arrow-alt"></i>Sign In</a></li>
                                <li><a href="auth-cover-signup.html" target="_blank"><i
                                            class="bx bx-right-arrow-alt"></i>Sign Up</a></li>
                                <li><a href="auth-cover-forgot-password.html" target="_blank"><i
                                            class="bx bx-right-arrow-alt"></i>Forgot Password</a></li>
                                <li><a href="auth-cover-reset-password.html" target="_blank"><i
                                            class="bx bx-right-arrow-alt"></i>Reset Password</a></li>
                            </ul>
                        </li>
                        <li><a class="has-arrow" href="javascript:;"><i class="bx bx-right-arrow-alt"></i>With Header
                                Footer</a>
                            <ul>
                                <li><a href="auth-header-footer-signin.html" target="_blank"><i
                                            class="bx bx-right-arrow-alt"></i>Sign In</a></li>
                                <li><a href="auth-header-footer-signup.html" target="_blank"><i
                                            class="bx bx-right-arrow-alt"></i>Sign Up</a></li>
                                <li><a href="auth-header-footer-forgot-password.html" target="_blank"><i
                                            class="bx bx-right-arrow-alt"></i>Forgot Password</a></li>
                                <li><a href="auth-header-footer-reset-password.html" target="_blank"><i
                                            class="bx bx-right-arrow-alt"></i>Reset Password</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="user-profile.html">
                        <div class="parent-icon"><i class="bx bx-user-circle"></i>
                        </div>
                        <div class="menu-title">User Profile</div>
                    </a>
                </li>
                <li>
                    <a href="timeline.html">
                        <div class="parent-icon"> <i class="bx bx-video-recording"></i>
                        </div>
                        <div class="menu-title">Timeline</div>
                    </a>
                </li>
                <li>
                    <a class="has-arrow" href="javascript:;">
                        <div class="parent-icon"><i class="bx bx-error"></i>
                        </div>
                        <div class="menu-title">Errors</div>
                    </a>
                    <ul>
                        <li> <a href="errors-404-error.html" target="_blank"><i class="bx bx-right-arrow-alt"></i>404
                                Error</a>
                        </li>
                        <li> <a href="errors-500-error.html" target="_blank"><i class="bx bx-right-arrow-alt"></i>500
                                Error</a>
                        </li>
                        <li> <a href="errors-coming-soon.html" target="_blank"><i
                                    class="bx bx-right-arrow-alt"></i>Coming Soon</a>
                        </li>
                        <li> <a href="error-blank-page.html" target="_blank"><i
                                    class="bx bx-right-arrow-alt"></i>Blank Page</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="faq.html">
                        <div class="parent-icon"><i class="bx bx-help-circle"></i>
                        </div>
                        <div class="menu-title">FAQ</div>
                    </a>
                </li>
                <li>
                    <a href="pricing-table.html">
                        <div class="parent-icon"><i class="bx bx-diamond"></i>
                        </div>
                        <div class="menu-title">Pricing</div>
                    </a>
                </li>
                <li class="menu-label">Charts & Maps</li>
                <li>
                    <a class="has-arrow" href="javascript:;">
                        <div class="parent-icon"><i class="bx bx-line-chart"></i>
                        </div>
                        <div class="menu-title">Charts</div>
                    </a>
                    <ul>
                        <li> <a href="charts-apex-chart.html"><i class="bx bx-right-arrow-alt"></i>Apex</a>
                        </li>
                        <li> <a href="charts-chartjs.html"><i class="bx bx-right-arrow-alt"></i>Chartjs</a>
                        </li>
                        <li> <a href="charts-highcharts.html"><i class="bx bx-right-arrow-alt"></i>Highcharts</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a class="has-arrow" href="javascript:;">
                        <div class="parent-icon"><i class="bx bx-map-alt"></i>
                        </div>
                        <div class="menu-title">Maps</div>
                    </a>
                    <ul>
                        <li> <a href="map-google-maps.html"><i class="bx bx-right-arrow-alt"></i>Google Maps</a>
                        </li>
                        <li> <a href="map-vector-maps.html"><i class="bx bx-right-arrow-alt"></i>Vector Maps</a>
                        </li>
                    </ul>
                </li>
                <li class="menu-label">Others</li>
                <li>
                    <a class="has-arrow" href="javascript:;">
                        <div class="parent-icon"><i class="bx bx-menu"></i>
                        </div>
                        <div class="menu-title">Menu Levels</div>
                    </a>
                    <ul>
                        <li> <a class="has-arrow" href="javascript:;"><i class="bx bx-right-arrow-alt"></i>Level
                                One</a>
                            <ul>
                                <li> <a class="has-arrow" href="javascript:;"><i
                                            class="bx bx-right-arrow-alt"></i>Level Two</a>
                                    <ul>
                                        <li> <a href="javascript:;"><i class="bx bx-right-arrow-alt"></i>Level
                                                Three</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="https://codervent.com/rocker/documentation/index.html" target="_blank">
                        <div class="parent-icon"><i class="bx bx-folder"></i>
                        </div>
                        <div class="menu-title">Documentation</div>
                    </a>
                </li>
                <li>
                    <a href="https://themeforest.net/user/codervent" target="_blank">
                        <div class="parent-icon"><i class="bx bx-support"></i>
                        </div>
                        <div class="menu-title">Support</div>
                    </a>
                </li> -->
            </ul>
            <!--end navigation-->
        </div>
        <!--end sidebar wrapper -->
        <!--start header -->
        <header>
            <div class="topbar d-flex align-items-center">
                <nav class="navbar navbar-expand">
                    <div class="mob-logo">
                        <img src="{{ asset('assets/images/logo-icon.png') }}" class="logo-icon" alt="logo icon">
                    </div>
                    <div class="toggle-icon"><i class='bx bx-menu'></i></div>
                    <!-- <div class="mobile-toggle-menu"><i class='bx bx-menu'></i>
                </div> -->
                    <!-- <div class="search-bar flex-grow-1">
                        <div class="position-relative search-bar-box">
                            <input type="text" class="form-control search-control"
                                placeholder="Type to search..."> <span
                                class="position-absolute top-50 search-show translate-middle-y"><i
                                    class='bx bx-search'></i></span>
                            <span class="position-absolute top-50 search-close translate-middle-y"><i
                                    class='bx bx-x'></i></span>
                        </div>
                    </div> -->
                    <div class="top-menu ms-auto">
                        <ul class="navbar-nav align-items-center">
                           
                            <!-- Begin Settings Dropdown 30-07-2024 by Diwakar Sinha-->
                            @include('layouts.settings')
                            <!-- End Settings Dropdown -->
                            <li class="d-none nav-item dropdown dropdown-large">
                                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="#"
                                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="alert-count">7</span>
                                    <i class='bx bx-bell'></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="javascript:;">
                                        <div class="msg-header">
                                            <p class="msg-header-title">Notifications</p>
                                            <p class="msg-header-clear ms-auto">Marks all as read</p>
                                        </div>
                                    </a>
                                    <div class="header-notifications-list">
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center">
                                                <div class="notify bg-light-primary text-primary"><i
                                                        class="bx bx-group"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="msg-name">New Customers<span
                                                            class="msg-time float-end">14 Sec
                                                            ago</span></h6>
                                                    <p class="msg-info">5 new user registered</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center">
                                                <div class="notify bg-light-danger text-danger"><i
                                                        class="bx bx-cart-alt"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="msg-name">New Orders <span class="msg-time float-end">2
                                                            min
                                                            ago</span></h6>
                                                    <p class="msg-info">You have recived new orders</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center">
                                                <div class="notify bg-light-success text-success"><i
                                                        class="bx bx-file"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="msg-name">24 PDF File<span class="msg-time float-end">19
                                                            min
                                                            ago</span></h6>
                                                    <p class="msg-info">The pdf files generated</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center">
                                                <div class="notify bg-light-warning text-warning"><i
                                                        class="bx bx-send"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="msg-name">Time Response <span
                                                            class="msg-time float-end">28 min
                                                            ago</span></h6>
                                                    <p class="msg-info">5.1 min avarage time response</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center">
                                                <div class="notify bg-light-info text-info"><i
                                                        class="bx bx-home-circle"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="msg-name">New Product Approved <span
                                                            class="msg-time float-end">2 hrs ago</span></h6>
                                                    <p class="msg-info">Your new product has approved</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center">
                                                <div class="notify bg-light-danger text-danger"><i
                                                        class="bx bx-message-detail"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="msg-name">New Comments <span class="msg-time float-end">4
                                                            hrs
                                                            ago</span></h6>
                                                    <p class="msg-info">New customer comments recived</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center">
                                                <div class="notify bg-light-success text-success"><i
                                                        class='bx bx-check-square'></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="msg-name">Your item is shipped <span
                                                            class="msg-time float-end">5 hrs
                                                            ago</span></h6>
                                                    <p class="msg-info">Successfully shipped your item</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center">
                                                <div class="notify bg-light-primary text-primary"><i
                                                        class='bx bx-user-pin'></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="msg-name">New 24 authors<span
                                                            class="msg-time float-end">1 day
                                                            ago</span></h6>
                                                    <p class="msg-info">24 new authors joined last week</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center">
                                                <div class="notify bg-light-warning text-warning"><i
                                                        class='bx bx-door-open'></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="msg-name">Defense Alerts <span
                                                            class="msg-time float-end">2 weeks
                                                            ago</span></h6>
                                                    <p class="msg-info">45% less alerts last 4 weeks</p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <a href="javascript:;">
                                        <div class="text-center msg-footer">View All Notifications</div>
                                    </a>
                                </div>
                            </li>
                            <li class="d-none nav-item dropdown dropdown-large">
                                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="#"
                                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="alert-count">8</span>
                                    <i class='bx bx-comment'></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="javascript:;">
                                        <div class="msg-header">
                                            <p class="msg-header-title">Messages</p>
                                            <p class="msg-header-clear ms-auto">Marks all as read</p>
                                        </div>
                                    </a>
                                    <div class="header-message-list">
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center">
                                                <div class="user-online">
                                                    <img src="{{ asset('assets/images/avatars/avatar-1.png') }}"
                                                        class="msg-avatar" alt="user avatar">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="msg-name">Daisy Anderson <span
                                                            class="msg-time float-end">5 sec
                                                            ago</span></h6>
                                                    <p class="msg-info">The standard chunk of lorem</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center">
                                                <div class="user-online">
                                                    <img src="{{ asset('assets/images/avatars/avatar-2.png') }}"
                                                        class="msg-avatar" alt="user avatar">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="msg-name">Althea Cabardo <span
                                                            class="msg-time float-end">14
                                                            sec ago</span></h6>
                                                    <p class="msg-info">Many desktop publishing packages</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center">
                                                <div class="user-online">
                                                    <img src="{{ asset('assets/images/avatars/avatar-3.png') }}"
                                                        class="msg-avatar" alt="user avatar">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="msg-name">Oscar Garner <span class="msg-time float-end">8
                                                            min
                                                            ago</span></h6>
                                                    <p class="msg-info">Various versions have evolved over</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center">
                                                <div class="user-online">
                                                    <img src="{{ asset('assets/images/avatars/avatar-4.png') }}"
                                                        class="msg-avatar" alt="user avatar">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="msg-name">Katherine Pechon <span
                                                            class="msg-time float-end">15
                                                            min ago</span></h6>
                                                    <p class="msg-info">Making this the first true generator</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center">
                                                <div class="user-online">
                                                    <img src="{{ asset('assets/images/avatars/avatar-5.png') }}"
                                                        class="msg-avatar" alt="user avatar">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="msg-name">Amelia Doe <span class="msg-time float-end">22
                                                            min
                                                            ago</span></h6>
                                                    <p class="msg-info">Duis aute irure dolor in reprehenderit</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center">
                                                <div class="user-online">
                                                    <img src="{{ asset('assets/images/avatars/avatar-6.png') }}"
                                                        class="msg-avatar" alt="user avatar">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="msg-name">Cristina Jhons <span
                                                            class="msg-time float-end">2 hrs
                                                            ago</span></h6>
                                                    <p class="msg-info">The passage is attributed to an unknown</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center">
                                                <div class="user-online">
                                                    <img src="{{ asset('assets/images/avatars/avatar-7.png') }}"
                                                        class="msg-avatar" alt="user avatar">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="msg-name">James Caviness <span
                                                            class="msg-time float-end">4 hrs
                                                            ago</span></h6>
                                                    <p class="msg-info">The point of using Lorem</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center">
                                                <div class="user-online">
                                                    <img src="{{ asset('assets/images/avatars/avatar-8.png') }}"
                                                        class="msg-avatar" alt="user avatar">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="msg-name">Peter Costanzo <span
                                                            class="msg-time float-end">6 hrs
                                                            ago</span></h6>
                                                    <p class="msg-info">It was popularised in the 1960s</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center">
                                                <div class="user-online">
                                                    <img src="{{ asset('assets/images/avatars/avatar-9.png') }}"
                                                        class="msg-avatar" alt="user avatar">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="msg-name">David Buckley <span
                                                            class="msg-time float-end">2 hrs
                                                            ago</span></h6>
                                                    <p class="msg-info">Various versions have evolved over</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center">
                                                <div class="user-online">
                                                    <img src="{{ asset('assets/images/avatars/avatar-10.png') }}"
                                                        class="msg-avatar" alt="user avatar">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="msg-name">Thomas Wheeler <span
                                                            class="msg-time float-end">2 days
                                                            ago</span></h6>
                                                    <p class="msg-info">If you are going to use a passage</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center">
                                                <div class="user-online">
                                                    <img src="{{ asset('assets/images/avatars/avatar-11.png') }}"
                                                        class="msg-avatar" alt="user avatar">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="msg-name">Johnny Seitz <span class="msg-time float-end">5
                                                            days
                                                            ago</span></h6>
                                                    <p class="msg-info">All the Lorem Ipsum generators</p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <a href="javascript:;">
                                        <div class="text-center msg-footer">View All Messages</div>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="user-box dropdown">
                        <a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="#"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ asset('assets/images/avatars/avatar-1.png') }}" class="user-img"
                                alt="user avatar">
                            <div class="user-info ps-3">
                                <p class="user-name mb-0">{{ Auth::user()->name }}</p>
                                <p class="designattion mb-0">{{ Auth::user()->email }}</p>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <!-- <li><a class="dropdown-item" href="javascript:;"><i
                                        class="bx bx-user"></i><span>Profile</span></a>
                            </li>
                            <li><a class="dropdown-item" href="javascript:;"><i
                                        class="bx bx-cog"></i><span>Settings</span></a>
                            </li>
                            <li><a class="dropdown-item" href="javascript:;"><i
                                        class='bx bx-home-circle'></i><span>Dashboard</span></a>
                            </li>
                            <li><a class="dropdown-item" href="javascript:;"><i
                                        class='bx bx-dollar-circle'></i><span>Earnings</span></a>
                            </li>
                            <li><a class="dropdown-item" href="javascript:;"><i
                                        class='bx bx-download'></i><span>Downloads</span></a>
                            </li>
                            <li>
                                <div class="dropdown-divider mb-0"></div>
                            </li> -->
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <a class="dropdown-item" href="route('logout')" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                        <i class='bx bx-log-out-circle'></i> <span>{{ __('Log Out') }}</span>
                                    </a>
                                </form>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </header>
        <!--end header -->


        <!--start page wrapper -->
        <div class="page-wrapper">
            <div class="page-content">
                @if(session('success'))
                <div class="alert alert-success border-0 bg-success alert-dismissible fade show">
                    <div class="text-white">{{ session('success') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @if(session('failure'))
                <div class="alert alert-danger border-0 bg-danger alert-dismissible fade show">
                    <div class="text-white">{{ session('failure') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @if($errors->any())
                <div class="alert alert-danger border-0 bg-danger alert-dismissible fade show">
                    @foreach ($errors->all() as $error)
                    <div class="text-white">{{$error}}</div>
                    @endforeach
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif



                <!--breadcrumb-->
                <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                    <div class="breadcrumb-title pe-3">MIS</div>
                    <div class="ps-3">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 p-0">
                                <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Multiple Property Form</li>
                            </ol>
                        </nav>

                    </div>
                    <!-- <div class="ms-auto"><a href="#" class="btn btn-primary">Button</a></div> -->
                </div>
                <!--end breadcrumb-->



                <!--start stepper three-->
                <!-- <h6 class="text-uppercase">MIS</h6> -->
                <hr class="mob-none">
                <div class="card">
                    <div class="card-body">
                        <div id="stepper3" class="bs-stepper gap-4 vertical">
                            <div class="bs-stepper-header" role="tablist">
                                <div class="step" data-target="#test-vl-1">
                                    <div class="step-trigger" role="tab" id="stepper3trigger1"
                                        aria-controls="test-vl-1">
                                        <div class="bs-stepper-circle">1</div>
                                        <!-- <div class="bs-stepper-circle-content">
                                    <h5 class="mb-0 steper-title">Basic Details</h5>
                                </div> -->
                                    </div>
                                </div>

                                <div class="step" data-target="#test-vl-2">
                                    <div class="step-trigger" role="tab" id="stepper3trigger2"
                                        aria-controls="test-vl-2">
                                        <div class="bs-stepper-circle">2</div>
                                        <!-- <div class="bs-stepper-circle-content">
                                    <h5 class="mb-0 steper-title">Lease Details</h5>
                                </div> -->
                                    </div>
                                </div>

                                <div class="step" data-target="#test-vl-3">
                                    <div class="step-trigger" role="tab" id="stepper3trigger3"
                                        aria-controls="test-vl-3">
                                        <div class="bs-stepper-circle">3</div>
                                        <!-- <div class="bs-stepper-circle-content">
                                    <h5 class="mb-0 steper-title">Land Transfer <br> Details</h5>
                                </div> -->
                                    </div>
                                </div>


                                <div class="step" data-target="#test-vl-4">
                                    <div class="step-trigger" role="tab" id="stepper3trigger4"
                                        aria-controls="test-vl-4">
                                        <div class="bs-stepper-circle">4</div>
                                        <!-- <div class="bs-stepper-circle-content">
                                    <h5 class="mb-0 steper-title">Property Status <br> Details</h5>
                                </div> -->
                                    </div>
                                </div>

                                <div class="step" data-target="#test-vl-5">
                                    <div class="step-trigger" role="tab" id="stepper3trigger5"
                                        aria-controls="test-vl-5">
                                        <div class="bs-stepper-circle">5</div>
                                        <!-- <div class="bs-stepper-circle-content">
                                    <h5 class="mb-0 steper-title">Inspection & <br>Demand Details</h5>
                                </div> -->
                                    </div>
                                </div>

                                <div class="step" data-target="#test-vl-6">
                                    <div class="step-trigger" role="tab" id="stepper3trigger6"
                                        aria-controls="test-vl-6">
                                        <div class="bs-stepper-circle">6</div>
                                        <!-- <div class="bs-stepper-circle-content">
                                    <h5 class="mb-0 steper-title">Miscellaneous <br>Details</h5>
                                </div> -->
                                    </div>
                                </div>

                                <div class="step" data-target="#test-vl-7">
                                    <div class="step-trigger" role="tab" id="stepper3trigger7"
                                        aria-controls="test-vl-7">
                                        <div class="bs-stepper-circle">7</div>
                                        <!-- <div class="bs-stepper-circle-content">
                                    <h5 class="mb-0 steper-title">Latest Contact Details</h5>
                                </div> -->
                                    </div>
                                </div>
                            </div>

                            <div class="bs-stepper-content">
                                <form method="POST" action="{{route('mis.store.multiple')}}">
                                    @csrf
                                    <div id="test-vl-1" role="tabpane3" class="bs-stepper-pane content fade"
                                        aria-labelledby="stepper3trigger1">
                                        <h5 class="mb-1">BASIC DETAILS</h5>
                                        <p class="mb-4">Enter your basic information</p>

                                        <div class="row g-3">
                                            <div class="row align-items-end">

                                                <div class="col-9 col-lg-4">
                                                    <label for="PropertyID" class="form-label">Property ID</label>
                                                    <input type="text" name="property_id" class="form-control"
                                                        id="PropertyID" placeholder="Property ID"
                                                        value="{{ old('property_id') }}"
                                                        oninput="validateInputLength(this)">
                                                </div>
                                                <div class="col-3 col-lg-2">
                                                    <button type="button" id="PropertyIDSearchBtn"
                                                        class="btn btn-primary">Search</button>
                                                </div>
                                                @error('property_id')
                                                <span class="errorMsg">{{ $message }}</span>
                                                @enderror
                                                <div id="propertIdError" class="text-danger"></div>
                                            </div>
                                            <div class="col-12 col-lg-12">
                                                <div class="d-flex align-items-center">
                                                    <h6 class="mr-2 mb-0">Are there more than 1 Property IDs apparently
                                                        visible:</h6>
                                                    <div class="form-check">
                                                        <input class="form-check-input" name="is_multiple_prop_id"
                                                            type="checkbox" value="1" id="flexCheckChecked">
                                                        <label class="form-check-label" for="flexCheckChecked">
                                                            <h6 class="mb-0">Yes</h6>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4">
                                                <label for="FileNumber" class="form-label">File Number</label>
                                                <input type="text" class="form-control" name="file_number"
                                                    id="FileNumber" placeholder="File Number"
                                                    value="{{ old('file_number') }}">
                                                <!-- @error('file_number')
                                            <span class="errorMsg">{{ $message }}</span>
                                        @enderror -->
                                                <div id="FileNumberError" class="text-danger"></div>
                                            </div>
                                            <div class="col-12 col-lg-4">
                                                <label for="fileNumberGenerated" class="form-label">Computer generated
                                                    file no</label>
                                                <input type="text" class="form-control" id="fileNumberGenerated"
                                                    placeholder="Generated File No." readonly disabled>
                                            </div>
                                            <div class="col-12 col-lg-4">
                                                <label for="colonyName" class="form-label">Colony Name (Present)</label>
                                                <select class="form-select" name="present_colony_name" id="colonyName"
                                                    aria-label="Colony Name (Present)">
                                                    <option value="">Select</option>
                                                    @foreach ($colonyList as $colony)
                                                    <option value="{{$colony->id}}">{{ $colony->name }}</option>
                                                    @endforeach
                                                </select>
                                                <!-- @error('present_colony_name')
                                            <span class="errorMsg">{{ $message }}</span>
                                        @enderror -->
                                                <div id="PresentColonyNameError" class="text-danger"></div>
                                            </div>
                                            <div class="col-12 col-lg-4">
                                                <label for="ColonyNameOld" class="form-label">Colony Name (Old)</label>
                                                <select class="form-select" name="old_colony_name" id="ColonyNameOld"
                                                    aria-label="Default select example">
                                                    <option value="">Select</option>
                                                    @foreach ($colonyList as $colony)
                                                    <option value="{{$colony->id}}">{{ $colony->name }}</option>
                                                    @endforeach
                                                </select>
                                                <!-- @error('old_colony_name')
                                            <span class="errorMsg">{{ $message }}</span>
                                        @enderror -->
                                                <div id="OldColonyNameError" class="text-danger"></div>
                                            </div>
                                            <div class="col-12 col-lg-4">
                                                <label for="PropertyStatus" class="form-label">Property Status</label>
                                                <select class="form-select" id="PropertyStatus" name="property_status"
                                                    aria-label="Default select example">
                                                    <option value="">Select</option>
                                                    @foreach ($propertyStatus[0]->items as $status)
                                                    <option value="{{$status->id}}">{{ $status->item_name }}</option>
                                                    @endforeach
                                                </select>
                                                <!-- @error('property_status')
                                            <span class="errorMsg">{{ $message }}</span>
                                        @enderror -->
                                                <div id="PropertyStatusError" class="text-danger"></div>
                                            </div>
                                            <div class="col-12 col-lg-4">
                                                <label for="LandType" class="form-label">Land Type</label>
                                                <select class="form-select" id="LandType" name="land_type"
                                                    aria-label="Default select example">
                                                    <option value="">Select</option>
                                                    @foreach ($landTypes[0]->items as $landType)
                                                    <option value="{{$landType->id}}">{{ $landType->item_name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                <!-- @error('land_type')
                                            <span class="errorMsg">{{ $message }}</span>
                                        @enderror -->
                                                <div id="LandTypeError" class="text-danger"></div>
                                            </div>
                                            <div class="col-12 col-lg-4">

                                                <button type="button" class="btn btn-primary px-4 btn-next-form"
                                                    id="submitButton1">Next<i
                                                        class='bx bx-right-arrow-alt ms-2'></i></button>
                                            </div>
                                        </div><!---end row-->

                                    </div>

                                    <div id="test-vl-2" role="tabpane3" class="bs-stepper-pane content fade"
                                        aria-labelledby="stepper3trigger2">

                                        <h5 class="mb-1">LEASE DETAILS</h5>
                                        <p class="mb-4">Enter Your Lease Details</p>

                                        <div class="row g-3">
                                            <div class="col-12 col-lg-3">
                                                <label for="TypeLease" class="form-label">Type of Lease</label>
                                                <select class="form-select" name="lease_type" id="TypeLease"
                                                    aria-label="Type of Lease">
                                                    <option value="">Select</option>
                                                    @foreach ($leaseTypes[0]->items as $leaseType)
                                                    <option value="{{$leaseType->id}}">{{ $leaseType->item_name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                @error('lease_type')
                                                <span class="errorMsg">{{ $message }}</span>
                                                @enderror
                                                <div id="TypeLeaseError" class="text-danger"></div>
                                            </div>
                                            <div class="col-12 col-lg-3">
                                                <label for="dateexecution" class="form-label">Date of Execution</label>
                                                <input type="date" name="date_of_execution" class="form-control"
                                                    id="dateexecution" pattern="\d{2} \d{2} \d{4}"
                                                    value="{{ old('date_of_execution') }}">
                                                @error('date_of_execution')
                                                <span class="errorMsg">{{ $message }}</span>
                                                @enderror
                                                <div id="dateexecutionError" class="text-danger"></div>
                                            </div>
                                            <div class="col-12 col-lg-3">
                                                <label for="lease_exp_duration" class="form-label">Duration</label>
                                                <input type="text" maxlength="2" name="lease_exp_duration"
                                                    class="form-control numericOnly" id="lease_exp_duration"
                                                    placeholder="Duration" value="">
                                                <div id="leaseExpDurationError" class="text-danger"></div>
                                            </div>
                                            <div class="col-12 col-lg-3">
                                                <label for="LeaseAllotmentNo" class="form-label">Lease/Allotment
                                                    No.</label>
                                                <input type="text" name="lease_no" class="form-control"
                                                    id="LeaseAllotmentNo" placeholder="Lease/Allotment No."
                                                    value="{{ old('lease_no') }}">
                                                @error('lease_no')
                                                <span class="errorMsg">{{ $message }}</span>
                                                @enderror
                                                <div id="LeaseAllotmentNoError" class="text-danger"></div>
                                            </div>

                                            <div class="col-12 col-lg-4">
                                                <label for="dateOfExpiration" class="form-label">Date of
                                                    Expiration</label>
                                                <input type="date" class="form-control" name="date_of_expiration"
                                                    id="dateOfExpiration" value="{{ old('date_of_expiration') }}">
                                                @error('date_of_expiration')
                                                <span class="errorMsg">{{ $message }}</span>
                                                @enderror
                                                <div id="dateOfExpirationError" class="text-danger"></div>
                                            </div>
                                            <div class="col-12 col-lg-4">
                                                <label for="dateallotment" class="form-label">Date of Allotment</label>
                                                <input type="date" name="date_of_allotment" class="form-control"
                                                    id="dateallotment" value="{{ old('date_of_allotment') }}">
                                                @error('date_of_allotment')
                                                <span class="errorMsg">{{ $message }}</span>
                                                @enderror
                                                <div id="dateallotmentError" class="text-danger"></div>
                                            </div>
                                            <div class="col-12 col-lg-4">
                                                <label for="blockno" class="form-label">Block No. (Only alphanumeric
                                                    allowed)</label>
                                                <input type="text" name="block_no" class="form-control alphaNum-hiphenForwardSlash" id="blockno"
                                                    maxlength="6" placeholder="Block No." value="{{ old('block_no') }}">
                                                @error('block_no')
                                                <span class="errorMsg">{{ $message }}</span>
                                                @enderror
                                                <!-- <div id="blocknoError" class="text-danger"></div> -->
                                            </div>
                                            <div class="col-12 col-lg-4">
                                                <label for="plotno" class="form-label">Plot No. (Only alphanumeric
                                                    allowed)</label>
                                                <input type="text" name="plot_no" class="form-control plotNoAlpaMix"
                                                    id="plotno" placeholder="Plot No." value="{{ old('plot_no') }}">
                                                @error('plot_no')
                                                <span class="errorMsg">{{ $message }}</span>
                                                @enderror
                                                <div id="plotnoError" class="text-danger"></div>
                                            </div>
                                            
                                            <div class="col-12 col-lg-12">
                                                <!-- Repeater Content -->
                                                <div id="repeater" class="repeater-super-container">
                                                    <div class="col-12 col-lg-12">
                                                        <label for="plotno" class="form-label add-label-title">In favour
                                                            of</label>
                                                        <button type="button"
                                                            class="btn btn-outline-primary repeater-add-btn"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Click on Add More to add more options below"><i
                                                                class="bx bx-plus me-0"></i></button>
                                                        <!-- <button class="btn btn-primary repeater-add-btn px-4"><i class="fadeIn animated bx bx-plus"></i></button> -->
                                                    </div>
                                                    <!-- Repeater Items -->
                                                    <div class="duplicate-field-tab">
                                                        <div class="items" data-group="test">
                                                            <!-- Repeater Content -->
                                                            <div class="item-content">
                                                                <div class="mb-3">
                                                                    <label for="favourName1"
                                                                        class="form-label">Name</label>
                                                                    <input type="text" class="form-control alpha-only"
                                                                        name="favour_name[]" id="favourName1"
                                                                        placeholder="Name" data-name="name">
                                                                    <div id="favourName1Error" class="text-danger">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- Repeater Remove Btn -->
                                                            <div class="repeater-remove-btn">
                                                                <button type="button"
                                                                    class="btn btn-danger remove-btn px-4"
                                                                    data-toggle="tooltip" data-placement="bottom"
                                                                    title="Click on to delete this form">
                                                                    <i class="fadeIn animated bx bx-trash"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Begin Joint Property -->
                                            <div class="col-12 col-lg-12">
                                                <div class="d-flex align-items-center">
                                                    <h6 class="mr-2 mb-0">Is it a joint property?</h6>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="1"
                                                            id="jointproperty" name="is_jointproperty">
                                                        <label class="form-check-label" for="jointproperty">
                                                            <h6 class="mb-0">Yes</h6>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12" id="jointPropertyHideFields" style="display: none;">
                                                <div class="row">
                                                    <div class="col-12 col-lg-12">
                                                        <!-- Repeater Content -->
                                                        <div id="repeaterjointproperty"
                                                            class="repeater-super-container">
                                                            <div class="col-12 col-lg-12">
                                                                <label for="plotno"
                                                                    class="form-label add-label-title">Add More
                                                                    Plot</label>
                                                                <button type="button" class="btn btn-outline-primary repeater-add-btn" data-toggle="tooltip" data-placement="bottom"
                                                                    title="Click on Add More Joint Property"><i class="bx bx-plus me-0"></i></button>
                                                            </div>
                                                            <!-- Repeater Items -->
                                                            <div class="duplicate-field-tab">
                                                                <div class="items" data-group="jointProperty">
                                                                    <!-- Repeater Content -->
                                                                    <div class="item-content row">
                                                                        <div class="col-lg-2 col-12 mb-3">
                                                                            <label for="jointplotno"
                                                                                class="form-label">Plot No. 1</label>
                                                                            <input type="text"
                                                                                class="plotNoAlpaMix form-control"
                                                                                name="jointplotno[]" id="jointplotno"
                                                                                placeholder="Enter Plot No"
                                                                                data-name="jointplotno">
                                                                                <div class="text-danger"></div>
                                                                        </div>
                                                                        <div class="col-lg-4 col-12 mb-3">
                                                                            <label for="jointpropertyarea"
                                                                                class="form-label">Area</label>
                                                                                <div class="unit-field">
                                                                                    <div>
                                                                                    <input type="text"
                                                                                    class="numericDecimal form-control"
                                                                                    name="jointpropertyarea[]"
                                                                                    id="jointpropertyarea"
                                                                                    placeholder="Enter Area"
                                                                                    data-name="jointpropertyarea">
                                                                                    <div class="text-danger"></div>
                                                                                    </div>
                                                                         
                                                                                <div>
                                                                                <select class="form-select"
                                                                                    id="jointpropertyunit"
                                                                                    name="jointpropertyuit[]"
                                                                                    data-name="jointpropertyuit">
                                                                                    <option value="" selected>Select Unit</option>
                                                                                    <option value="27">Acre</option>
                                                                                    <option value="28">Sq Feet</option>
                                                                                    <option value="29">Sq Meter</option>
                                                                                    <option value="30">Sq Yard</option>
                                                                                    <option value="589">Hectare</option>
                                                                                </select>
                                                                                <div class="text-danger"></div>
                                                                                </div>
                                                                                </div>
                                                                            
                                                                            
                                                                        </div>
                                                                        <div class="col-lg-4 col-12 mb-3">
                                                                            <label for="jointpresently_knownas"
                                                                                class="form-label">Property Known as
                                                                                (Present)</label>
                                                                            <input type="text" class="form-control"
                                                                                name="jointpresently_knownas[]"
                                                                                id="jointpresently_knownas"
                                                                                placeholder="Enter Property Known as"
                                                                                data-name="jointpresently_knownas">
                                                                        </div>
                                                                        <div class="col-lg-2 col-12 mb-3">
                                                                            <label for="jointpropertyid"
                                                                                class="form-label">PID</label>
                                                                            <input type="text"
                                                                                class="numericOnly form-control plotPropId"
                                                                                maxlength="5" name="jointpropertyid[]"
                                                                                id="jointpropertyid"
                                                                                placeholder="Enter PID"
                                                                                data-name="jointpropertyid">
                                                                                <div class="text-danger childPidDanger" id="childPidDanger"></div>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <!-- Repeater Remove Btn -->
                                                                    <div class="repeater-remove-btn">
                                                                        <button type="button"
                                                                            class="btn btn-danger remove-btn px-4"
                                                                            data-toggle="tooltip"
                                                                            data-placement="bottom"
                                                                            title="Click on to delete this form">
                                                                            <i class="fadeIn animated bx bx-trash"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <!-- End Joint Property -->
                                            <div class="col-12 col-lg-4">
                                                <label for="presentlyknownsas" class="form-label">Presently Known
                                                    As</label>
                                                <input type="text" class="form-control" id="presentlyknownsas"
                                                    name="presently_known">
                                                @error('presently_known')
                                                <span class="errorMsg">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-12 col-lg-4">
                                                <label for="areaunitname" class="form-label">Area</label>
                                                <div class="unit-field">
                                                    <input type="text" class="numericDecimal form-control unit-input"
                                                        id="areaunitname" name="area">
                                                    <select class="form-select unit-dropdown" id="selectareaunit"
                                                        aria-label="Select Unit" name="area_unit">
                                                        <option value="" selected>Select Unit</option>
                                                        @foreach ($areaUnit[0]->items as $unit)
                                                        <option value="{{$unit->id}}">{{ $unit->item_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                @error('area')
                                                <span class="errorMsg">{{ $message }}</span>
                                                @enderror
                                                @error('area_unit')
                                                <span class="errorMsg">{{ $message }}</span>
                                                @enderror
                                                <div id="selectareaunitError" class="text-danger"></div>
                                            </div>
                                            <div class="col-12 col-lg-4">
                                                <label for="premiumunit1" class="form-label">Premium (Re/ Rs)</label>
                                                <div class="unit-field">
                                                    <div>
                                                    <input type="text" class="form-control mr-2" id="premiumunit1"
                                                    name="premium1">
                                                    <div class="text-danger" id="premiumunit1Error"></div>
                                                    </div>
                                                    <div>
                                                    <input type="text" class="form-control unit-input" id="premiumunit2"
                                                        name="premium2">
                                                        <div class="text-danger" id="premiumunit2Error"></div>
                                                    </div>
                                                    <div>
                                                    <select class="form-select unit-dropdown" name="premium_unit"
                                                        id="selectpremiumunit" aria-label="Select Unit">
                                                        <option value="">Unit</option>
                                                        <option selected value="1">Paise</option>
                                                        <option value="2">Ana</option>
                                                    </select>
                                                    </div>
                                                </div>
                                                @error('premium1')
                                                <span class="errorMsg">{{ $message }}</span>
                                                @enderror
                                                @error('premium2')
                                                <span class="errorMsg">{{ $message }}</span>
                                                @enderror
                                                @error('premium_unit')
                                                <span class="errorMsg">{{ $message }}</span>
                                                @enderror
                                                <div id="premiumunit2Error" class="text-danger"></div>
                                            </div>
                                            <div class="col-12 col-lg-4">
                                                <label for="groundRent1" class="form-label">Ground Rent (Re/ Rs)</label>
                                                <div class="unit-field">
                                                    <div>
                                                        <input type="text" class="form-control mr-2" id="groundRent1"
                                                        name="ground_rent1">
                                                        <div class="text-danger" id="groundRent1Error"></div>
                                                    </div>
                                                    <div>
                                                    <input type="text" class="form-control unit-input" id="groundRent2"
                                                        name="ground_rent2">
                                                    <div class="text-danger" id="groundRent2Error"></div>
                                                    </div>
                                                    <div>
                                                    <select class="form-select unit-dropdown" id="selectGroundRentUnit"
                                                        aria-label="Select Unit" name="ground_rent_unit">
                                                        <option value="">Unit</option>
                                                        <option selected value="1">Paise</option>
                                                        <option value="2">Ana</option>
                                                    </select>
                                                    <div class="text-danger" id="premiumunit2Error"></div>
                                                    </div>
                                                </div>
                                                <div id="groundRent2Error" class="text-danger"></div>
                                            </div>
                                            <div class="col-12 col-lg-3">
                                                <label for="startdateGR" class="form-label">Start Date of Ground
                                                    Rent</label>
                                                <input type="date" class="form-control" id="startdateGR"
                                                    name="start_date_of_gr">
                                                <div id="startdateGRError" class="text-danger"></div>
                                            </div>
                                            <div class="col-12 col-lg-2">
                                                <label for="RGRduration" class="form-label">RGR Duration (Yrs)</label>
                                                <input type="text" class="form-control" id="RGRduration"
                                                    name="rgr_duration" maxlength="2">
                                                <div id="RGRdurationError" class="text-danger"></div>
                                            </div>
                                            <div class="col-12 col-lg-3">
                                                <label for="frevisiondateGR" class="form-label">First Revision of GR due
                                                    on</label>
                                                <input type="date" class="form-control" id="frevisiondateGR"
                                                    name="first_revision_of_gr_due">
                                                <div id="frevisiondateGRError" class="text-danger"></div>
                                            </div>
                                            <div class="col-12 col-lg-6">
                                                <label for="oldPropertyType" class="form-label">Purpose for which
                                                    leased/
                                                    allotted (As per lease)</label>
                                                <select class="form-select" id="oldPropertyType"
                                                    aria-label="Type of Lease" name="purpose_property_type">
                                                    <option value="" selected>Select</option>
                                                    @foreach ($propertyTypes[0]->items as $propertyType)
                                                    <option value="{{$propertyType->id}}">{{ $propertyType->item_name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                <div id="oldPropertyTypeError" class="text-danger"></div>
                                            </div>
                                            <div class="col-12 col-lg-6">
                                                <label for="oldPropertySubType" class="form-label">Sub-Type (Purpose ,
                                                    at
                                                    present)</label>
                                                <select class="form-select" id="oldPropertySubType"
                                                    aria-label="Type of Lease" name="purpose_property_sub_type">
                                                    <option value="" selected>Select</option>
                                                </select>
                                                <div id="oldPropertySubTypeError" class="text-danger"></div>
                                            </div>
                                            <div class="col-12 col-lg-12">
                                                <div class="d-flex align-items-center">
                                                    <h6 class="mr-2 mb-0">Land Use Change</h6>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="1"
                                                            id="landusechange" name="land_use_changed">
                                                        <label class="form-check-label" for="landusechange">
                                                            <h6 class="mb-0">Yes</h6>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12" id="hideFields" style="display: none;">
                                                <div class="row">
                                                <div class="col-12 col-lg-4">
                                                    <label for="dateOfLandChange" class="form-label">Date of Change</label>
                                                    <input type="date" class="form-control" name="date_of_land_change" id="dateOfLandChange" value="">
                                                    <div id="dateOfLandChangeError" class="text-danger"></div>
                                                </div>
                                                    <div class="col-12 col-lg-4">
                                                        <label for="PropertyType" class="form-label">Purpose for which
                                                            leased/ allotted (At present)</label>
                                                        <select class="form-select" id="propertyType"
                                                            aria-label="Type of Lease"
                                                            name="purpose_lease_type_alloted_present">
                                                            <option value="" selected>Select</option>
                                                            @foreach ($propertyTypes[0]->items as $propertyType)
                                                            <option value="{{ $propertyType->id }}">
                                                                {{ $propertyType->item_name }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                        <div id="propertyTypeError" class="text-danger"></div>
                                                    </div>
                                                    <div class="col-12 col-lg-4">
                                                        <label for="propertySubType" class="form-label">Sub-Type
                                                            (Purpose , at
                                                            present)</label>
                                                        <select class="form-select" id="propertySubType"
                                                            aria-label="Type of Lease"
                                                            name="purpose_lease_sub_type_alloted_present">
                                                            <option value="" selected>Select</option>
                                                        </select>
                                                        <div id="propertySubTypeError" class="text-danger"></div>
                                                    </div>


                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="d-flex align-items-center gap-3">
                                                    <!-- <button class="btn btn-outline-secondary px-4" onclick="stepper3.previous()"><i class='bx bx-left-arrow-alt me-2'></i>Previous</button> -->
                                                    <button type="button" class="btn btn-outline-secondary px-4"
                                                        onclick="stepper3.previous()"><i
                                                            class='bx bx-left-arrow-alt me-2'></i>Previous</button>
                                                    <button type="button" class="btn btn-primary px-4 btn-next-form"
                                                        id="submitButton2">Next<i
                                                            class='bx bx-right-arrow-alt ms-2'></i></button>
                                                </div>
                                            </div>
                                        </div><!---end row-->

                                    </div>

                                    <div id="test-vl-3" role="tabpane3" class="bs-stepper-pane content fade"
                                        aria-labelledby="stepper3trigger3">
                                        <h5 class="mb-1">LAND TRANSFER DETAILS</h5>
                                        <p class="mb-4">Enter Land Transfer Details</p>

                                        <div class="row g-3">
                                            <div class="col-12 col-lg-12 mb-3">
                                                <div class="d-flex align-items-center">
                                                    <h6 class="mr-2 mb-0">Transferred</h6>
                                                    <div class="form-check mr-2">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="transferred" value="1" id="transferredFormYes">
                                                        <label class="form-check-label" for="transferredFormYes">
                                                            <h6 class="mb-0">Yes</h6>
                                                        </label>
                                                    </div>
                                                    <!-- <div class="form-check">
                                                <input class="form-check-input" type="radio" name="transferred" value="0" id="transferredFormNo">
                                                <label class="form-check-label" for="transferredFormNo">
                                                    <h6 class="mb-0">No</h6>
                                                </label>
                                            </div> -->
                                                </div>
                                                @error('transferred')
                                                <span class="errorMsg">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row g-3">
                                            <div class="col-lg-12">
                                                <div class="transferred-container" id="transferredContainer">
                                                    <div class="row">
                                                        <div class="col-12 col-lg-12">
                                                            <div class="if-all-select">
                                                                <h4>All Together/Combined</h4>
                                                                <div id="container">
                                                                    <div class="parent-container">
                                                                        <div class="row mb-3">
                                                                            <div class="col-12 col-lg-4 my-4">
                                                                                <label for="ProcessTransfer"
                                                                                    class="form-label">Process of
                                                                                    transfer</label>
                                                                                <select name="land_transfer_type[]"
                                                                                    class="form-select processtransfer form-required"
                                                                                    data-name="processtransfer"
                                                                                    id="ProcessTransfer"
                                                                                    aria-label="Type of Lease">
                                                                                    <option value="" selected="">Select
                                                                                    </option>
                                                                                    <option value="Substitution">
                                                                                        Substitution</option>
                                                                                    <option value="Mutation">Mutation
                                                                                    </option>
                                                                                    <option
                                                                                        value="Substitution cum Mutation">
                                                                                        Substitution cum Mutation
                                                                                    </option>
                                                                                    <option
                                                                                        value="Mutation cum Substitution">
                                                                                        Mutation cum Substitution 
                                                                                    </option>
                                                                                    <option
                                                                                        value="Successor in interest">
                                                                                        Successor in interest</option>
                                                                                    <option value="Others">Others
                                                                                    </option>
                                                                                </select>
                                                                                <div id="ProcessTransferError"
                                                                                    class="text-danger">This field is
                                                                                    required</div>
                                                                            </div>
                                                                            <div class="col-12 col-lg-4 my-4">
                                                                                <label for="transferredDate"
                                                                                    class="form-label">Date</label>
                                                                                <input type="date" name="transferDate[]"
                                                                                    class="form-control transferredDate form-required"
                                                                                    id="transferredDate">
                                                                                <div id="transferredDateError"
                                                                                    class="text-danger">This field is
                                                                                    required</div>
                                                                            </div>
                                                                        </div>
                                                                        <button type="button"
                                                                            class="add-button btn btn-dark"
                                                                            id="addLesseeBtn"><i
                                                                                class="fadeIn animated bx bx-plus"></i>
                                                                            Add Lessee Details</button>
                                                                        <div id="addLesseeBtnError" class="text-danger"
                                                                            style="display: block;">Please click on Add
                                                                            Lessee Button</div>
                                                                        <div class="child-item">
                                                                            <div class="duplicate-field-tab">
                                                                                <div class="items1">
                                                                                    <div class="item-content row">
                                                                                        <div class="col-lg-4 mb-3">
                                                                                            <label for="name"
                                                                                                class="form-label">Name</label>
                                                                                            <input type="text"
                                                                                                name="name0[]"
                                                                                                class="form-control lesseeName form-required alpha-only"
                                                                                                id="name"
                                                                                                placeholder="Name"
                                                                                                data-name="name">
                                                                                            <div id="nameError"
                                                                                                class="text-danger">This
                                                                                                field is required</div>
                                                                                        </div>
                                                                                        <div class="col-lg-4 mb-3">
                                                                                            <label for="age"
                                                                                                class="form-label">Age</label>
                                                                                            <input type="text"
                                                                                                name="age0[]"
                                                                                                class="form-control numericOnly"
                                                                                                id="age"
                                                                                                placeholder="Age"
                                                                                                maxlength="3" data-name="age">
                                                                                            <div id="ageError"
                                                                                                class="text-danger">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-lg-4 mb-3">
                                                                                            <label for="share"
                                                                                                class="form-label">Share</label>
                                                                                            <input type="text"
                                                                                                class="form-control lesseeShare form-required"
                                                                                                id="share"
                                                                                                name="share0[]"
                                                                                                placeholder="Share"
                                                                                                data-name="share">
                                                                                            <div id="shareError"
                                                                                                class="text-danger">This
                                                                                                field is required</div>
                                                                                        </div>
                                                                                        <div class="col-lg-4 mb-3">
                                                                                            <label for="pannumber"
                                                                                                class="form-label">PAN
                                                                                                Number</label>
                                                                                            <input type="text"
                                                                                                class="form-control text-uppercase pan_number_format"
                                                                                                id="pannumber"
                                                                                                name="panNumber0[]"
                                                                                                maxlength="10"
                                                                                                placeholder="PAN Number"
                                                                                                data-name="pannumber">
                                                                                            <div id="pannumberError"
                                                                                                class="text-danger">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-lg-4 mb-3">
                                                                                            <label for="aadharnumber"
                                                                                                class="form-label">Aadhar
                                                                                                Number</label>
                                                                                            <input type="text"
                                                                                                class="form-control text-uppercase numericOnly"
                                                                                                id="aadharnumber"
                                                                                                name="aadharNumber0[]"
                                                                                                placeholder="Aadhar Number"
                                                                                                data-name="aadharnumber"
                                                                                                maxlength="12">
                                                                                            <div id="aadharnumberError"
                                                                                                class="text-danger">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <!-- <button type="button"
                                                                                class="delete-button btn btn-danger"><i
                                                                                    class="fadeIn animated bx bx-trash"></i>
                                                                                Delete Lessee Details</button> -->
                                                                        </div>
                                                                    </div>
                                                                    <button type="button"
                                                                        class="add-parent-button btn btn-primary"
                                                                        id="addTransferBtn"><i
                                                                            class="fadeIn animated bx bx-plus"></i> Add
                                                                        Transfer Details</button>
                                                                </div>
                                                                <div id="addTransferBtnError" class="text-danger"></div>
                                                            </div>
                                                            <div class="else-select-tabs mt-2">
                                                                <h5 id="jointPropertyPlot_title" style="display: none;">Tabs Group</h5>
                                                                <!-- Begin Tabs Container -->
                                                                <div id="dvTabHtml" class="tab"></div>
                                                                <div id="dvTabHtm2" class="tabcontent-container"></div>
                                                                <!-- End Tabs Container -->
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <!-- Duplicate Form End -->

                                            <div class="col-12 mt-4">
                                                <div class="d-flex align-items-center gap-3">

                                                    <button type="button" class="btn btn-outline-secondary px-4"
                                                        onclick="stepper3.previous()"><i
                                                            class='bx bx-left-arrow-alt me-2'></i> Previous</button>

                                                    <button type="button"
                                                        class="btn btn-primary px-4 btn-next-form submitButton3"
                                                        id="submitButton3">Next <i
                                                            class='bx bx-right-arrow-alt ms-2'></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        <!---end row-->

                                    </div>

                                    <div id="test-vl-4" role="tabpane3" class="bs-stepper-pane content fade"
                                        aria-labelledby="stepper3trigger4">
                                        <h5 class="mb-1">PROPERTY STATUS DETAILS</h5>
                                        <p class="mb-4">Please enter Property Status Details</p>
                                        <div class="row g-3 mb-5">
                                            <div id="property_status_free_hold">
                                                <div class="col-12 col-lg-12">
                                                    <div class="d-flex align-items-center">
                                                        <h6 class="mr-2 mb-0">Free Hold (F/H)</h6>
                                                        <div class="form-check mr-2">
                                                            <input class="form-check-input" type="radio"
                                                                name="freeHold[]" value="yes" id="freeHoldFormYes">
                                                            <label class="form-check-label" for="freeHoldFormYes">
                                                                <h6 class="mb-0">Yes</h6>
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="freeHold[]" value="no" id="freeHoldFormNo"
                                                                checked>
                                                            <label class="form-check-label" for="freeHoldFormNo">
                                                                <h6 class="mb-0">No</h6>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="freehold-container" id="freeHoldContainer"
                                                        style="display: none;">
                                                        <div class="col-12 col-lg-4">
                                                            <label for="ConveyanceDate" class="form-label">Date of
                                                                Conveyance Deed</label>
                                                            <input type="date" class="form-control"
                                                                name="conveyanc_date[]" id="ConveyanceDate">
                                                            <span class="text-danger"></span>
                                                        </div>
                                                        <div class="col-12 col-lg-12 mt-4">
                                                            <!-- Repeater Content -->
                                                            <div id="repeater4" class="repeater-super-container">
                                                                <div class="col-12 col-lg-12">
                                                                    <label for="plotno"
                                                                        class="form-label add-label-title">In favour
                                                                        of</label>
                                                                    <button type="button"
                                                                        class="btn btn-outline-primary repeater-add-btn"
                                                                        data-toggle="tooltip" data-placement="bottom"
                                                                        title="Click on Add More to add more options below"><i
                                                                            class="bx bx-plus me-0"></i></button>
                                                                    <!-- <button class="btn btn-primary repeater-add-btn px-4"><i class="fadeIn animated bx bx-plus"></i></button> -->
                                                                </div>
                                                                <!-- Repeater Items -->
                                                                <div class="duplicate-field-tab">
                                                                    <div class="items" data-group="stepFour">
                                                                        <!-- Repeater Content -->

                                                                        <div class="item-content row">
                                                                            <div class="mb-3 col-lg-12 col-12">
                                                                                <label for="inputName1"
                                                                                    class="form-label">Name</label>
                                                                                <input type="text"
                                                                                    name="free_hold_in_favour_name[]"
                                                                                    class="alpha-only form-control"
                                                                                    id="inputName1" placeholder="Name"
                                                                                    data-name="name">
                                                                                <span class="text-danger"></span>
                                                                            </div>
                                                                            <!-- <div class="mb-3 col-lg-4 col-12">
                                                                        <label for="InputProperty_known_as" class="form-label">Property Known as (Present)</label>
                                                                        <input type="text" name="free_hold_in_property_known_as_present[]" class="form-control" id="InputProperty_known_as" placeholder="Property Known as (Present)" data-name="pkap">
                                                                    </div>
                                                                    <div class="mb-3 col-lg-4 col-12">
                                                                        <label for="inputArea" class="form-label">Area</label>
                                                                        <input type="text" name="free_hold_in_favour_name[]" class="form-control" id="inputArea" placeholder="Area" data-name="area">
                                                                        <span class="text-danger"></span>
                                                                    </div> -->
                                                                        </div>
                                                                        <!-- Repeater Remove Btn -->
                                                                        <div class="repeater-remove-btn">
                                                                            <button
                                                                                class="btn btn-danger remove-btn px-4"
                                                                                data-toggle="tooltip"
                                                                                data-placement="bottom"
                                                                                title="Click on delete this form">
                                                                                <i
                                                                                    class="fadeIn animated bx bx-trash"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="property_status_vacant">
                                                <div class="col-12 col-lg-12">
                                                    <div class="d-flex align-items-center">
                                                        <h6 class="mr-2 mb-0">Land Type: Vacant</h6>
                                                        <div class="form-check mr-2">
                                                            <input class="form-check-input" type="radio"
                                                                name="landType[]" value="yes" id="landTypeFormYes">
                                                            <label class="form-check-label" for="landTypeFormYes">
                                                                <h6 class="mb-0">Yes</h6>
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="landType[]" value="no" id="landTypeFormNo"
                                                                checked>
                                                            <label class="form-check-label" for="landTypeFormNo">
                                                                <h6 class="mb-0">No</h6>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="landType-container row" id="landTypeContainer"
                                                        style="display: none;">
                                                        <div class="row">
                                                            <div class="col-12 col-lg-6">
                                                                <label for="ConveyanceDate" class="form-label">In
                                                                    possession
                                                                    of</label>
                                                                <select class="form-select" id="TypeLease"
                                                                    name="in_possession_of[]"
                                                                    aria-label="Type of Lease">
                                                                    <option value="" selected>Select</option>
                                                                    <option value="1">DDA</option>
                                                                    <option value="2">NDMC</option>
                                                                    <option value="3">MCD</option>
                                                                </select>
                                                                <span class="text-danger"></span>
                                                            </div>
                                                            <div class="col-12 col-lg-6">
                                                                <label for="dateTransfer" class="form-label">Date of
                                                                    Transfer</label>
                                                                <input type="date" class="form-control"
                                                                    name="date_of_transfer[]" id="dateTransfer">
                                                                <span class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="property_status_others">
                                                <div class="col-12 col-lg-12">
                                                    <div class="d-flex align-items-center">
                                                        <h6 class="mr-2 mb-0">Land Type : Others</h6>
                                                        <div class="form-check mr-2">
                                                            <input class="form-check-input" type="radio"
                                                                name="landTypeOthers[]" value="yes"
                                                                id="landTypeFormOthersYes">
                                                            <label class="form-check-label" for="landTypeFormOthersYes">
                                                                <h6 class="mb-0">Yes</h6>
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="landTypeOthers[]" value="no"
                                                                id="landTypeFormOthersNo" checked>
                                                            <label class="form-check-label" for="landTypeFormOthersNo">
                                                                <h6 class="mb-0">No</h6>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="landType-container row" id="landTypeOthersContainer"
                                                        style="display: none;">

                                                        <div class="col-12 col-lg-4">
                                                            <label for="remarks" class="form-label">Remarks</label>
                                                            <input type="text" class="form-control" id="remarks"
                                                                name="remark[]">
                                                            <span class="text-danger"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="dvPropertyStatusHtml" class="row g-3"></div>
                                        <div class="row g-3 mt-5">
                                            <div class="col-12 mt-4">
                                                <div class="d-flex align-items-center gap-3">

                                                    <button type="button" class="btn btn-outline-secondary px-4"
                                                        onclick="stepper3.previous()"><i
                                                            class='bx bx-left-arrow-alt me-2'></i> Previous</button>
                                                    <button type="button" class="btn btn-primary px-4 btn-next-form"
                                                        id="submitButton4">Next <i
                                                            class='bx bx-right-arrow-alt ms-2'></i></button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div id="test-vl-5" role="tabpane3" class="bs-stepper-pane content fade"
                                        aria-labelledby="stepper3trigger5">
                                        <h5 class="mb-1">INSPECTION & DEMAND DETAILS</h5>
                                        <p class="mb-4">Please enter Inspection & Demand Details</p>

                                        <div class="row g-3">
                                            <div class="col-12 col-lg-12">
                                                <label for="lastInsReport" class="form-label">Date of Last Inspection
                                                    Report</label>
                                                <input type="date" class="form-control" id="lastInsReport"
                                                    name="date_of_last_inspection_report[]">
                                                <div id="lastInsReportError" class="text-danger"></div>
                                            </div>
                                            <div class="col-12 col-lg-6">
                                                <label for="LastDemandLetter" class="form-label">Date of Last Demand
                                                    Letter</label>
                                                <input type="date" class="form-control"
                                                    name="date_of_last_demand_letter[]" id="LastDemandLetter">
                                                <div id="LastDemandLetterError" class="text-danger"></div>
                                            </div>
                                            <div class="col-12 col-lg-6">
                                                <label for="DemandID" class="form-label">Demand ID</label>
                                                <input type="text" class="form-control numericOnly" name="demand_id[]"
                                                    id="DemandID" placeholder="Demand ID">
                                                <div id="DemandIDError" class="text-danger"></div>
                                            </div>
                                            <div class="col-12 col-lg-12">
                                                <label for="amountDemandLetter" class="form-label">Amount of Last Demand
                                                    Letter</label>
                                                <input type="text" name="amount_of_last_demand[]"
                                                    class="numericDecimal form-control" id="amountDemandLetter">
                                                <div id="amountDemandLetterError" class="text-danger"></div>
                                            </div>
                                            <div class="col-12 col-lg-6">
                                                <label for="LastAmount" class="form-label">Last Amount Received</label>
                                                <input type="text" class="numericDecimal form-control" id="LastAmount"
                                                    name="last_amount_reveived[]" placeholder="Last Amount Received">
                                                <div id="LastAmountError" class="text-danger"></div>
                                            </div>
                                            <div class="col-12 col-lg-6">
                                                <label for="lastamountdate" class="form-label">Date</label>
                                                <input type="date" class="form-control" name="last_amount_date[]"
                                                    id="lastamountdate">
                                                <div id="lastamountdateError" class="text-danger"></div>
                                            </div>

                                        </div>
                                        <div id="dvInspectionDet" class="row g-3"></div>

                                        <!---end row-->
                                        <div class="row g-3 mt-5">
                                            <div class="col-12 mt-4">
                                                <div class="d-flex align-items-center gap-3">

                                                    <button type="button" class="btn btn-outline-secondary px-4"
                                                        onclick="stepper3.previous()"><i
                                                            class='bx bx-left-arrow-alt me-2'></i>Previous</button>



                                                    <button type="button" class="btn btn-primary px-4 btn-next-form"
                                                        id="submitButton5">Next<i
                                                            class='bx bx-right-arrow-alt ms-2'></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="test-vl-6" role="tabpane3" class="bs-stepper-pane content fade"
                                        aria-labelledby="stepper3trigger6">
                                        <h5 class="mb-1">MISCELLANEOUS DETAILS</h5>
                                        <p class="mb-4">Please enter Miscellaneous Details</p>

                                        <div class="row g-3">
                                            <div class="col-12 col-lg-12">
                                                <div class="d-flex align-items-center">
                                                    <h6 class="mr-2 mb-0">GR Revised Ever</h6>
                                                    <div class="form-check mr-2">
                                                        <input class="form-check-input" type="radio" name="GR[]"
                                                            value="1" id="GRFormYes">
                                                        <label class="form-check-label" for="GRFormYes">
                                                            <h6 class="mb-0">Yes</h6>
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="GR[]"
                                                            value="0" id="GRFormNo" checked>
                                                        <label class="form-check-label" for="GRFormNo">
                                                            <h6 class="mb-0">No</h6>
                                                        </label>
                                                    </div>
                                                </div>
                                                @error('GR')
                                                <span class="errorMsg">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="GR-container" id="GRContainer" style="display: none;">
                                                    <div class="col-12 col-lg-4">
                                                        <label for="GRrevisedDate" class="form-label">Date</label>
                                                        <input type="date" name="gr_revised_date[]" class="form-control form-required"
                                                            id="GRrevisedDate">
                                                            <div class="text-danger"></div>
                                                    </div>
                                                </div>
                                            </div>




                                            <hr>
                                            <div class="col-12 col-lg-12">
                                                <div class="d-flex align-items-center">
                                                    <h6 class="mr-2 mb-0">Supplementary Lease Deed Executed</h6>
                                                    <div class="form-check mr-2">
                                                        <input class="form-check-input" type="radio"
                                                            name="Supplementary[]" value="1" id="SupplementaryFormYes">
                                                        <label class="form-check-label" for="SupplementaryFormYes">
                                                            <h6 class="mb-0">Yes</h6>
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="Supplementary[]" value="0" id="SupplementaryFormNo"
                                                            checked>
                                                        <label class="form-check-label" for="SupplementaryFormNo">
                                                            <h6 class="mb-0">No</h6>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="Supplementary-container row" id="SupplementaryContainer"
                                                    style="display: none;">
                                                    <div class="row">
                                                        <div class="col-12 col-lg-6">
                                                            <label for="SupplementaryDate"
                                                                class="form-label">Date</label>
                                                            <input type="date" min="1600-01-01" max="2050-12-31"
                                                                class="form-control form-required" name="supplementary_date[]"
                                                                id="SupplementaryDate">
                                                                <div class="text-danger"></div>
                                                        </div>
                                                        <div class="col-12 col-lg-6">
                                                            <label for="areaunitname" class="form-label">Area</label>
                                                            <div class="unit-field">
                                                                <div>
                                                                <input type="text" class="form-control numericDecimal form-required"
                                                                id="" name="supplementary_area[]">
                                                                <div class="text-danger"></div>
                                                                </div>
                                                                <div>
                                                                <select class="form-select unit-dropdown" id=""
                                                                    aria-label="Select Unit"
                                                                    name="supplementary_area_unit[]">
                                                                    <option value="" selected="">Select Unit</option>
                                                                    <option value="27">Acre</option>
                                                                    <option value="28">Sq Feet</option>
                                                                    <option value="29">Sq Meter</option>
                                                                    <option value="30">Sq Yard</option>
                                                                    <option value="589">Hectare</option>
                                                                </select>
                                                                <div class="text-danger"></div>
</div>
                                                            </div>
                                                            <div id="selectareaunitError" class="text-danger"></div>
                                                        </div>
                                                        <div class="col-12 col-lg-6 mt-3">
                                                            <label for="premiumunit1" class="form-label">Premium (Re/
                                                                Rs)</label>
                                                            <div class="unit-field">
                                                                <div>
                                                                    <input type="text" class="form-control mr-2 numericOnly form-required"
                                                                    id="" name="supplementary_premium1[]">
                                                                    <div class="text-danger"></div>
                                                                </div>
                                                                <div>
                                                                    <input type="text" class="form-control numericOnly form-required"
                                                                    id="" name="supplementary_premium2[]">
                                                                    <div class="text-danger"></div>
                                                                </div>
                                                                <div>
                                                                    <select class="form-select unit-dropdown form-required"
                                                                    name="supplementary_premium_unit[]" id=""
                                                                    aria-label="Select Unit">
                                                                    <option value="">Unit</option>
                                                                    <option selected="" value="1">Paise</option>
                                                                    <option value="2">Ana</option>
                                                                </select>
                                                                <div class="text-danger"></div>
                                                                </div>
                                                            </div>
                                                            <div id="premiumunit2Error" class="text-danger"></div>
                                                        </div>
                                                        <div class="col-12 col-lg-6 mt-3">
                                                            <label for="groundRent1" class="form-label">Ground Rent (Re/
                                                                Rs)</label>
                                                            <div class="unit-field">
                                                                <div>
                                                                    <input type="text" class="form-control mr-2 numericOnly form-required"
                                                                    id="" name="supplementary_ground_rent1[]">
                                                                    <div class="text-danger"></div>
                                                                </div>
                                                                <div>
                                                                    <input type="text" class="form-control numericOnly form-required"
                                                                    id="" name="supplementary_ground_rent2[]">
                                                                    <div class="text-danger"></div>s
                                                                </div>
                                                                <div>
                                                                    <select class="form-select unit-dropdown form-required" id=""
                                                                    aria-label="Select Unit"
                                                                    name="supplementary_ground_rent_unit[]">
                                                                    <option value="">Unit</option>
                                                                    <option selected="" value="1">Paise</option>
                                                                    <option value="2">Ana</option>
                                                                </select>
                                                                <div class="text-danger"></div>
                                                                </div>
                                                            </div>
                                                            <!-- <div id="" class="text-danger"></div> -->
                                                        </div>
                                                    </div>

                                                    <div class="row mt-4 mb-3">
                                                        <div class="col-12 col-lg-12">
                                                            <label for="SupplementaryRemark"
                                                                class="form-label">Remark</label>
                                                            <textarea id="SupplementaryRemark" class="form-required"
                                                                name="supplementary_remark[]" rows="4"
                                                                style="width: 100%;"></textarea>
                                                                <div class="text-danger"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>


                                            <!-- <div class="col-12 col-lg-12">
                                                <div class="d-flex align-items-center">
                                                    <h6 class="mr-2 mb-0">Supplementary Lease Deed Executed</h6>
                                                    <div class="form-check mr-2">
                                                        <input class="form-check-input" type="radio"
                                                            name="Supplementary[]" value="1" id="SupplementaryFormYes">
                                                        <label class="form-check-label" for="SupplementaryFormYes">
                                                            <h6 class="mb-0">Yes</h6>
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="Supplementary[]" value="0" id="SupplementaryFormNo"
                                                            checked>
                                                        <label class="form-check-label" for="SupplementaryFormNo">
                                                            <h6 class="mb-0">No</h6>
                                                        </label>
                                                    </div>
                                                </div>
                                                @error('Supplementary')
                                                    <span class="errorMsg">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="Supplementary-container row" id="SupplementaryContainer"
                                                    style="display: none;">
                                                    <div class="row">
                                                        <div class="col-12 col-lg-6">
                                                            <label for="SupplementaryDate"
                                                                class="form-label">Date</label>
                                                            <input type="date" class="form-control"
                                                                name="supplementary_date[]" id="SupplementaryDate">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> -->



                                            <div class="col-12 col-lg-12">
                                                <div class="d-flex align-items-center">
                                                    <h6 class="mr-2 mb-0">Re-entered</h6>
                                                    <div class="form-check mr-2">
                                                        <input class="form-check-input" type="radio" name="Reentered[]"
                                                            value="1" id="ReenteredFormYes">
                                                        <label class="form-check-label" for="ReenteredFormYes">
                                                            <h6 class="mb-0">Yes</h6>
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="Reentered[]"
                                                            value="0" id="ReenteredFormNo" checked>
                                                        <label class="form-check-label" for="ReenteredFormNo">
                                                            <h6 class="mb-0">No</h6>
                                                        </label>
                                                    </div>
                                                </div>
                                                @error('Reentered')
                                                <span class="errorMsg">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="Reentered-container row" id="ReenteredContainer"
                                                    style="display: none;">

                                                    <div class="col-12 col-lg-4">
                                                        <label for="reentryDate" class="form-label">Date of
                                                            re-entry</label>
                                                        <input type="date" class="form-control form-required" id="reentryDate"
                                                            name="date_of_reentry[]">
                                                            <div class="text-danger"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="miscellDetailsHtml" class="row g-3"></div>
                                        <div class="row g-3 mt-5">
                                            <div class="col-12 mt-4">
                                                <div class="d-flex align-items-center gap-3">

                                                    <button type="button" class="btn btn-outline-secondary px-4"
                                                        onclick="stepper3.previous()"><i
                                                            class='bx bx-left-arrow-alt me-2'></i>Previous</button>

                                                    <button type="button" id="submitButton6"
                                                        class="btn btn-primary px-4 btn-next-form">Next<i
                                                            class='bx bx-right-arrow-alt ms-2'></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="test-vl-7" role="tabpane3" class="bs-stepper-pane content fade"
                                        aria-labelledby="stepper3trigger7">
                                        <h5 class="mb-1">Latest Contact Details</h5>
                                        <p class="mb-4">Please enter Latest Contact Details</p>
                                        <div class="row g-3">
                                            <div class="col-12 col-lg-4">
                                                <label for="address" class="form-label">Address</label>
                                                <input type="text" name="address[]" class="form-control" id="address"
                                                    placeholder="Address">
                                                @error('address')
                                                <span class="errorMsg">{{ $message }}</span>
                                                @enderror
                                                <div id="addressError" class="text-danger"></div>
                                            </div>
                                            <div class="col-12 col-lg-4">
                                                <label for="phoneno" class="form-label">Phone No.</label>
                                                <input type="text" name="phone[]" class="form-control" id="phoneno"
                                                    placeholder="Phone No." maxlength="10">
                                                <div id="phonenoError" class="text-danger"></div>
                                            </div>
                                            <div class="col-12 col-lg-4">
                                                <label for="Email" class="form-label">Email</label>
                                                <input type="email" name="email[]" class="form-control" id="Email"
                                                    placeholder="Email">
                                                <div id="EmailError" class="text-danger"></div>
                                            </div>
                                            <div class="col-12 col-lg-4">
                                                <label for="asondate" class="form-label">As on Date</label>
                                                <input type="date" name="date[]" class="form-control" id="asondate">
                                                <div id="asondateError" class="text-danger"></div>
                                            </div>
                                            <div class="col-12 col-lg-4">
                                                <label for="additional_remark" class="form-label">Remark</label>
                                                <input type="input" name="additional_remark" placeholder="remark"
                                                    class="form-control" id="additional_remark">
                                            </div>
                                            <div class="col-lg-3 d-flex align-items-end">
                                                <div class="form-check d-flex gap-2">
                                                    <input class="form-check-input" type="checkbox" name="alert_flag"
                                                        value="1" id="flexCheckCheckedDanger">
                                                    <label class="form-check-label" for="flexCheckCheckedDanger">
                                                        Is Problemetic
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="plotcontactDetails" class="row g-3"></div>
                                        <div class="row g-3 mt-5">
                                            <div class="col-12">
                                                <div class="d-flex align-items-center gap-3">
                                                    <!-- <button class="btn btn-primary px-4" onclick="stepper3.previous()"><i class='bx bx-left-arrow-alt me-2'></i>Previous</button> -->
                                                    <button type="button" class="btn btn-outline-secondary px-4"
                                                        onclick="stepper3.previous()"><i
                                                            class='bx bx-left-arrow-alt me-2'></i>Previous</button>
                                                    <button type="button" class="btn btn-primary px-4"
                                                        id="btnfinalsubmit">Submit</button>
                                                </div>
                                            </div>
                                        </div><!---end row-->

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end stepper three-->
            </div>
        </div>
        <!--end page wrapper -->



        <!--start overlay-->
        <div class="overlay toggle-icon"></div>
        <!--end overlay-->
        <!--Start Back To Top Button-->
        <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
        <!--End Back To Top Button-->
        <footer class="page-footer">
            <p class="mb-0">Copyright © 2024. All right reserved.</p>
        </footer>
    </div>
    <!--end wrapper-->


    <!--start switcher-->

    <!--end switcher-->


    <!-- Bootstrap JS -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <!--plugins-->
    <script src="{{ asset('assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
    <script src="{{asset('assets/plugins/bs-stepper/js/bs-stepper.min.js')}}"></script>
    <script src="{{asset('assets/plugins/bs-stepper/js/main.js')}}"></script>
    <script src="{{asset('assets/js/multipleForm/repeaterPlot.js')}}"></script>
    <script src="{{asset('assets/plugins/form-repeater/repeater.js')}}"></script>
    <script src="{{asset('assets/plugins/form-repeater/repeater2.js')}}"></script>
    <script src="{{asset('assets/plugins/form-repeater/repeaterChild.js')}}"></script>
    <script src="{{asset('assets/js/multipleForm/mis.js')}}"></script>
    <script src="{{ asset('assets/js/multipleForm/masterMis.js') }}"></script>

    <script src="{{asset('assets/js/multipleForm/jquery-ui.min.js')}}"></script>
    <script src="{{asset('assets/js/multipleForm/jquery.repeater.min.js')}}"></script>
    <script>
        //for check PID of plots exists in database or not - Sourav Chauhan (31 july 2024)
        $('#repeaterjointproperty').on('change','.plotPropId', function() {
            var $input = $(this);
            var inputValue = $input.val();
            
            // Find the closest parent `.item-content` or `.items` to ensure we're targeting the correct section
            var $parentItem = $input.closest('.items');
            
            // Find the error message container within this parent
            var $messageContainer = $parentItem.find('.childPidDanger');

            var plotUniqueId = $(this).attr('id');
            var inputValue = $(this).val();
            if(inputValue){
                $.ajax({
                    url: "{{route('isPropertyAvailable')}}",
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        property_id: inputValue,
                        _token: '{{csrf_token()}}'
                    },
                    success: function (response) {
                        if (response.status === true) {
                            $messageContainer.hide()
                        } else if (response.status === false) {
                            var url = ''
                            if(response.data.location == 'parent'){
                                url = 'property-details/'+response.data.id+'/view';

                            } else {

                                url = 'property-details/child/'+response.data.id
                            }
                            $messageContainer.show()
                            $messageContainer.html(response.message+' <a target="_blank" href='+url+'><i class="fadeIn animated bx bx-info-circle"></i></a>')
                        }
                    },
                    error: function (response) {
                        console.log(response);
                    }

                })

            }
            
        });
        //END

        $("#PropertyIDSearchBtn").on('click', function () {

            var PropertyId = $('#PropertyID').val();

            if (PropertyId) {

                $.ajax({
                    url: "{{route('propertySearch')}}",
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        property_id: PropertyId,
                        _token: '{{csrf_token()}}'
                    },
                    success: function (response) {
                        //console.log(response);
                        if (response.status === true) {
                            //console.log(response);
                            $('#propertIdError').hide();
                            $("input[name='file_number']").val(response.data.file_number);
                            $("#ColonyNameOld option[value=" + response.data.colony_id + "]").attr('selected', true);
                            $("#PropertyStatus option[value=" + response.data.property_status + "]").attr('selected', true);
                            $("#LandType option[value=" + response.data.land_type + "]").attr('selected', true);
                        } else if (response.status === false) {
                            $('#propertIdError').text(response.message);
                            $("input[name='file_number']").val('');
                            /* $("#ColonyNameOld")[0].selectedIndex = 0;
                            $("#PropertyStatus")[0].selectedIndex = 0;
                            $("#LandType")[0].selectedIndex = 0; */
                        } else {
                            $('#propertIdError').text('Property Id not available');
                            $("input[name='file_number']").val('');
                            /* $("#ColonyNameOld")[0].selectedIndex = 0;
                            $("#PropertyStatus")[0].selectedIndex = 0;
                            $("#LandType")[0].selectedIndex = 0; */
                        }
                    },
                    error: function (response) {
                        console.log(response);
                    }

                })

            } else {
                $('#propertIdError').text('Please provide a valid Property ID');
            }

        });


        $(document).ready(function () {
            $('#propertyType').on('change', function () {
                var idPropertyType = this.value;
                $("#propertySubType").html('');
                $.ajax({
                    url: "{{route('prpertySubTypes')}}",
                    type: "POST",
                    data: {
                        property_type_id: idPropertyType,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (result) {

                        $('#propertySubType').html('<option value="">Select Sub Type</option>');
                        $.each(result, function (key, value) {
                            $("#propertySubType").append('<option value="' + value
                                .id + '">' + value.item_name + '</option>');
                        });
                    }
                });
            });


            $('#oldPropertyType').on('change', function () {
                var idPropertyType = this.value;
                $("#oldPropertySubType").html('');
                $.ajax({
                    url: "{{route('prpertySubTypes')}}",
                    type: "POST",
                    data: {
                        property_type_id: idPropertyType,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (result) {

                        $('#oldPropertySubType').html('<option value="">Select Sub Type</option>');
                        $.each(result, function (key, value) {
                            $("#oldPropertySubType").append('<option value="' + value
                                .id + '">' + value.item_name + '</option>');
                        });
                    }
                });
            });

        });


        // Tabs
        function openCity(evt, cityName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.className += " active";
        }
        $(document).ready(function () {
            var $alertElement = $('.alert');
            if ($alertElement.length) {
                setTimeout(function () {
                    $alertElement.fadeOut();
                }, 3000);
            }
        });
    </script>
</body>

</html>