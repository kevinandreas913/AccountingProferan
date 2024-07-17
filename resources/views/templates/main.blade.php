<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>
            @yield('title') | Proferan - Professional Federation Accounting
        </title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="WebApp for help UMKM to create simple financial statements" name="description" />
        <meta content="Proferam Team" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests" />
        
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

        <!-- Bootstrap Css -->
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-stylesheet" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{ asset('assets/css/app.min.css') }}" id="app-stylesheet" rel="stylesheet" type="text/css" />

        <link rel="stylesheet" href="{{ asset('assets/css/floating-kalkulator-button.css') }}">

        @yield('styles')
    </head>

    <body>

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Topbar Start -->
            @include('templates.topbar')
            <!-- end Topbar -->

            <!-- ========== Left Sidebar Start ========== -->
            @include('templates.sidebar')
            <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->
            <div class="content-page">
                <div class="content">
                    @yield('content')

                    @if(!Auth::guard('admin')->check())
                        <div class="fab">
                            <i class="fa fa-plus"></i>
                        </div>

                        <div class="box">
                            <button class="item btn-calculator-normal" data-toggle="modal" data-target="#normal-kalkulator">
                                <i class="fa fa-calculator"></i>
                            </button>
                            <button class="item btn-calculator-advance" data-toggle="modal" data-target="#advance-kalkulator">
                                <i class="mdi mdi-calculator-variant"></i>
                            </button>
                        </div>

                        <div class="modal fade" id="normal-kalkulator" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-dialog">
                                    <div class="modal-contents">
                                        <div class="modal-body-edit">
                                            <div class="modal-body-edit">
                                                <div class="iframe1">
                                                    <iframe src="/normal-kalkulator" frameborder="0" width="100%" height="600px"></iframe>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="advance-kalkulator" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-dialog">
                                    <div class="modal-contents">
                                        <div class="modal-body-edit">
                                            <div class="modal-body-edit">
                                                <div class="iframe1">
                                                    <iframe src="/advance-kalkulator" frameborder="0" width="100%" height="600px"></iframe>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->

            <!-- Footer Start -->
            @include('templates.footer')
            <!-- Footer End -->

        </div>
        <!-- END wrapper -->
        

        <!-- Vendor js -->
        <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
        
        <!-- knob plugin -->
        <script src="{{ asset('assets/libs/jquery-knob/jquery.knob.min.js') }}"></script>
        
        <!-- App js -->
        <script src="{{ asset('assets/js/app.min.js') }}"></script>
        @yield('scripts')

        <script>
            document.querySelector('.fab').addEventListener('click', function(e) {
                document.querySelector('.box').classList.toggle('box-active');
                document.querySelector('.fab').classList.toggle('fab-active');
            });
            
            window.addEventListener('message', function(event) {
                if (event.data === 'close-modal') {
                    $('#advance-kalkulator').modal('hide');
                    $('#normal-kalkulator').modal('hide');
                }
            });
        </script>
    </body>
</html>