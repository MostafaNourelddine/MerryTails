<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    @vite('resources/css/app.css')
</head>

<body class="relative grid grid-cols-1 justify-items-center top-20 bg-gray-50  p-10">



    <div class="bg-white p-8 rounded-lg  w-full max-w-lg">
        <form action="{{route('categoryupdate',['category'=>$category])}}" method="post">
            @csrf

            <h2 class="text-2xl font-semibold text-center text-gray-800 mb-6">Edit Category</h2>

            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-medium mb-2">Edit Name:</label>
                <input value="{{$category->name}}" name="name" type="text"
                    class="w-full p-3 border border-gray-300 rounded-lg text-gray-700 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                    placeholder="Enter category name">
            </div>

            <div class="mb-4">
                <label for="description" class="block text-gray-700 font-medium mb-2">Edit Description:</label>
                <input value="{{$category->description}}" name="description" type="text"
                    class="w-full p-3 border border-gray-300 rounded-lg text-gray-700 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                    placeholder="Enter category description">
            </div>
            <div class="mb-4">
                <label for="image" class="block text-gray-700 font-medium mb-2">Edit Image:</label>
                <input value="{{$category->image}}" name="image" type="text"
                    class="w-full p-3 border border-gray-300 rounded-lg text-gray-700 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                    placeholder="Enter category image">
            </div>
            <div class="mb-4">
                <label for="image" class="block text-gray-700 font-medium mb-2">Edit Image:</label>
                <input value="{{$category->image}}" name="image" type="text"
                    class="w-full p-3 border border-gray-300 rounded-lg text-gray-700 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                    placeholder="Enter category image">
            </div>

            <div class="mt-6 text-center">
                <button type="submit"
                    class="w-full py-3 bg-blue-500 text-white rounded-lg font-semibold hover:bg-blue-600 transition-all">
                    Update Category
                </button>
            </div>
        </form>
    </div>
