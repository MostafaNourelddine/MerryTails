<!DOCTYPE html>
<html lang="en">

<head>
    <title>Shoppers &mdash; Colorlib e-Commerce Template</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="{{ asset('https://fonts.googleapis.com/css?family=Mukta:300,400,700') }}">
    <link rel="stylesheet" href="{{ asset('fonts/icomoon/style.css') }}">


    <link rel="stylesheet" href="{{asset('css/aos.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/magnific-popup.css')}}">
    <link rel="stylesheet" href="{{ asset('css/jquery-ui.css')}}">
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/owl.theme.default.min.css')}}">

</head>

<body>

    <div class="site-wrap">
        @include('Global.TopBar')


        <div class="bg-light py-3">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 mb-0"><a href="index.html">Home</a> <span class="mx-2 mb-0">/</span> <strong
                            class="text-black">Shop</strong></div>
                </div>
            </div>
        </div>

        <div class="site-section">
            <div class="container">

                <div class="row mb-5">
                    <div class="col-md-9 order-2">

                        <div class="row">
                            <div class="col-md-12 mb-5">
                                <div class="float-md-left mb-4">
                                    <h2 class="text-black h5">Shop All</h2>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-5">
                            @if($items->count()==0)
                            <div class="d-flex justify-content-center align-items-center vh-100">
                                <div class="alert alert-warning text-center shadow p-5 rounded-4 bg-white">
                                    <h4 class="alert-heading mb-3">No Items Found</h4>
                                    <p class="mb-0">Try adjusting your search or come back later.</p>
                                    <i class="bi bi-search display-4 mt-3 text-muted"></i>
                                </div>
                            </div>

                            @else
                            @foreach($items as $item)
                            <div class="col-sm-6 col-lg-4 mb-4" data-aos="fade-up">
                                <div class="block-4 text-center border">
                                    <figure class="block-4-image">
                                        <a href="shop-single.html">
                                            @foreach($images as $image)
                                            @if($item->id==$image->item_id)
                                            <img src="{{ asset('storage/' . $image->src) }}" alt="Image placeholder"
                                                class="img-fluid" style="height:15rem">
                                            @break
                                            @endif
                                            @endforeach
                                        </a>
                                    </figure>
                                    <div class="block-4-text p-4">
                                        <h3><a href="/view/{{{$item->id}}}/item">{{$item->name}}</a></h3>
                                        <p class="mb-0">{{$item->description}}</p>
                                        <p class="text-primary font-weight-bold">${{$item->price}}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach

                            @endif
                        </div>
                        <div class="row" data-aos="fade-up">
                            <div class="col-md-12 text-center">
                                <div class="site-block-27">

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 order-1 mb-5 mb-md-0">
                        <div class="border p-4 rounded mb-4">
                            <ul class="list-unstyled mb-0">
                                <li class="mb-1 ">Made By Hand</li>
                                <li class="mb-1">Customize your Own item</li>
                                <li class="mb-1">Be the unique Creator</li>
                            </ul>
                        </div>


                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="site-section site-blocks-2">
                            <div class="row justify-content-center text-center mb-5">
                                <div class="col-md-7 site-section-heading pt-4">
                                    <h2>Collections</h2>
                                </div>
                            </div>
                            <div class="row">
                                @foreach($categories->take(3) as $category)

                                <div class="col-sm-6 col-md-6 col-lg-4 mb-4 mb-lg-0" data-aos="fade" data-aos-delay="">
                                    <a class="block-2-item" href="/category/{{$category->id}}/show">
                                        <figure class="image">
                                            <img src="{{ asset('storage/' . $category->src) }}" alt="" class="img-fluid"
                                                style="height:15rem;object-fit: cover;width:100%;">
                                        </figure>
                                        <div class="text">
                                            <span class="text-uppercase">Collections</span>
                                            <h3>{{$category->name}}</h3>
                                        </div>
                                    </a>
                                </div>
                                @endforeach
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>

        @include('Global.Footer')

    </div>

    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('js/aos.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>

</body>

</html>
