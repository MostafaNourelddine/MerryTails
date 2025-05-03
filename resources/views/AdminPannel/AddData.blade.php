<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    @vite('resources/css/app.css')

</head>

<body class=" ">
    <div class="shadow-2xl px-10  pt-10 min-h-96 h-fit w-80 mt-10 " id="Add">
        <ul class="list-none flex space-x-5 text-xl ">
            <div class="overflow-hidden  ">
                <li id="categoryLi" class="hover:border-b-black hover:border-b-2 border-solid cursor-pointer  ">
                    Category
                </li>
            </div>
            <li id="itemLi" class="hover:border-b-black hover:border-b-2 border-solid cursor-pointer">Item</li>
            <li id="imageLi" class="hover:border-b-black hover:border-b-2 border-solid cursor-pointer">Image
            </li>
        </ul>
        <div id="" class="  mt-10 justify-center flex ">
            <form id="category" action="{{route('category.store')}}" method="post" class=""
                enctype="multipart/form-data">
                @csrf
                <label for="name">Add name:</label>
                <div name="" class="mb-4"> <input name="Name" type="text"
                        class="w-full p-1 border border-gray-300 rounded-lg text-gray-700 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                </div>
                <label for="name">Add Image:</label>
                <div name="" class="mb-4"> <input name="Image" type="file"
                        class=" p-1 border border-gray-300 rounded-lg text-gray-700 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                </div>
                <label for="name">Add description:</label>

                <div name=""><input name=" Description" type="text"
                        class=" w-full p-1 border border-gray-300 rounded-lg text-gray-700 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all ">
                </div>
                <div name="" class=" mt-10 flex justify-center  px-10 py-4  "><input type="submit"
                        class="cursor-pointer bg-blue-500 "> </div>
            </form>

            <div id="item" class=" hidden">
                <form action="{{route('item.store')}}" method="post">
                    @csrf
                    <label for="Category">Choose a category:</label>
                    <select name="Category" class="mb-4">
                        @foreach($categories as $category)
                        <option value='{{$category->id}}'>{{$category->name}}</option>
                        @endforeach
                    </select>
                    <br>
                    <label for="name">Add Name:</label>

                    <div name=""><input
                            class=" w-full p-1 border border-gray-300 rounded-lg text-gray-700 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                            name="Name" placeholder="" type="text"> </div>
                    <label for="price">Add Price:</label>

                    <div name=""><input
                            class=" w-full p-1 border border-gray-300 rounded-lg text-gray-700 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                            name="Price" placeholder="" type="text"> </div>
                    <label for="name">Add description:</label>

                    <div name=""><input
                            class=" mb-2  w-full p-1 border border-gray-300 rounded-lg text-gray-700 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                            name="Description" placeholder="" type="text"> </div>



                    <div name="" class="  flex justify-center  px-10 py-4  "><input type="submit"
                            class="cursor-pointer bg-blue-500 "> </div>
                    </br>
                </form>
            </div>
        </div>
        <div id="img" class="hidden">
            <form action="{{route('img.store')}}" method="post" enctype="multipart/form-data">

                <label for="inputs[0][item_id]">Choose an Item:</label>
                <select name="inputs[0][item_id]" class="mb-4">
                    @foreach($items as $item)
                    <option value='{{$item->id}}'>{{$item->name}}</option>
                    @endforeach

                </select>
                @csrf
                <div id="imgcolor">
                    <div id="img1">
                        <input name="inputs[0][src]" type="file"
                            class=" mb-2 w-full p-1 border border-gray-300 rounded-lg text-gray-700 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                        <br>
                        <label for="inputs[0][color]">Choose a Color:</label>

                        <input name="inputs[0][color]" type="color"
                            class=" mb-4 w-full p-1 border border-gray-300 rounded-lg text-gray-700 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">

                    </div>

                </div>

                <div id="more" class="  mb-2 cursor-pointer  flex justify-center  ">Add More
                </div>
                <div name="" class=" pb-4  flex justify-center   "><input type="submit" class="cursor-pointer">
                </div>

            </form>
        </div>
    </div>



    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <script>
    var i = 0;

    $('#more').click(function() {
        ++i;
        $('#imgcolor').append(`
<div class="container" id="img[` + i + `]">
    <input name="inputs[` + i + `][src]" type="file" class="mt-8 mb-2 w-full p-1 border border-gray-300 rounded-lg text-gray-700 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
>
<br>
 <label for="inputs[` + i + `][color]">Choose a Color:</label>

    <input type="color" name="inputs[` + i + `][color]" type="text"  class=" mb-4 w-full p-1 border border-gray-300 rounded-lg text-gray-700 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
>

<div id="delete" class="bg-red mb-10 cursor-pointer " >Delete </div>
</div>`);


    })
    $(document).on('click', '#delete', function() {
        $(this).parent(".container").remove();
    });

    $(document).on('click', "#itemLi", function() {
        $("#category").hide();
        $("#img").hide();
        $("#item").show();
    });

    $(document).on('click', "#categoryLi", function() {
        $("#category").show();
        $("#item").hide();
        $("#img").hide();
    });
    $(document).on('click', "#imageLi", function() {
        $("#img").show();
        $("#item").hide();
        $("#category").hide();


    })
    </script>
</body>

</html>
