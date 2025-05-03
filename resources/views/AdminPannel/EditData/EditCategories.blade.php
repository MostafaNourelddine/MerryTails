<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Table Example</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-Main">
    <!-- For larger screens (sm and up) -->
    <div class="relative overflow-x-auto shadow-xd sm:rounded-lg hidden sm:block mt-16">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3" style="font-size:16px;">
                        #ID
                    </th>
                    <th scope="col" class="px-6 py-3" style="font-size:16px;">
                        Name
                    </th>
                    <th scope="col" class="px-6 py-3" style="font-size:16px;">
                        Description
                    </th>
                    <th scope="col" class="px-6 py-3" style="font-size:16px;">
                        Edit
                    </th>
                    <th scope="col" class="px-6 py-3" style="font-size:16px;">
                        Delete
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{$category->id}}
                    </th>
                    <td class="px-6 py-4">
                        {{$category->name}}
                    </td>
                    <td class="px-6 py-4">
                        {{$category->description}}
                    </td>
                    <td class="px-6 py-4 cursor-pointer ">
                        <a href="{{Route('categoryedit',['category'=>$category->id])}}"
                            class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                    </td>
                    <td class="px-6 py-4 cursor-pointer">
                        <a href="{{Route('DeleteCategory',['id'=>$category->id])}}"
                            class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Delete</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="block  sm:hidden mt-16">
        @foreach ($categories as $category)
        <div class="bg-white shadow-2xl rounded-lg p-4 mb-10 dark:bg-gray-900 dark:border-gray-700">
            <div class="text-lg font-semibold text-gray-900 dark:text-white">
                #ID: {{$category->id}}
            </div>
            <div class="text-gray-700 dark:text-gray-400">
                <strong>Name:</strong> {{$category->name}}
            </div>
            <div class="text-gray-700 dark:text-gray-400">
                <strong>Description:</strong> {{$category->description}}
            </div>
            <div>
                <a href="{{Route('categoryedit',['category'=>$category->id])}}"
                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
            </div>
            <td class="px-6 py-4 cursor-pointer">
                <a href="{{Route('DeleteCategory',['id'=>$category->id])}}"
                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Delete</a>
            </td>
        </div>
        @endforeach
    </div>

</body>

</html>
