<!DOCTYPE html>
<html lang="en">

<head>
    <title>Shoppers &mdash; Colorlib e-Commerce Template</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="{{ asset('https://fonts.googleapis.com/css?family=Mukta:300,400,700') }}">
    <link rel="stylesheet" href="{{ asset('fonts/icomoon/style.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>


    <link rel="stylesheet" href="{{asset('css/aos.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/magnific-popup.css')}}">
    <link rel="stylesheet" href="{{ asset('css/jquery-ui.css')}}">
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/owl.theme.default.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">


</head>

<body>
    <!-- @if($images->count()==0)
    @else
    @php
    $firstImage = $images->first();
    $src = $firstImage->src;
    @endphp
    @endif -->
    @php
    $imagesArray = $images->toArray(); // Make sure $images is passed to the view
    @endphp
    <div class="site-wrap">
        @include('Global.TopBar')


        <div class="bg-light py-3">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 mb-0"><a href="index.html">Home</a> <span class="mx-2 mb-0">/</span> <strong
                            class="text-black">{{$item->name}}</strong></div>
                </div>
            </div>
        </div>

        <div class="site-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        @php
                        $imagesArray = $images->toArray();
                        @endphp

                        <div x-data="{
        images: @js($imagesArray),
        current: 0
    }" class="flex flex-col items-center gap-4 mt-6">
                            <!-- Dynamic Image -->
                            <img :src="'/storage/' + images[current].src" alt="Image" class="img-fluid rounded shadow"
                                style="height: 18rem;">

                            <!-- Color Swatch -->
                            <div class="rounded-full border border-white cursor-pointer"
                                style="width: 2rem; height: 2rem;"
                                :style="'background-color: ' + images[current].color"></div>

                            <!-- Navigation Arrows -->
                            <!-- Arrows Section -->
                            <div class="flex justify-center items-center gap-4   mt-4 text-3xl text-white">
                                <!-- Left Arrow -->
                                <button @click="current = (current - 1 + images.length) % images.length"
                                    class="hover:text-[#FFA500] focus:outline-none">
                                    &larr;
                                </button>

                                <!-- Right Arrow -->
                                <button @click="current = (current + 1) % images.length"
                                    class="hover:text-[#FFA500] focus:outline-none">
                                    &rarr;
                                </button>
                            </div>

                        </div>


                    </div>
                    <div class="col-md-6">
                        <h2 class="text-black">{{$item->name}}</h2>
                        <p>{{$item->description}}</p>
                        <p><strong class="text-primary h4">${{$item->price}}</strong></p>


                    </div>
                </div>
            </div>
        </div>
        <footer class="site-footer border-top">
            <div class="container">
                <div class="row">

                    <div class="col-md-6 col-lg-3">
                        <div class="block-5 mb-5">
                            <h3 class="footer-heading mb-4">Contact Info</h3>
                            <ul class="list-unstyled">
                                <li class="address">Tyre-Jouaiya LEBANON</li>
                                <li class="phone"><a>+961 00 000 000</a></li>
                                <li class="email">emailaddress@domain.com</li>
                            </ul>
                        </div>


                    </div>
                </div>
                <div class="row pt-5 mt-5 text-center">
                    <div class="col-md-12">
                        <p>
                            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                            Copyright &copy;<script data-cfasync="false"
                                src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
                            <script>
                            document.write(new Date().getFullYear());
                            </script> All rights reserved | This template is made with <i class="icon-heart"
                                aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank"
                                class="text-primary">Colorlib</a>
                            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        </p>
                    </div>

                </div>
            </div>
        </footer>



    </div>

    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('js/aos.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script>
    // function ChangeSource(newsrc) {
    //     console.log("clicked")
    //     var image = document.getElementById('image');

    //     image.src = '/storage/' + newsrc;

    // }
    </script>
    <style>
    .pagination svg {
        width: 1rem;
        height: 1rem;
    }

    .pagination nav>div:first-child {
        display: none;
        /* Optional: hides “Showing x to y of z results” */
    }
    </style>

</body>

</html>
