<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Image</title>
    @vite('resources/css/app.css')
    <!-- Tailwind CSS file -->
</head>

<body class="bg-gray-50 p-10">

    <!-- Back Button -->
    <button onclick="window.history.back();"
        class="absolute top-4 left-4 text-xl text-blue-500 hover:text-blue-700 px-">
        ← Go Back
    </button>

    <!-- Form Container -->
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-lg mx-auto pt-10">

        <!-- Form Header -->

        <form action="{{ route('imgupdate', ['img' => $img]) }}" method="post">
            @csrf

            <!-- Image Preview -->
            <div class="mb-6 text-center">
                <img src="{{ asset('storage/' . $img->src) }}" class=" rounded-lg mb-4" alt="Image Preview"
                    style="width:10rem">
            </div>

            <!-- Image Source -->
            <div class="mb-4">
                <label for="src" class="block text-gray-700 font-medium mb-2">Image Source (src):</label>
                <input name="src" type="text" value="{{ $img->src }}"
                    class="w-full p-3 border border-gray-300 rounded-lg text-gray-700 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Enter image source URL">
            </div>

            <!-- Item ID -->
            <div class="mb-4">
                <label for="item_id" class="block text-gray-700 font-medium mb-2">Item ID:</label>
                <input name="item_id" type="text" value="{{ $img->item_id }}"
                    class="w-full p-3 border border-gray-300 rounded-lg text-gray-700 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Enter item ID">
            </div>

            <!-- Color -->
            <div class="mb-4">
                <label for="color" class="block text-gray-700 font-medium mb-2">Color:</label>
                <input name="color" type="text" value="{{ $img->color }}"
                    class="w-full p-3 border border-gray-300 rounded-lg text-gray-700 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Enter color">
            </div>

            <!-- Submit Button -->
            <div class="mt-6 text-center">
                <button type="submit"
                    class="w-full py-3 bg-blue-500 text-white rounded-lg font-semibold hover:bg-blue-600 transition-all">
                    Update Image
                </button>
            </div>
        </form>

        <!-- Displaying Errors -->
        @foreach ($errors->all() as $error)
        <div class="text-red-500 text-center mt-4">{{ $error }}</div>
        @endforeach
    </div>

</body>

</html>
