<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite('resources/css/app.css')

</head>

<body class="relative grid grid-cols-1 justify-items-center top-20 bg-gray-50 p-10">
    <div class="absolute top-4 left-4">
        <button onclick="window.history.back();" class="text-3xl text-gray-700 hover:text-gray-900">
            return back
        </button>
    </div>
    <div class="bg-white p-8 rounded-lg  w-full max-w-lg">

        <form action="{{route('itemupdate',['item'=>$item])}}" method="post">
            @csrf

            <h2 class="text-2xl font-semibold text-center text-gray-800 mb-6">Edit Item Details</h2>

            <!-- Name Input -->
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-medium mb-2">Edit Name:</label>
                <input value="{{$item->name}}" name="name" type="text"
                    class="w-full p-3 border border-gray-300 rounded-lg text-gray-700 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                    placeholder="Enter item name">
            </div>

            <!-- Category Input -->
            <div class="mb-4">
                <label for="cat_id" class="block text-gray-700 font-medium mb-2">Edit Category ID:</label>
                <input value="{{$item->cat_id}}" name="cat_id" type="text"
                    class="w-full p-3 border border-gray-300 rounded-lg text-gray-700 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                    placeholder="Enter category ID">
            </div>

            <!-- Price Input -->
            <div class="mb-4">
                <label for="price" class="block text-gray-700 font-medium mb-2">Edit Price:</label>
                <input value="{{$item->price}}" name="price" type="text"
                    class="w-full p-3 border border-gray-300 rounded-lg text-gray-700 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                    placeholder="Enter price">
            </div>

            <!-- Description Input -->
            <div class="mb-6">
                <label for="description" class="block text-gray-700 font-medium mb-2">Edit Description:</label>
                <input value="{{$item->description}}" name="description" type="text"
                    class="w-full p-3 border border-gray-300 rounded-lg text-gray-700 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                    placeholder="Enter description">
            </div>

            <!-- Submit Button -->
            <div class="mt-6 text-center">
                <button type="submit"
                    class="w-full py-3 bg-blue-500 text-white rounded-lg font-semibold hover:bg-blue-600 transition-all">
                    Update Item
                </button>
            </div>
        </form>
    </div>

    <!-- Displaying errors -->
    @foreach ($errors->all() as $error)
    <div class="text-red-500 text-center mt-4">{{$error}}</div>
    @endforeach
</body>


</html>