<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Proferan - Professional Federation Accounting</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="WebApp for help UMKM to create simple financial statements" name="description" />
        <meta content="Proferam Team" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests" />

        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="{{ asset('assets/landing/css/bootstrap.min.css') }}" type="text/css">

        <!--Material Icon -->
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/landing/css/materialdesignicons.min.css') }}" />
    
        <!--pe-7 Icon -->
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/landing/css/pe-icon-7-stroke.css') }}" />

        <!-- Magnific-popup -->
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/landing/css/magnific-popup.css') }}">

        <!-- Custom  sCss -->
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/landing/css/style.css') }}" />

    </head>
    <style>
        .image-container {
            position: relative;
            width: 100%;
        }
        .shadow-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }
    </style>
    <body>

        <!--Navbar Start-->
        <nav class="navbar navbar-expand-lg fixed-top navbar-custom sticky sticky-dark">
            <div class="container-fluid">
                <!-- LOGO -->
                <a class="logo" href="index.html">
                    <img src="{{ asset('assets/images/logo-light.png') }}" alt="" class="logo-light" height="32" />
                    <img src="{{ asset('assets/images/logo-dark.png') }}" alt="" class="logo-dark" height="32" />
                </a>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="mdi mdi-menu"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav ml-auto navbar-center" id="mySidenav">
                        <li class="nav-item active">
                            <a href="#home" class="nav-link">Home</a>
                        </li>
                        <li class="nav-item">
                            <a href="#features" class="nav-link">Features</a>
                        </li>
                        <li class="nav-item">
                            <a href="#visi_misi" class="nav-link">Visi & Misi</a>
                        </li>
                        <li class="nav-item">
                            <a href="#information" class="nav-link">Information</a>
                        </li>
                        <li class="nav-item">
                            <a href="#our_team" class="nav-link">Our Team</a>
                        </li>
                        <li class="nav-item">
                            <a href="#contact" class="nav-link">Contact</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Navbar End -->

        <!-- home start -->
        <section class="bg-home bg-gradient" id="home">
            <div class="home-center">
                <div class="home-desc-center">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-lg-6 col-sm-6">
                                <div class="home-title text-white">
                                    <h5 class="mb-3 text-white-50">Discover Proferan Today</h5>
                                    <h2 class="mb-4">Make your Financial Report with Proferan</h2>
                                    <p class="text-white-50 home-desc font-16 mb-5">Proferan is a WebApp that helps MSMEs to create simple financial reports. Proferan also provides education to MSMEs about accounting applications.</p>
                                    <div class="watch-video mt-5">
                                        <a href="{{ route('auth.login.view') }}" class="btn btn-custom mr-4">Get Started <i class="mdi mdi-chevron-right ml-1"></i></a>
                                    </div>
    
                                </div>
                            </div>
                            <div class="col-lg-5 offset-lg-1 col-sm-6">
                                <div class="home-img mo-mt-20">
                                    <img src="{{ asset('assets/landing/images/home-img.png') }}" alt="" class="img-fluid mx-auto d-block">
                                </div>
                            </div>
                        </div>
                        <!-- end row -->
                        
                    </div>
                    <!-- end container-fluid -->
                </div>
            </div>
        </section>
        <!-- home end -->

        <!-- features start -->
        <section class="features" id="features">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <ul class="nav nav-pills nav-justified features-tab mb-5" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link" id="pills-code-tab" data-toggle="pill" href="#pills-code" role="tab" aria-controls="pills-code" aria-selected="true">
                                    <div class="clearfix">
                                        <div class="features-icon float-right">
                                            <i class="pe-7s-notebook h1"></i>
                                        </div>
                                        <div class="d-none d-lg-block mr-4">
                                            <h5>User Manual Book</h5>
                                            <p>Provides guidance how to use</p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-customize-tab" data-toggle="pill" href="#pills-customize" role="tab" aria-controls="pills-customize" aria-selected="false">
                                    <div class="clearfix">
                                        <div class="features-icon float-right">
                                            <i class="pe-7s-edit h1"></i>
                                        </div>
                                        <div class="d-none d-lg-block mr-4">
                                            <h5>Simple & Easy to Use</h5>
                                            <p>Friendly User Interface</p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-support-tab" data-toggle="pill" href="#pills-support" role="tab" aria-controls="pills-support" aria-selected="false">
                                    <div class="features-icon float-right">
                                        <i class="pe-7s-headphones h1"></i>
                                    </div>
                                    <div class="d-none d-lg-block mr-4">
                                        <h5>Awesome Support</h5>
                                        <p>For Micro and Small Enterprises</p>
                                    </div>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade" id="pills-code" role="tabpanel" aria-labelledby="pills-code-tab">
                                <div class="row align-items-center justify-content-center">
                                    <div class="col-lg-4 col-sm-6">
                                        <div>
                                            <img src="{{ asset('assets/landing/images/features-img/img-1.png') }}" alt="" class="img-fluid mx-auto d-block">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 offset-lg-1">
                                        <div>
                                            <div class="feature-icon mb-4">
                                                <i class="pe-7s-notebook h1 text-primary"></i>
                                            </div>
                                            <h5 class="mb-3">User Manual Book</h5>
                                            <p class="text-muted">The Proferan manual aims to provide users with an understanding of how to use financial reports to make better business decisions. With clear and practical explanations, users are given insight into how to analyze the financial information available in the report, such as whether they should still take on additional debt or not.</p>
                                            <p class="text-muted">This helps users make smarter, fact-based financial decisions, thereby increasing the likelihood of their business success. In this way, the user manual serves not only as a technical guide, but also as a valuable source of knowledge to support users in managing their business more effectively.</p>
                                            <div class="mt-4">
                                                <a href="{{ asset('assets/pdf/Buku Manual - Ref 2.pdf') }}" class="btn btn-custom">Download PDF <i class="mdi mdi-cloud-download ml-1"></i></a>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                                <!-- end row -->
                            </div>
                            <div class="tab-pane fades how active" id="pills-customize" role="tabpanel" aria-labelledby="pills-customize-tab">
                                <div class="row align-items-center justify-content-center">
                                    <div class="col-lg-4 col-sm-6">
                                        <div>
                                            <img src="{{ asset('assets/landing/images/features-img/img-2.png') }}" alt="" class="img-fluid mx-auto d-block">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 offset-lg-1">
                                        <div>
                                            <div class="feature-icon mb-4">
                                                <i class="pe-7s-edit h1 text-primary"></i>
                                            </div>
                                            <h5 class="mb-3">Simple & Easy to Use</h5>
                                            <p class="text-muted">Proferan is an accounting application designed with a focus on simplicity and ease of use. With a simple and intuitive interface, Proferan allows users without a strong accounting background to quickly and easily manage their business finances.</p>
                                            <p class="text-muted">The application's ability to present financial information in an easy-to-understand manner helps users better understand the financial condition of their business. In this way, Proferan is not only a tool for recording financial transactions but also a trustworthy partner for entrepreneurs in managing their finances effectively.</p>
                                        </div>
                                        
                                    </div>
                                </div>
                                <!-- end row -->
                            </div>
                            <div class="tab-pane fade" id="pills-support" role="tabpanel" aria-labelledby="pills-support-tab">
                                
                                <div class="row align-items-center justify-content-center">
                                    <div class="col-lg-4 col-sm-6">
                                        <div>
                                            <img src="{{ asset('assets/landing/images/features-img/img-3.png') }}" alt="" class="img-fluid mx-auto d-block">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 offset-lg-1">
                                        <div>
                                            <div class="feature-icon mb-4">
                                                <i class="pe-7s-headphones h1 text-primary"></i>
                                            </div>
                                            <h5 class="mb-3">Awesome Support for MSMEs</h5>
                                            <p class="text-muted">Proferan provides targeted financial reporting solutions for micro and small businesses, enabling users to carefully track and understand their finances better. With reports tailored to the scale and needs of their business, users can easily monitor cash flow, evaluate performance, and make more informed decisions based on accurate and relevant information. It helps users in managing their finances with efficiency and increases the chances of success of their business.</p>
                                            <p class="text-muted">With Proferan, users can have the right tools to better manage their finances, without having to worry about the complexity or mismatch of financial reports with their business needs.</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- end row -->
                            </div>
                        </div>
                        <!-- end tab-content -->
                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container-fluid -->
        </section>
        <!-- features end -->

        <section class="section bg-light" id="visi_misi">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="title text-center mb-4">
                            <h6 class="text-primary small-title">Our Visi & Misi</h6>
                            <h4>Our Visi & Misi</h4>
                            <hr class="text-muted">
                        </div>
                    </div>
                </div>
                <!-- end row -->
                <div class="row">
                    <div class="col-lg-7">
                        <div class="p-4 mt-4 text-center">
                            <div class="mb-4">
                                <img src="{{ asset('assets/images/visi_misi.png') }}" alt="" style="width: 100% !important;">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        @php
                            $visi_misi = App\Models\VisiMisi::first();
                            $berita = App\Models\Berita::all();
                            $kontak = App\Models\Kontak::first();
                        @endphp
                        <div class="p-4 mt-4">
                            <div class="mb-4">
                                <h3>Visi</h3>
                                <p>
                                    {{ (!empty($visi_misi)) ? $visi_misi->visi : 'No data' }}
                                </p>
                            </div>
                        </div>
                        <div class="p-4 mt-4">
                            <div class="mb-4">
                                <h3>Misi</h3>
                                <p>{{ (!empty($visi_misi)) ? $visi_misi->misi : 'No data' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container-fluid -->
        </section>

        <!-- Information start -->
        <section class="section" id="information">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="title text-center mb-4">
                            <h6 class="text-primary small-title">Information</h6>
                            <h4>Available Information</h4>
                            <p>&nbsp;</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div id="carouselExampleCaptions" class="carousel slide col-12" data-ride="carousel">
                        <ol class="carousel-indicators">
                            @foreach($berita as $key => $loop_berita)
                                <li data-target="#carouselExampleCaptions" data-slide-to="{{ $key }}" class="@if($key == 0) active @endif"></li>
                            @endforeach
                        </ol>
                        <div class="carousel-inner">
                        @forelse ($berita as $key => $loop_berita)
                            <div class="carousel-item @if($key == 0) active @endif">
                                <div class="image-container" onclick="window.open('{{ $loop_berita->link }}')" style="cursor: pointer;">
                                    <div class="shadow-overlay"></div>
                                    <img src="{{ asset('assets/images/berita/'.$loop_berita->gambar) }}" class="d-block w-100" alt="...">
                                </div>
                                <div class="carousel-caption d-none d-md-block bg-dark">
                                    <h5 onclick="window.open('{{ $loop_berita->link }}')" style="cursor: pointer;">{{ $loop_berita->judul }}</h5>
                                    <p>{{ Str::limit($loop_berita->deskripsi, 150,'...') }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="text-center">
                                <p>No data</p>
                            </div>
                        @endforelse
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container-fluid -->
        </section>
        <!-- Information end -->
        
        <!-- Our Team start -->
        <section class="section bg-light" id="our_team">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="title text-center mb-4">
                            <h6 class="text-primary small-title">Our Team</h6>
                            <h4>Our Awesome Proferan Team Creative</h4>
                            <hr class="text-muted">
                        </div>
                    </div>
                </div>
                <!-- end row -->
                <div class="row">
                    <div class="col-lg-6">
                        <div class="testi-box p-4 bg-white mt-4 text-center">
                            <p class="text-muted mb-4">" The designer of this theme delivered a quality product. I am not a front-end developer and I hate when the theme I download has glitches or needs minor tweaks here and there. This worked for my needs just out of the boxes. Also, it is fast and elegant."</p>
                            <div class="testi-img mb-4">
                                <img src="{{ asset('assets/images/andreas.jpeg') }}" alt="" class="rounded-circle img-thumbnail">
                            </div>
                            <p class="text-muted mb-1"> - Accounting</p>
                            <h5 class="font-18">Andreas Kevin</h5>
                            
                            <div class="testi-icon">
                                <i class="mdi mdi-format-quote-open display-2"></i>
                            </div>
                           
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="testi-box p-4 bg-white mt-4 text-center">
                            <p class="text-muted mb-4">"  Extremely well designed and the documentation is very well done. Super happy with the purchase and definitely recommend this! "</p>
                            <div class="testi-img mb-4">
                                <img src="{{ asset('assets/images/feryandi.jpeg') }}" alt="" class="rounded-circle img-thumbnail">
                            </div>
                            <p class="text-muted mb-1"> - Fullstack Developer</p>
                            <h5 class="font-18">Feryandi</h5>
                            
                            <div class="testi-icon">
                                <i class="mdi mdi-format-quote-open display-2"></i>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container-fluid -->
        </section>
        <!-- Our Team end -->

        <!-- contact start -->
        <section class="section" id="contact">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="title text-center mb-5">
                            <h6 class="text-primary small-title">Contact</h6>
                            <h4>Have any Questions ?</h4>
                            <p class="text-muted">let us know your question</p>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row">
                    <div class="col-lg-4">
                        <div class="get-in-touch">
                            <h5>Get in touch</h5>
                            <p class="text-muted mb-5">You can contact us on</p>

                            <div class="mb-3">
                                <div class="get-touch-icon float-left mr-3">
                                    <i class="pe-7s-mail h2 text-primary"></i>
                                </div>
                                <div class="overflow-hidden">
                                    <h5 class="font-16 mb-0">E-mail</h5>
                                    <p class="text-muted">
                                        {{ (!empty($kontak)) ? $kontak->email : 'No data' }}
                                    </p>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="get-touch-icon float-left mr-3">
                                    <i class="pe-7s-phone h2 text-primary"></i>
                                </div>
                                <div class="overflow-hidden">
                                    <h5 class="font-16 mb-0">Phone</h5>
                                    <p class="text-muted">{{ (!empty($kontak)) ? $kontak->phone : 'No data' }}</p>
                                </div>
                            </div>
                            <div class="mb-2">
                                <div class="get-touch-icon float-left mr-3">
                                    <i class="pe-7s-map-marker h2 text-primary"></i>
                                </div>
                                <div class="overflow-hidden">
                                    <h5 class="font-16 mb-0">Address</h5>
                                    <p class="text-muted">{{ (!empty($kontak)) ? $kontak->alamat : 'No data' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="custom-form bg-white">
                            <div id="message"></div>
                            <form method="post" action="mailto:proferan24@gmail.com" name="contact-form" id="contact-form" enctype="text/plain">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input name="name" id="name" type="text" class="form-control" placeholder="Enter your name...">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="email">Email address</label>
                                            <input name="email" id="email" type="email" class="form-control" placeholder="Enter your email...">
                                        </div>
                                    </div>
                                </div>
                                <!-- end row -->

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="subject">Subject</label>
                                            <input name="subject" id="subject" type="text" class="form-control" placeholder="Enter Subject...">
                                        </div>
                                    </div>
                                </div>
                                <!-- end row -->

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="comments">Message</label>
                                            <textarea name="comments" id="comments" rows="4" class="form-control" placeholder="Enter your message..."></textarea>
                                        </div>
                                    </div>
                                </div>
                                <!-- end row -->

                                <div class="row">
                                    <div class="col-lg-12 text-right">
                                        <input type="submit" id="submit" name="send" class="submitBnt btn btn-custom" value="Send Message">
                                        <div id="simple-msg"></div>
                                    </div>
                                </div>
                                <!-- end row -->
                            </form>
                        </div>
                        <!-- end custom-form -->

                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container-fluid -->
        </section>
        <!-- contact end -->

        <!-- footer start -->
        <footer class="footer bg-dark">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="text-center">
                            <div class="footer-logo mb-3">
                                <img src="{{ asset('assets/images/logo-light.png') }}" alt="" height="20">
                            </div>
                            <ul class="list-inline footer-list text-center mt-5">
                                <li class="list-inline-item"><a href="#">Home</a></li>
                                <li class="list-inline-item"><a href="#features">Features</a></li>
                                <li class="list-inline-item"><a href="#visi_misi">Visi & Misi</a></li>
                                <li class="list-inline-item"><a href="#information">Information</a></li>
                                <li class="list-inline-item"><a href="#our_team">Our Team</a></li>
                                <li class="list-inline-item"><a href="#contact">Contact</a></li>
                            </ul>
                            <ul class="list-inline social-links mb-4 mt-5">
                                <li class="list-inline-item"><a href="#"><i class="mdi mdi-facebook"></i></a></li>
                                <li class="list-inline-item"><a href="#"><i class="mdi mdi-twitter"></i></a></li>
                                <li class="list-inline-item"><a href="#"><i class="mdi mdi-instagram"></i></a></li>
                                <li class="list-inline-item"><a href="#"><i class="mdi mdi-google-plus"></i></a></li>
                            </ul>
                            <p class="text-white-50 mb-4">
                                Copyright © 2024 Proferan Pancur Kasih. All rights reserved | Made with &#10084; by Proferan Team
                            </p>
                        </div>
                    </div>
                
                </div>

            </div>
        </footer>
        <!-- footer end -->

        <!-- Back to top -->    
        <a href="#" class="back-to-top" id="back-to-top"> <i class="mdi mdi-chevron-up"> </i> </a>

        
        <!-- javascript -->
        <script src="{{ asset('assets/landing/js/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/landing/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/landing/js/jquery.easing.min.js') }}"></script>
        <script src="{{ asset('assets/landing/js/scrollspy.min.js') }}"></script>
        
        <!-- Magnific Popup -->
        <script src="{{ asset('assets/landing/js/jquery.magnific-popup.min.js') }}"></script>

        <!-- custom js -->
        <script src="{{ asset('assets/landing/js/app.js') }}"></script>
    </body>
</html>
