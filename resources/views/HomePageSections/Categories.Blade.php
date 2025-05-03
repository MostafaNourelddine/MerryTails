<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css2?family=Arima:wght@400;700&display=swap" rel="stylesheet">
</head>

<body>

    <div id="title" class="p-4 text-2xl font-semibold relative  ">
        Categories
    </div>
    <div id="Categories "
        class="grid grid-cols-1 lg:grid-cols-3 md:grid-cols-2 justify-items-center align-items-center gap-2 ">
        @foreach($categories as $category)
        <div id="Category " class="relative  mt-8">
            <div id="img">
                <img class="rounded-md" style="width:24rem;height:7rem" src="{{$category->src}}" alt="">
            </div>
            <div id="Data" class="absolute top-0 ml-4 mt-2 font-semibold">
                <div id="Name" class="text-xl  ">
                    {{$category->name}}
                </div>
                <div id="Shop" class="mt-3 text-sm cursor-pointer">
                    <a href="/category/{{{$category->id}}}/show" class=" bg-White50 px-4 rounded-xl">Shop Now</a>
                </div>
            </div>
        </div>

        @endforeach


    </div>
    </div>
    </div>
</body>

</html>
