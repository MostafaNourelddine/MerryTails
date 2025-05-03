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
                        Src
                    </th>
                    <th scope="col" class="px-6 py-3" style="font-size:16px;">
                        color
                    </th>
                    <th scope="col" class="px-6 py-3" style="font-size:16px;">
                        Item Id
                    </th>
                    <th scope="col" class="px-6 py-3" style="font-size:16px;">
                        Edit
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($images as $image)
                <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{$image->id}}
                    </th>
                    <td class="px-6 py-4">
                        {{$image->src}}
                    </td>
                    <td class="px-6 py-4">
                        {{$image->color}}
                    </td>
                    <td class="px-6 py-4">
                        {{$image->item_id}}
                    </td>
                    <td class="px-6 py-4 cursor-pointer
                    ">
                        <a href="{{Route('imageedit',['img'=>$image->id])}}"
                            class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                    </td>
                    <td class="px-6 py-4 cursor-pointer
                    ">
                        <a href="{{Route('DeleteImage',['id'=>$image->id])}}"
                            class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Delete</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="block  sm:hidden mt-16">
        @foreach ($images as $image)
        <div class="bg-white shadow-2xl rounded-lg p-4 mb-10 dark:bg-gray-900 dark:border-gray-700">
            <div class="text-lg font-semibold text-gray-900 dark:text-white">
                #ID: {{$image->id}}
            </div>
            <div class="text-gray-700 dark:text-gray-400">
                <strong>Color :</strong> {{$image->color}}
            </div>
            <div class="text-gray-700 dark:text-gray-400">
                <strong>Item Id :</strong> {{$image->item_id}}
            </div>
            <div>
                <a href="{{Route('imageedit',['img'=>$image->id])}}"
                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
            </div>
            <div>
                <a href="{{Route('DeleteImage',['id'=>$image->id])}}"
                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Delete</a>
            </div>
        </div>
        @endforeach
    </div>
</body>

</html>
