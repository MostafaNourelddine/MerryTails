<!DOCTYPE html>
<html lang="en">

<head>
    <title>Shoppers &mdash; Colorlib e-Commerce Template</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="{{ asset('https://fonts.googleapis.com/css?family=Mukta:300,400,700') }}">
    <link rel="stylesheet" href="{{ asset('fonts/icomoon/style.css') }}">


    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{asset('css/magnific-popup.css')}}">
    <link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owl.theme.default.min.css') }}">



    <link rel="stylesheet" href="css/aos.css">

    <link rel="stylesheet" href="css/style.css">

</head>

<body>

    <div class="site-wrap">
        @include('Global.TopBar')

        <div class="site-blocks-cover"
            style="background-image: url(https://i.pinimg.com/736x/74/68/1e/74681ec70ca14ee1f7fdd9c0f3cc89cc.jpg);"
            data-aos="fade">
            <div class="container">
                <div class="row align-items-start align-items-md-center justify-content-end">
                    <div class="col-md-5 text-center text-md-left pt-5 pt-md-0">
                        <h1 class="mb-2">Finding Your Perfect Customization</h1>
                        <div class="intro-text text-center text-md-left">

                            <a href="/category/1/show" class="btn btn-sm btn-primary " style="margin-top:1rem">Shop
                                Now</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="site-section site-section-sm site-blocks-1">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-lg-4 d-lg-flex mb-4 mb-lg-0 pl-4" data-aos="fade-up" data-aos-delay="">
                        <div class="icon mr-4 align-self-start">
                            <span class="icon-truck"></span>
                        </div>
                        <div class="text">
                            <h2 class="text-uppercase"> Shipping</h2>
                            <p>delivery available all over lebanon for 4$
                                Your order will take 3-4 business days to be delivered.</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 d-lg-flex mb-4 mb-lg-0 pl-4" data-aos="fade-up" data-aos-delay="100">
                        <div class="icon mr-4 align-self-start">
                            <span class="icon-refresh2"></span>
                        </div>
                        <div class="text">
                            <h2 class="text-uppercase">Hand Made</h2>
                            <p>Merry tails team believes in the power of handmade items to bring joy to your hearts! And
                                we are committed to creating quality items and lovable items that will last for years.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 d-lg-flex mb-4 mb-lg-0 pl-4" data-aos="fade-up" data-aos-delay="200">
                        <div class="icon mr-4 align-self-start">
                            <span class="icon-help"></span>
                        </div>
                        <div class="text">
                            <h2 class="text-uppercase">Customer Support</h2>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus at iaculis quam.
                                Integer accumsan tincidunt fringilla.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="site-section site-blocks-2">
            <div class="container">
                <div class="row">
                    @foreach($categories->take(3) as $category)

                    <div class="col-sm-6 col-md-6  col-lg-4 mb-4 mb-lg-0 " data-aos="fade" data-aos-delay="">
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

        <div class="site-section block-3 site-blocks-2 bg-light">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-7 site-section-heading text-center pt-4">
                        <h2>Featured Products</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="nonloop-block-3 owl-carousel">
                            @foreach($items->take(6) as $item)

                            <div class="item">
                                <div class="block-4 text-center">
                                    <figure class="block-4-image">
                                        @foreach($images as $image)
                                        @if($item->id==$image->item_id)
                                        <img src="{{ asset('storage/' . $image->src) }}" alt="Image placeholder"
                                            class="img-fluid" style="height:15rem">
                                        @break
                                        @endif
                                        @endforeach
                                    </figure>
                                    <div class="block-4-text p-4">
                                        <h3><a href="/view/{{{$item->id}}}/item">{{$item->name}}</a></h3>
                                        <p class="mb-0">{{$item->description}}</p>
                                        <p class="text-primary font-weight-bold">${{$item->price}}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach


                        </div>
                    </div>
                </div>

            </div>
        </div>


        @include('Global.Footer')
    </div>

    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/aos.js"></script>

    <script src="js/main.js"></script>

</body>

</html>
