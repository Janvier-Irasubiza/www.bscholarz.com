<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BScholarz - @yield('title')</title>
    <link rel="stylesheet" href="{{ asset('styles.css') }}">
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('fa-icons/css/all.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Ubuntu">

    <script src="{{ asset('bootstrap/dist/js/jquery.min.js') }}"></script>
    <script src="{{ asset('bootstrap/js/jquery-1.7.1.min.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.js') }}"></script>

    <script type="text/javascript">

    $(window).on('load', function() {
        $('#staticBackdrop').modal('show');
    });

    function getRandomTime(min, max) {
                    return Math.floor(Math.random() * (max - min + 1)) + min;
                }

                function displayRandomModal() {
                    var randomTime = getRandomTime(10000, 10000000); 

                    setTimeout(function () {
                        $('#subscribe').modal('show'); 
                    }, randomTime);
                }

                displayRandomModal();

                function clodeMoodal() {
                    $('#subscribe').modal('hide');
                    displayRandomModal(); 
                }

                $('#subscribe').on('hidden.bs.modal', function () {
                    displayRandomModal(); 
                });
      
      			$('#staticBackdrop').on('show.bs.modal', function () {
                    $('#subscribe').modal('hide');
                });
      	
      			$('#seek').on('show.bs.modal', function () {
                    $('#subscribe').modal('hide'); 
                });
      
      			$('#exampleModal').on('show.bs.modal', function () {
                    $('#subscribe').modal('hide'); 
                });


</script>

    <style>

        body, .modal-content{
            margin: 0px;
            background-color: #F8FAFF
            }

        .modal-xl {
            margin-left: auto;
            margin-right: 70px;
            z-index: 10;
            top: -9px;
            max-width: 85%
        }       

        .carousel-item{
            float:none; 
            transition: 0s !important;
            border-radius: 10px
        }

        .modal-backdrop{
            z-index: 0;
        }

        .w-mdal {
            max-width: 40%;
        }
      
      	.abt-list {
            border-bottom: none;
        }

        .abt-list.active,
        .abt-list:hover {
            border-bottom: 3px solid #1E4682 !important;
            text-transform: uppercase;
            font-weight: 600;
            transition: all 0.1s ease;
        }

        .abt-sect-desc {
            overflow-y: scroll;
            max-height: 80vh;
            scroll-behavior: smooth;
        }

        .abt-sect-desc::-webkit-scrollbar {
            display: none;
        }

        @media (max-width: 1290px) { 
            .modal-xl {
                margin-left: auto;
                margin-right: 70px;
                width: 84%;
            }

            .w-mdal {
            max-width: 100%;
        }

            .saying-pp {
            }

            .saying-desc {
            }

            .motiv-saying {
                position: relative;
                left: 30px;
                margin: 25px 0px
            }

            .carousel-caption {
                height: 63%;
                /* border: 1px solid red */
            }
        }

        @media (max-width: 1280px) { 

            .carousel-caption {
                height: 64%;
            }
        }


        @media only screen and (max-width: 1250px){
            .modal-xl {
                margin-left: auto;
                margin-right: 65px;
                max-width: 85.40%;
            }

            .carousel-caption {
                height: 65%;
            }
        }


        @media (max-width: 1240px){

            .carousel-caption {
                height: 66%;
            }
        }


        @media (max-width: 1220px){

            .carousel-caption {
                height: 68%;
            }
            }


         @media (max-width: 1200px){
            .modal-xl {
                margin-left: auto;
                margin-right: 65px;
                max-width: 85.40%;
            }

            .carousel-caption {
                height: 70%;
                /* border: 1px solid red */
            }
        }

        @media (max-width: 1150px){
            .modal-xl {
                margin-left: auto;
                margin-right: 0px;
                max-width: 85%;
            }

            .carousel-caption {
                height: 80%;
                /* border: 1px solid red */
            }

        }

        @media (max-width: 995px){
            .modal-xl {
                margin-left: auto;
                margin-right: 70px;
                max-width: 80.40%;
            }

            .carousel-caption {
                height: 80%;
            }
        }

        @media (max-width: 900px){
            .modal-xl {
                margin-left: auto;
                margin-right: 57px;
                max-width: 78%;
            }

            .carousel-caption {
                height: 83%;
            }
        }

        @media (max-width: 540px) {

            .modal-xl {
            margin-left: auto;
            margin-right: 70px;
            z-index: 10;
            top: -9px;
            margin-right: 53px;
            z-index: 10;
            top: 11px;
            } 
        }

        @media (max-width: 492px) {

            .modal-xl {
            margin-left: auto;
            margin-right: 70px;
            z-index: 10;
            top: -9px;
            margin-right: 53px;
            z-index: 10;
            top: 11px;
        } 


        }

        @media (max-width: 350px){
            .modal-xl {
                margin-left: auto;
                margin-right: 70px;
                max-width: 73%;
            }
        }

    </style>

</head>
<body>

<nav>
    <div class="container-fluid">

        <div class="nav-wrapper">

        <div class="sidebar-drawer" style="z-index: 5 !important">
            <i style="font-size: 30px" class="fa-solid fa-suitcase-rolling"></i>
        </div>

        <div class="d-flex gap-2">
        <button class="nav-drawer" href="">
                <i class="fa-solid fa-bars dft-btn"></i>
            </button>

            <button class="aft-btn" href="">
                <i class="fa-solid fa-arrow-up"></i>
            </button>

            <div class="bbg-logo col-lg-12 d-flex align-items-center" style="">
                <img src="{{ asset('images') }}/{{ 'BScholarz_Logo.png' }}" class="img-responsive" alt="Logo">
            </div>
        </div>
            
        <div style="padding: 0px;" class="col-lg-11 nav-container container-fluid ">
            <div class="d-flex align-items-center" style="margin-left: 10px; width: 100%;">
                
            <div style="padding: 0px" class="col-lg-9 nav-links-contianer">
            <ul style="margin: 0px;">

                    <li class="navigator"><a href="{{ route('home') }}">Home</a></li>
                    <li class="navigator"><a href="{{ route('BeScholar') }}">Be A Scholar</a></li>
                    <li class="navigator"><a href="{{ route('get-employed') }}">Get Employed</a></li>
                    <li class="navigator"><a href="{{ route('felowships-trainings') }}">Fellowships & Trainings</a></li>
                    <li class="navigator"><a href="{{ route('about-us') }}">About Us</a></li>
                <li class="navigator"><a href="{{ route('contact-us') }}">Contact Us</a></li>
                </ul>
            </div>

                <div class="col-lg-3 nav-section-right" style="padding: 0px;">
                    <div class="d-flex gap-2 justify-content-end" style="padding: 0px;">
                    <div class="col-lg-9 d-flex align-items-center" style=""> 
                    <button class="search-btn text-left w-full" style="padding-left: 6px"  data-toggle="modal" data-target="#exampleModal">
                        Search
                    </button>

                        <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="">
                    <div class="modal-dialog modal-xl" role="document" style="" >
                        <div class="modal-content" style="">
                        <div style="" class="modal-header">

                            <form action="{{ route('search') }}" class="w-full">
                                <div class="d-flex">
                                <input id="searchBox" class="input-box" type="text" placeholder="Type here....." name="search_keyword" required autofocus/>
                            <button class="search-sub-btn">
                                <span class="fa-solid fa-magnifying-glass"></span>
                            </button>
                                </div>
                            </form> 

                        </div>

                        @php $sugs = DB::table('search_suggestions') -> where('count', '>', 2) -> get(); @endphp

                        @if($sugs)

                        <div class="modal-body">
                            <h5>Suggestions:</h5>
                        <div style="padding: 0px;" class="">
                            <ul style="margin: 0px; padding: 0px">


                                @foreach($sugs as $sug)

                                <li class="sugest-navigator mb-1"><a href="{{ route('search', ['search_keyword' => $sug -> keyword]) }}"> <small>#</small> {{ $sug -> keyword }}</a></li>

                                @endforeach

                            </ul>
                        </div>
                        </div>

                        @endif

                        </div>
                    </div>
                    </div>

                    <!-- End of modal -->

                    </div>

                        <a href="{{ route('login') }}">
                            <div class="user-profile">

                            @if(Auth::guard('client') -> user())

                            <img src="{{ asset('profile_pictures') }}/{{ Auth::guard('client') -> user() -> profile_picture }}" alt="">

                            @else
                                
                            <img src="{{ asset('images/profile.png') }}" alt="User-Account">

                            @endif

                            </div>
                        </a>
                    </div>

                </div>
            </div>
        </div>

        </div>
    </div>
  
  @if(Session::has('failed_req'))
  
   <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" id="toast" style="position: absolute; top: 15px; right: 18px; z-index: 10">
          <div class="toast-header justify-content-between">
            <div class="d-flex gap-3 align-items-center">
              <span class="fa-solid fa-square-xmark" style="color: #CC0000; border-radius: 5px; font-size: 25px"></span>
            <span><strong class="mr-auto">Failed to send you request!</strong></span>
            </div>
            <button type="button" class="ml-2 mb-1 close" style="border: none; font-size: 20px; background: none" data-dismiss="toast" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="toast-body">
            {{ Session::get('failed_req') }} <a class="apply-btn ml-1" style="text-decoration: none; color: ghostwhite"> retry </a>
          </div>
		</div>
  
   @php
  	session()->forget('failed_req');
	session()->flush();
  @endphp
  
  @endif
  
  @if(Session::has('exist'))
  
   <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" id="toast" style="position: absolute; top: 15px; right: 18px; z-index: 10">
          <div class="toast-header justify-content-between">
            <div class="d-flex gap-3 align-items-center">
              <span class="fa-solid fa-square-xmark" style="color: #CC0000; border-radius: 5px; font-size: 25px"></span>
            <span><strong class="mr-auto">Request already exist!</strong></span>
            </div>
            <button type="button" class="ml-2 mb-1 close" style="border: none; font-size: 20px; background: none" data-dismiss="toast" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="toast-body">
            {{ Session::get('exist') }}
          </div>
		</div>
  
  @php
  	session()->forget('exist');
	session()->flush();
  @endphp
  
  @endif
  
</nav>

<div style="padding: 0px; z-index: 10" class="nav-links-drawer">
            <ul style="margin: 0px; padding: 3px 0px">
                <li class="small-navigator"><a href="{{ route('home') }}">Home</a></li>
                <li class="small-navigator"><a href="{{ route('BeScholar') }}">Be A Scholar</a></li>
                <li class="small-navigator"><a href="{{ route('get-employed') }}">Get Employed</a></li>
                <li class="small-navigator"><a href="{{ route('felowships-trainings') }}">Fellowship & Trainings</a></li>
                <li class="small-navigator"><a href="{{ route('about-us') }}">About Us</a></li>
                <li class="small-navigator"><a href="{{ route('contact-us') }}">Contact Us</a></li>
             </ul>
            </div>

            <div>
                @yield('content')
            </div>
  
        

            <footer class="">
    <div class="footer-title-content">
        <h4 class="footer-title" style="color: ghostwhite">BScholarz</h4><br>
        <p class="mb-4" style="color: ghostwhite">BSCHOLARZ is a prominent education consultancy in Rwanda, 
            aiding local students in securing scholarships at home and abroad. 
            They assist international students in finding top universities and scholarships within Rwanda 
            while providing efficient online services for visa applications and IT-related support.</p>

            <div class="social-media mb-4">
                <small style="color: ghostwhite"><strong>Reach Out To Us</strong></small>
                <ul class="mt-2">
                    <li class="social-media-icon"><a class="sm-link" data-toggle="tooltip" data-bs-placement="top" title="Join Our Whatsapp Community" target="blanc" href="https://whatsapp.com/channel/0029Va9WKPW7YSd1Ur3bYr12"><span class="fa-brands fa-whatsapp" style="color: ghostwhite"></span></a> </li>
                    <li class="social-media-icon"><a class="sm-link" data-toggle="tooltip" data-bs-placement="top" title="Connect With Us On Telegram" target="blanc" href="https://t.me/+AIWsTcgPUUwxMjc8"><span class="fa-brands fa-telegram" style="color: ghostwhite"></span></a></li>
                    <li class="social-media-icon"><a class="sm-link" data-toggle="tooltip" data-bs-placement="top" title="Connect With Us On Twitter" target="blanc" href="https://twitter.com/Bscholarz"><span class="fa-brands fa-twitter" style="color: ghostwhite"></span></a></li>
                    <li class="social-media-icon"><a class="sm-link" data-toggle="tooltip" data-bs-placement="top" title="Connect With Us On Instagram" target="blanc" href="https://www.instagram.com/bscholarz/"><span class="fa-brands fa-instagram" style="color: ghostwhite"></span></a></li>
                    <li class="social-media-icon"><a class="sm-link" data-toggle="tooltip" data-bs-placement="top" title="Connect With Us On LinkedIn" target="blanc" href="https://linkedin.com/in/bscholar-z-414307299/"><span class="fa-brands fa-linkedin" style="color: ghostwhite"></span></a></li>
                    <li class="social-media-icon"><a class="sm-link" data-toggle="tooltip" data-bs-placement="top" title="Connect With Us Via Google Mail" target="blanc" href="https://mail.google.com/mail/?view=cm&fs=1&to=info@bscholarz.com" style="color: ghostwhite"><span class="fa-brands fa-google"></span></a></li>
                    <li class="social-media-icon"><a class="sm-link" data-toggle="tooltip" data-bs-placement="top" title="Visit Our Youtube Channel" target="blanc" href="https://www.youtube.com/channel/UCx1ohaAVRC0UPaVcEDK0qwA" style="color: ghostwhite"><span class="fa-brands fa-youtube"></span></a></li>
                    <li class="social-media-icon"><a class="sm-link" data-toggle="tooltip" data-bs-placement="top" title="Connect With Us On Facebook" target="blanc" href="https://www.facebook.com/BSCHOLARZ"><span class="fa-brands fa-facebook" style="color: ghostwhite"></span></a></li> 
                </ul>   
            </div>

            <div class="footer-nav d-flex justify-content-center">
            <ul style="margin: 0px; padding: 0px; color: ghostwhite">
                <li class="footer-navigator" style="color: ghostwhite"><a href="#" data-toggle="modal" data-target="#seek" style="color: ghostwhite">Seek Consultancy</a></li>
            </ul>


                        @if(Session::has('scs') || Session::has('failed'))

                    <!-- Modal -->
                    <div class="modal fade" id="staticBackdrop" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog w-mdal modal-dialog-centered d-flex align-items-center" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <div>
                                <h5 class="modal-title" style="text-align: left" id="staticBackdropLabel">Seek assistance </h5>
                                @if(Session::has('scs'))
                                <small style="font-size: 14px;" class="text-muted mb-0">Your request has been successfully received</small>
                                @else
                                <small style="font-size: 14px;" class="text-muted mb-0">Failed to submit your request</small>
                                @endif
                            </div>    

                        </div>
                        
                        <form action="{{ route('seek-assistance') }}" method="post" class="space-y-6" >   @csrf                     

                        <div class="modal-body">

                        <div class="alert alert-info alert-dismissible fade show px-2" role="alert">

                        @if(Session::has('scs'))

                            <p class="mb-0">Dear <strong>{{ Session::get('scs') }}</strong>, &nbsp; Your request has been successfully received, we'll get back to you soon.  
                        
                        
                        </p>

                        @else

                        <p class="mb-0">Dear <strong>{{ Session::get('failed') }}</strong>, &nbsp; There was a problem submitting your request, please   
                        
                            <a id="report" type="button" class="underline text-sm hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                                {{ __('Try again') }}
                             </a>
                        
                        </p>

                        @endif

                        </div>
                    
                        <div class="form-div" style="display: none">
                        <div>
                            <x-input-label for="names" style="text-align: left" class="text-left w-full" :value="__('Names')" />
                            <p style="font-size: 14px; text-align: left" class="text-muted mb-0 text-left w-full">Type your fullname</p>
                            <x-text-input id="names" class="block mt-1 w-full" style="border-radius: 4px;" type="text" name="names" :value="old('names')" placeholder="Fullname" required autofocus autocomplete="names" />
                            <x-input-error :messages="$errors->get('names')" class="mt-2" />
                        </div>

                        <div class="flex-section gap-3">
                        <div class="mt-3 w-full">
                            <x-input-label for="email" style="text-align: left" class="text-left w-full" :value="__('Email')" />
                            <p style="font-size: 14px; text-align: left" class="text-muted mb-0 text-left w-full">Your Email address</p>
                            <x-text-input id="email" class="block mt-1 w-full" style="border-radius: 4px;" type="email" name="email" :value="old('email')" placeholder="username@example.com" required  autocomplete="email" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div class="mt-3 w-full">
                            <x-input-label for="phone" style="text-align: left" class="text-left w-full" :value="__('Phone number')" />
                            <p style="font-size: 14px; text-align: left" class="text-muted mb-0 text-left w-full">Provide your active phone number</p>
                            <x-text-input id="phone" class="block mt-1 w-full" style="border-radius: 4px;" type="text" name="phone" :value="old('phone')" placeholder="your phone number" required  autocomplete="phone" />
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>

                        </div>

                        <div class="mt-3 w-full">
                            <x-input-label for="issue" style="text-align: left" class="text-left w-full" :value="__('Issue')" />
                            <p style="font-size: 14px; text-align: left" class="text-muted mb-0 text-left w-full">Tell us about your issue</p>
                            <x-text-input id="issue" class="block mt-1 mb-0 w-full" style="border-radius: 4px; border-bottom: 1px solid #bfbfbf; border-bottom-left-radius: 0px; border-bottom-right-radius: 0px;" type="text" name="issue" :value="old('phone')" placeholder="Type your issue here..." required autocomplete="issue" />
                            <textarea placeholder="Describe your issue here..." id="desc" name="desc" class="block w-full" style="border: 2px solid #000; border-top: 0px; border-radius: 6px; border-top-right-radius: 0px; border-top-left-radius: 0px; padding: 6px; font-size: 14px" required ></textarea>
                            <x-input-error :messages="$errors->get('issue')" class="mt-2" />
                            <x-input-error :messages="$errors->get('desc')" class="mt-2" />
                        </div>


                        <div class="mt-4 text-right d-flex justify-content-end">
                            <!-- <a class="underline text-sm hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="">
                                {{ __('Or see tips & tricks') }}
                            </a> -->
                            <button type="submit" style="padding: 5px 30px; font-size: 13px; font-weight: 600; color: ghostwhite; text-transform: uppercase" class="btn apply-btn">Submit</button>
                        </div>

                        </div>

                        <div class="mt-4 text-right report-another" style="display: flex; justify-content: space-between">
                        
                        @if(Session::has('scs'))
                        <a id="report" type="button" class="underline text-sm hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                                {{ __('Report another issue') }}
                             </a>
                             @endif

                            <button type="button" class="close btn btn-danger" id="modal_dismisser" data-dismiss="modal" aria-label="Close">
                                Cancel
                            </button>
                            </div>

                        </div>
                        </form>
                        </div>
                    </div>
                    </div>
                    <!-- </> modal -->

                    @endif


                    <!-- Modal -->
                    <div class="modal fade" id="seek"  data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog w-mdal modal-dialog-centered d-flex align-items-center" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <div>
                                <h5 class="modal-title" style="text-align: left" id="staticBackdropLabel">Seek assistance </h5>
                                <small style="font-size: 14px;" class="text-muted mb-0">Tell us about your issue</small>
                            </div>                            

                            <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close">
                                <span style="" aria-hidden="true" class="fa fa-times"></span>
                            </button>

                        </div>
                        
                        <form action="{{ route('seek-assistance') }}" method="post" class="space-y-6" >   @csrf                     

                        <div class="modal-body">
                        
                        <div>
                            <x-input-label for="names" style="text-align: left" class="text-left w-full" :value="__('Names')" />
                            <p style="font-size: 14px; text-align: left" class="text-muted mb-0 text-left w-full">Type your fullname</p>
                            <x-text-input id="names" class="block mt-1 w-full" style="border-radius: 4px;" type="text" name="names" :value="old('names')" placeholder="Fullname" required autofocus autocomplete="names" />
                            <x-input-error :messages="$errors->get('names')" class="mt-2" />
                        </div>

                        <div class="flex-section gap-3">
                        <div class="mt-3 w-full">
                            <x-input-label for="email" style="text-align: left" class="text-left w-full" :value="__('Email')" />
                            <p style="font-size: 14px; text-align: left" class="text-muted mb-0 text-left w-full">Your Email address</p>
                            <x-text-input id="email" class="block mt-1 w-full" style="border-radius: 4px;" type="email" name="email" :value="old('email')" placeholder="username@example.com" required  autocomplete="email" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div class="mt-3 w-full">
                            <x-input-label for="phone" style="text-align: left" class="text-left w-full" :value="__('Phone number')" />
                            <p style="font-size: 14px; text-align: left" class="text-muted mb-0 text-left w-full">Provide your active phone number</p>
                            <x-text-input id="email" class="block mt-1 w-full" style="border-radius: 4px;" type="text" name="phone" :value="old('phone')" placeholder="your phone number" required  autocomplete="phone" />
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>

                        </div>

                        <div class="mt-3 w-full">
                            <x-input-label for="issue" style="text-align: left" class="text-left w-full" :value="__('Issue')" />
                            <p style="font-size: 14px; text-align: left" class="text-muted mb-0 text-left w-full">Tell us about your issue</p>
                            <x-text-input id="email" class="block mt-1 mb-0 w-full" style="border-radius: 4px; border-bottom: 1px solid #bfbfbf; border-bottom-left-radius: 0px; border-bottom-right-radius: 0px;" type="text" name="issue" :value="old('phone')" placeholder="Type your issue here..." required autocomplete="issue" />
                            <textarea placeholder="Describe your issue here..." id="desc" name="desc" class="block w-full" style="border: 2px solid #000; border-top: 0px; border-radius: 6px; border-top-right-radius: 0px; border-top-left-radius: 0px; padding: 6px; font-size: 14px" required ></textarea>
                            <x-input-error :messages="$errors->get('issue')" class="mt-2" />
                            <x-input-error :messages="$errors->get('desc')" class="mt-2" />
                        </div>


                        <div class="mt-4 text-right d-flex justify-content-end">
                            <!-- <a class="underline text-sm hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="">
                                {{ __('Or see tips & tricks') }}
                            </a> -->
                            <button type="submit" style="padding: 5px 30px; font-size: 13px; font-weight: 600; color: ghostwhite; text-transform: uppercase" class="btn apply-btn">Submit</button>
                        </div>
                        </div>
                        </form>
                        </div>
                    </div>
                    </div>
                    <!-- </> modal -->

            </div>
    </div>

    <br>

<div class="d-flex justify-content-center w-full" style="">
                <div style="border-top: 1px solid #a8a3a3; padding: 20px 30px" class="d-flex container-fluid justify-content-between">
                    <div class="col-lg-6" style="font-size: 13px; color: ghostwhite">
                        &copy; 2023 <strong>BScholarz</strong> 
                    </div> 
                    
                    <div style="" class="col-lg-6">
                        <p style="margin-bottom: 0px; width: 100%; text-align: right; font-size: 13px; color: ghostwhite"><i class="fa-solid fa-code"></i> &nbsp;<strong>RB-A</strong></p> 
                    </div> 

                </div>
            </div>

</footer>

@if(!isset($_COOKIE['client_email']))

<!-- Modal -->
<div class="modal fade" id="subscribe" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Don't miss any opportunity!</h5>
        <button type="button" onclick="clodeMoodal()" id="closeModal" class="close btn btn-danger" style="border: 3px solid; background: none" data-dismiss="modal" aria-label="Close">
            <span style="color: #000" aria-hidden="true" class="fa fa-times"></span>
        </button>
      </div>
      <div class="modal-body pb-4">
        
      <form action="{{ route('subscribe') }}" method="post"> @csrf

      <div class="mb-3">
      <label for="email" style="text-align: left; font-size: 14px" class="text-left w-full"> Don't miss out on exclusive offers, jobs, scholarships and other opportunities. Get notified of new opportunities.</label>
      </div>

      <x-input-label for="email" style="text-align: left" class="text-left w-full" :value="__('Email')" />
      <div class="d-flex mb-4 gap-2">
            <input style = "padding: 6px 10px; border: 2px solid #4d4d4d; color: #808080; border-radius: 6px" id="email" class="block mt-2 w-full" type="email" name="email" value="{{ old('email') }}" placeholder="username@example.com" required autocomplete="email" />

        <div class="col-lg-3 mt-2 d-flex align-items-center">
            <button type="submit" style="text-transform: uppercase; text-decoration: none; color: ghostwhite; font-weight: 600; font-size: 11px; padding: 9px 8px; diplay: block; border: none" class="apply-btn w-full text-center" href="{{ route('login') }}"> Subscribe</button>
        </div>
            
        </div>

      <x-input-error :messages="$errors->get('email')" class="mt-2 text-left" />

      <div class="d-flex justify-content-start w-full sm:max-w-md mt-2">
                    <div style="padding: 0px 0px 0px 0px" class="row container">
                     <p style="margin: 0px; text-align: left; font-size: 13px" class="text-sm">Don't have Account yet? &nbsp; <a class="text-sm hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('register') }}" style="font-weight: bold">
                    {{ __('Create Account') }}
                </a></p>
                    </div>
                </div>

      </form>


      </div>
    </div>
  </div>
</div>
<!-- </> modal -->

@endif


<script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>  
<script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>  
<script src="{{ asset('bootstrap/dist/js/jquery.min.js') }}"></script>
<script src="{{ asset('bootstrap/dist/js/popper.js') }}"></script>
<script src="{{ asset('bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('bootstrap/dist/js/main.js') }}"></script>

<script type="text/javascript">
  
  	$('#toast').toast({delay:30000});
  	$('#toast').toast('show');

    $('#exampleModal').on('shown.bs.modal', function () {
        $('#searchBox').trigger('focus');
    });

    $('.carousel').carousel({
        interval: 6000  
    });

    $('.nav-drawer').on('click', function () {
        $('.nav-links-drawer').toggleClass('show');
        $('.aft-btn').toggleClass('show');
        $('.nav-drawer').toggleClass('hide');
    });
    
    $('.aft-btn').on('click', function () {
        $('.nav-links-drawer').toggleClass('show');
        $('.aft-btn').toggleClass('hide');
        $('.nav-drawer').toggleClass('show');
    });
    
    $('.sidebar-drawer').on('click', function () {
        $('.sidebar').toggleClass('show')
        $('.sidebar-drawer').toggleClass('show')
    });

    $('.section-right').on('click', function () {
        $('.sidebar-drawer').toggleClass('left')
        $('.sidebar').toggleClass('hide')
    });


    $('.sidebar-drawer-cst').on('click', function () {
                $('.sidebar-collapse').toggleClass('show')
                $('.sidebar-drawer-cst').toggleClass('show')
                $('.section-right-ext').toggleClass('min')
            });


            const report = document.getElementById('report');
            report.addEventListener('click', function () {
                document.querySelector('.form-div').style.display = 'Block';
                document.querySelector('.alert').style.display = 'none';
                document.querySelector('.report-another').style.display = 'none';
            });

            document.querySelector('#modal_dismisser').addEventListener('click', function() {
                $('#staticBackdrop').modal('hide');
            });


            const tooltips = document.querySelectorAll('.sm-link')
                tooltips.forEach(t => {
                    new bootstrap.Tooltip(t)
                });

               
                                

</script>

    </body>
    </html>