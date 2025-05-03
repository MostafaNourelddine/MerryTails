<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div id="title" class=" mt-20 p-4 text-2xl font-semibold relative   ">
        Our Products
    </div>
    <div id="Products" class="grid grid-cols-2 gap-2 mb-14 md:grid-cols-3 lg:grid-cols-4">
        @foreach($items->take(10) as $item)
        <div id="Product" class="flex items-center flex-col align-middle mt-6 ">
            <div id="img">
                @foreach($images as $image)
                @if($item->id==$image->item_id)
                <img style="width:10rem;height:12rem;" src="{{$image->src}}" alt=""> @break
                @endif
                @endforeach

            </div>
            <div id="Data" class="text-center border border-Border  border-t-0  w-[10rem] pb-8">
                <div id="name" class="text-black mt-2 ">{{$item->name}}</div>
                <div id="price" class="text-LightGrey mb-4">{{$item->price}}$</div>
                <div id="view"><a href="/view/{{{$item->id}}}/item" class="bg-LightGrey60 px-4 py-2 text-black">Quick
                        View</a></div>
            </div>
        </div>
        @endforeach
    </div>
    <div id="More" class=" flex justify-center mt-20 align-center">
        <div class="border border-black w-[6rem] py-2   text-center cursor-pointer">
            <a href="/category/1/show">View More</a>
        </div>
    </div>
</body>

</html>
