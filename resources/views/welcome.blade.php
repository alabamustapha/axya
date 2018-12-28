<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>
    <link rel="icon" href="images/favicon.png" type="image/png" >

    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/all.css')}}">
    <link rel="stylesheet" href="{{asset('css/custom/override.css')}}">

    <!-- MAIN STYLE -->
    <link href="{{ asset('css/custom/style.css') }}" rel="stylesheet">

    <!-- fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
    
    @yield('styles')

    <script>
        @auth
          window.user = @json(auth()->user());
        @endauth

        window.appUrl = @json(config('app.url'));
    </script>
</head>

<body>    
    <div id="app">
        <div id="wrapper">
            <!-- HEADER  -->
            <div id="header">
                <div class="trans-box">
                    <nav class="navbar navbar-expand-lg main-nav">
                        <div class="container-fluid">
                            <a class="navbar-brand" href="#"><img src="images/axya-logo.png"  class="img-fluid" alt="axya logo"></a>
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                        
                            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                <ul class="navbar-nav ml-auto">
                                    <li class="nav-item active">
                                        <a class="nav-link" href="{{route('home')}}">Home
                                            <span class="sr-only">(current)</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">About</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">FAQs</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Contact Us</a>
                                    </li>
                                    <li class="nav-item dropdown">

                                        @include('layouts.partials.dynamic-breadcrumb')

                                    </li>
                                    @guest
                                        <li class="nav-item">
                                            <a class="nav-link sign-in" href="#" data-toggle="modal" data-target="#sign-in-up-modal">Sign in</a>
                                        </li>
                                    @else
                                        <!-- Notifications Section -->
                                        <li class="nav-item">
                                            <a id="navbarDropdown" class="nav-link {{auth()->user()->notifications->count() ? 'text-danger':'text-secondary'}}" role="button" 
                                                href="{{ route('notifications.display', auth()->user()) }}" 
                                                title="{{ auth()->user()->notifications->count() }} notifications"
                                            >
                                                <span style="max-width: 30px;">
                                                    <i class="fa fa-bell mr-0" style="font-size: 120%;"></i>

                                                    <sup style="font-size: 50%;" class="p-1 ml-0 bg-light rounded text-danger text-bold">{{ auth()->user()->notifications->count() }}</sup>
                                                </span>
                                            </a>
                                        </li>
                                        <li class="nav-item dropdown">

                                            @include('layouts.partials.profile-dropdown')

                                        </li>
                                    @endguest
                                </ul>                               
                            </div>
                        </div>
                    </nav>
                    <div class="intro"> 
                        <div class="container">
                            <div class="row">
                                @include('layouts.partials.notifications')
                            </div>

                            <div class="intro-content">
                                <div class="intro-text">
                                   <h1>Premium Healthcare Platform</h1> 
                                </div>

                                <div class="search-area">
                                    <div class="search-box">
                                        <input 
                                            v-model="search"
                                            @keyup="searchForQuery"
                                            type="search"
                                            name="search" id="search"
                                            aria-label="Search" 
                                            placeholder="search doctors, illness, topics, cities etc">
                                    </div>
                                   
                                    <button @click="searchForQuery" type="submit" class="search-icon">
                                        <i class="fa fa-search fa-lg"></i>
                                    </button>                                                
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            @guest
                <!-- SIGN IN / SIGN UP POP UP -->
                @include('auth.partials.registration-login-modal')
            @endguest

            <!-- PAGE CONTENT -->
            <main>
                
                <!-- start section -->
                <section id="dos" class="page-content pc-home ">
        
                    <!-- page option section -->
                    <div class="page-content-body opt">
                        <div class="page-dos">
                            <searches></searches>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="page-dos-head">
                                        <div class="dos-icon">
                                            <img src="images/chat-icon.png" class="img-fluid" alt="">
                                            <!-- <i class="far fa-comments fa-2x"></i> -->
                                        </div>
                                        <div class="dos-title">
                                            <span>Chat with Doctor</span>
                                        </div>
                                    </div>
                                    <div class="page-dos-body">
                                        On this platform are top notch specialists and professionals. Search through, make your pick, book an appointment and start messaging. You must book appointments with doctors to chat expressly. 
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="page-dos-head">
                                        <div class="dos-icon">
                                            <img src="images/calender-icon.png" class="img-fluid" alt="">
                                            <!-- <i class="fa fa-calendar-alt fa-2x"></i> -->
                                        </div>
                                        <div class="dos-title">
                                            <span>Booking Appointments</span>
                                        </div>
                                    </div>
                                    <div class="page-dos-body">
                                        It is easy and intuitive. Search for doctors by name, location, specialty or suggestive keywords. From the displayed list, check their profiles for available schedule and book an appointment.
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </section>
                <!-- end section -->
        
                <!-- start section -->
                <section id="doc-rating">
        
                    <!-- Doctors rating section -->
                    <div class="page-content p-0">
                        <div class="doc-ratings ">
                            @foreach ($doctors as $i => $doctor)
                                <div class="d-r {{(($i % 2) == 0) ? 'bg-darker':'bg-theme-blue'}}">
                                    <div class="img-side">
                                        <img src="{{$doctor->dummyAvatar()}}" class="img-fluid rounded-circle" alt="">
                                    </div>
                                    <div class="info-side">
                                        <div class="doc" >
                                            <span class="d-block h2">
                                                <a class="text-white" href="{{route('doctors.show', $doctor)}}">{{$doctor->name}}</a>
                                            </span>
                                            <span class="occupation">
                                                <a class="text-white" href="{{route('specialties.show', $doctor->specialty)}}">{{$doctor->specialty->name}}</a>
                                            </span>
                                        </div>
                                        <span class="ratings">
                                            <span>
                                              @for($i=1; $i <= $doctor->rating_digit; $i++)
                                                <i class="fas fa-star pr-0 mr-0"></i>
                                              @endfor

                                              @for($i=1; $i <= (5 - $doctor->rating_digit); $i++)
                                                <i class="fas fa-star pr-0 mr-0 text-muted"></i>
                                              @endfor
                                            </span>

                                            <br>
                                            {{$doctor->rating}}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>
                <!-- end section -->        
                
                <!-- start section -->
                <section id="about" class="page-content p-0 mt-4">
                    <div class="bg-theme-gradient">
                            <div class="container">
                                <div class="page-content-intro">
                                    <h2 class="text-center">ABOUT</h2>
                                </div>
        
                                <div class="page-content-body ">
                                    <div class="abt">
                                         Axya allows users to search for doctors and book appointments seamlessly. Providing an environment of trust and comfort and also guaranteeing clients confidentiality.
                                    </div>
                                </div>
        
                                <div class="about-quote">
                                    <span>I...really enjoy the interpersonal relationship it gives you with the doctor, also flexibility is just amazing.</span>
                                    <div class="quote-author">
                                        <div class="author">
                                            <div class="line"></div>
                                            John Doe
                                        </div>
                                    </div>
                                </div>
        
                               
        
                            </div>
                    </div>
                </section>
        
                <!-- start section -->
                <section id="guaranty" class="page-content bg-white">
                    <div class="container">
                        <div class="guaranty-sec">
                            <div class="page-content-intro">
                                <h2 class="text-darker text-center">Guaranty</h2>
                            </div>
        
                            <div class="page-content-body">
                                <div class="row">
                                    <div class="col-lg-7 ">
                                        <div class="guaranty-msg text-darker d-flex align-items-center">
                                            <span> 
                                             We guaranty safe data and secure transactions with Multi level security checks and stringent data privacy policy.
                                                
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-5 ">
                                        <div class="g-img ">
                                            <svg  viewBox="0 0 349 312" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path opacity="0.4" d="M21.8439 164.668C-2.15613 143.868 9.84388 160.168 106.844 105.668C203.844 51.1677 179.997 133.92 226.344 128.168C272.691 122.415 416.396 219.506 309.344 259.668C202.291 299.829 35.8439 292.168 7.34388 259.668C-21.1561 227.168 53.8439 237.668 84.3439 211.168C114.844 184.668 51.8439 190.668 21.8439 164.668Z"
                                                    fill="#52A7E8" stroke="url(#paint0_linear)" />
                                                <path d="M313.041 53.6859C311.902 52.5464 310.336 51.8999 308.732 51.8999C307.124 51.8999 305.558 52.5464 304.417 53.6859C303.285 54.8188 302.638 56.3855 302.638 57.9942C302.638 59.5969 303.285 61.1697 304.417 62.3031C305.557 63.4365 307.123 64.0886 308.732 64.0886C310.335 64.0886 311.902 63.4372 313.041 62.3031C314.175 61.1697 314.821 59.5975 314.821 57.9942C314.821 56.3855 314.175 54.8188 313.041 53.6859Z"
                                                    fill="#5A5A5C" />
                                                <path d="M173.075 197.21C171.936 196.07 170.369 195.424 168.766 195.424C167.157 195.424 165.59 196.07 164.451 197.21C163.318 198.342 162.671 199.909 162.671 201.518C162.671 203.121 163.318 204.693 164.451 205.827C165.59 206.96 167.156 207.612 168.766 207.612C170.368 207.612 171.935 206.961 173.075 205.827C174.208 204.693 174.854 203.121 174.854 201.518C174.854 199.909 174.209 198.342 173.075 197.21Z"
                                                    fill="#5A5A5C" />
                                                <path d="M327.802 73.9251C326.139 70.9989 322.417 69.9764 319.492 71.64C316.566 73.3035 315.543 77.0244 317.208 79.95C335.31 111.783 329.845 152.123 303.917 178.05L299.296 182.671C298.18 179.742 296.45 176.994 294.094 174.638L231.477 112.022C235.572 110.007 239.356 107.319 242.677 103.998L254.687 91.9876C257.066 89.608 257.066 85.7488 254.687 83.3692C252.307 80.9896 248.449 80.9896 246.068 83.3692L234.058 95.3794C228.416 101.021 220.915 104.128 212.937 104.128H188.929C187.313 104.128 185.764 104.77 184.62 105.913L166.241 124.292C160.783 129.75 151.903 129.75 146.445 124.292C140.987 118.834 140.987 109.954 146.445 104.496L188.405 62.5377C214.046 36.8952 254.078 31.2561 285.75 48.8243C288.694 50.4556 292.404 49.3947 294.036 46.4508C295.669 43.5075 294.606 39.7977 291.663 38.1652C274.193 28.4767 253.611 24.5993 233.704 27.2506C215.074 29.7314 198.022 37.532 184.044 49.9096C166.872 34.6868 145.012 26.3622 121.868 26.3622C96.7948 26.3622 73.2229 36.1262 55.4932 53.8553C37.7634 71.5845 28 95.1582 28 120.231C28 145.304 37.764 168.876 55.4932 186.606L57.7899 188.903C58.1897 189.302 58.6333 189.628 59.1019 189.893C59.5096 195.166 61.7185 200.324 65.7423 204.347C70.2205 208.824 76.0998 211.062 81.9809 211.062C82.2862 211.062 82.5921 211.052 82.8974 211.04C82.8852 211.348 82.8748 211.657 82.8748 211.967C82.8748 218.101 85.2636 223.868 89.6011 228.205C94.0794 232.683 99.9587 234.921 105.84 234.921C106.145 234.921 106.451 234.911 106.756 234.899C106.744 235.207 106.734 235.515 106.734 235.826C106.734 241.96 109.122 247.727 113.461 252.064C117.938 256.541 123.819 258.78 129.699 258.78C130.008 258.78 130.317 258.77 130.626 258.758C130.379 264.943 132.607 271.211 137.319 275.924C141.658 280.262 147.425 282.651 153.558 282.651C159.693 282.651 165.46 280.262 169.797 275.924L178.314 267.407L189.818 278.91C194.156 283.248 199.923 285.637 206.057 285.637C212.191 285.637 217.958 283.248 222.296 278.91C227.065 274.141 229.292 267.779 228.982 261.521C229.364 261.539 229.748 261.55 230.132 261.55C236.013 261.55 241.894 259.312 246.371 254.835C251.081 250.125 253.31 243.862 253.065 237.679C253.373 237.691 253.681 237.701 253.992 237.701C260.126 237.701 265.893 235.313 270.23 230.975C274.94 226.265 277.169 220.002 276.924 213.819C277.232 213.832 277.54 213.842 277.85 213.842C283.984 213.842 289.752 211.453 294.089 207.116C296.292 204.913 297.951 202.368 299.069 199.652C299.662 199.363 300.22 198.979 300.713 198.486L312.531 186.668C342.33 156.875 348.608 110.513 327.802 73.9251ZM81.9815 198.884C79.1028 198.884 76.3966 197.763 74.3606 195.728C72.3253 193.692 71.2041 190.986 71.2041 188.107C71.2041 185.229 72.3247 182.522 74.3606 180.487L84.8626 169.985C86.8979 167.949 89.6048 166.829 92.4835 166.829C95.3615 166.829 98.0684 167.949 100.104 169.985C104.306 174.187 104.306 181.024 100.104 185.226L89.6017 195.728C87.5664 197.763 84.8608 198.884 81.9815 198.884ZM98.2213 219.588C96.1854 217.552 95.0648 214.846 95.0648 211.967C95.0648 209.089 96.1854 206.382 98.2213 204.347L108.724 193.845C108.724 193.845 108.724 193.845 108.724 193.844C110.759 191.809 113.465 190.687 116.344 190.687C119.222 190.687 121.929 191.808 123.964 193.844C128.167 198.046 128.167 204.883 123.964 209.084L113.462 219.587C109.26 223.789 102.421 223.789 98.2213 219.588ZM122.08 243.447C120.044 241.411 118.924 238.704 118.924 235.826C118.924 232.948 120.044 230.241 122.08 228.206L132.583 217.703C132.583 217.703 132.583 217.703 132.583 217.703C134.618 215.668 137.324 214.546 140.203 214.546C143.082 214.546 145.788 215.667 147.823 217.703C152.025 221.906 152.025 228.742 147.823 232.944L137.321 243.447C133.119 247.649 126.282 247.649 122.08 243.447ZM171.683 256.804L161.18 267.307C159.145 269.342 156.439 270.464 153.56 270.464C150.682 270.464 147.975 269.343 145.94 267.307C141.737 263.104 141.737 256.268 145.94 252.066L156.442 241.564C156.442 241.564 156.442 241.564 156.442 241.563C158.478 239.528 161.184 238.406 164.062 238.406C166.941 238.406 169.647 239.527 171.683 241.563C173.719 243.598 174.839 246.305 174.839 249.183C174.84 252.063 173.719 254.769 171.683 256.804ZM285.475 198.497C283.44 200.533 280.733 201.654 277.855 201.654C274.976 201.654 272.27 200.533 270.234 198.497L244.868 173.131C244.867 173.13 244.866 173.129 244.865 173.128L221.008 149.271C218.628 146.891 214.77 146.891 212.389 149.271C210.009 151.65 210.009 155.509 212.389 157.889L261.615 207.114C265.818 211.317 265.818 218.154 261.615 222.355C259.58 224.391 256.873 225.512 253.995 225.512C251.117 225.512 248.41 224.391 246.375 222.355L197.148 173.13C194.768 170.751 190.91 170.751 188.529 173.13C186.15 175.509 186.15 179.368 188.529 181.749L212.384 205.602C212.386 205.604 212.388 205.607 212.39 205.609L237.757 230.974C241.959 235.177 241.959 242.014 237.757 246.216C233.554 250.418 226.717 250.418 222.516 246.216L197.149 220.849C196.68 220.38 196.153 220.007 195.592 219.724L188.356 212.488C185.976 210.109 182.118 210.109 179.737 212.488C177.358 214.868 177.358 218.727 179.737 221.107L213.681 255.05C217.883 259.252 217.883 266.089 213.681 270.291C211.646 272.327 208.939 273.447 206.061 273.447C203.182 273.447 200.476 272.327 198.44 270.291L185.524 257.375C186.508 254.793 187.029 252.028 187.029 249.183C187.029 243.049 184.64 237.281 180.302 232.944C175.964 228.606 170.197 226.218 164.064 226.218C163.754 226.218 163.445 226.228 163.137 226.24C163.381 220.057 161.153 213.794 156.443 209.084C152.105 204.747 146.338 202.358 140.205 202.358C139.895 202.358 139.586 202.369 139.278 202.381C139.523 196.198 137.294 189.935 132.585 185.225C128.246 180.887 122.479 178.499 116.346 178.499C116.036 178.499 115.727 178.509 115.419 178.521C115.664 172.339 113.436 166.075 108.726 161.366C99.7716 152.411 85.2008 152.412 76.2467 161.366L65.7447 171.867C64.4199 173.192 63.2968 174.642 62.3633 176.176C48.0484 160.972 40.1912 141.206 40.1912 120.23C40.1912 98.4122 48.6871 77.9001 64.1152 62.4731C79.5422 47.0462 100.055 38.5497 121.872 38.5497C141.698 38.5497 160.446 45.5672 175.28 58.4263L137.829 95.8766C132.884 100.823 130.16 107.399 130.16 114.393C130.16 121.388 132.884 127.964 137.829 132.91C142.935 138.015 149.641 140.568 156.347 140.568C163.052 140.568 169.758 138.016 174.864 132.91L191.458 116.316H212.94C214.714 116.316 216.469 116.194 218.202 115.979L285.479 183.255C289.677 187.459 289.677 194.296 285.475 198.497Z"
                                                    fill="#5A5A5C" />
                                                <defs>
                                                    <linearGradient id="paint0_linear" x1="174.555" y1="87" x2="174.555" y2="286.991" gradientUnits="userSpaceOnUse">
                                                        <stop stop-color="#397EAB" />
                                                        <stop offset="1" stop-color="#0D5482" stop-opacity="0.95" />
                                                    </linearGradient>
                                                </defs>
                                            </svg>
        
                                        </div>
        
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button class="btn btn-lg bg-darker py-3 px-5">Read more</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

            </main>

            @include('layouts.partials.footer')

        </div>
    </div>
    <!-- SCRIPTS -->
    <!-- Compiled Scripts: jQuery.js, Popper.js, Bootstrap.min.js -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- bootstrap js -->
    <script src="{{asset('js/main.js')}}"></script>

    <!-- Laraflash -->
    <script> $('div.alert').not('.alert-important').delay(7000).fadeOut(350); </script>

    <!-- inline script -->
    <script>        
        $(document).ready(function(){
           let $docAcct = $('#doc-acct');
           let $patAcct = $('#pat-acct');
           let selectColor = "btn-theme-blue";

           function hasSelectedColor(theClass) {
               return theClass.hasClass(selectColor);
           }

           function toggleColorChange(theClass){
                if (hasSelectedColor(theClass)) {
                    theClass.removeClass(selectColor);

               } else {
                  
                   $('.acct-type').find('.btn-theme-blue').removeClass(selectColor); 

                   theClass.addClass(selectColor);
               }
           }

           $docAcct.click(function(){
               toggleColorChange($(this));               
           })
           $patAcct.click(function(){
               toggleColorChange($(this));               
           })
        });        
    </script>
</body>

</html>