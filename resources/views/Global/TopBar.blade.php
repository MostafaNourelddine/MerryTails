<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>




</head>

<body>
    <header class="site-navbar" role="banner">
        <div class="site-navbar-top">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-6 col-md-4 order-2 order-md-1 site-search-icon text-left">
                        <form action="/Search" method="post" class="site-block-top-search">
                            @csrf
                            <span class="icon icon-search2"></span>
                            <input name="search" type="text" class="form-control border-0" placeholder="Search">
                        </form>
                    </div>
                    <div class="col-12 mb-3 mb-md-0 col-md-4 order-1 order-md-2 text-center">
                        <div class="site-logo">
                            <a href="/" class="js-logo-clone">MeryyTails</a>
                        </div>
                    </div>

                    <div class="col-6 col-md-4 order-3 order-md-3 text-right">
                        <div class="site-top-icons">
                            <ul class="d-flex justify-content-end">
                                <li class="d-inline-block d-md-none ml-md-0">
                                    <a href="#" class="site-menu-toggle js-menu-toggle">
                                        <span class="icon-menu"></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <nav class="site-navigation text-right text-md-center" role="navigation">
            <div class="container">
                <ul class="site-menu js-clone-nav d-none d-md-block">
                    <li><a href="/category/1/show">Shop</a></li>
                    <li class="has-children">
                        <a href="#">Collections</a>
                        <ul class="dropdown">
                            @foreach($categories as $category)
                            <li><a href="/category/{{$category->id}}/show">{{$category->name}}</a></li>
                            @endforeach
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>

    </header>




</body>


</html>
