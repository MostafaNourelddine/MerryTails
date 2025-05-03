<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @vite('resources/css/app.css')
    <title>AdminPannel</title>
</head>
<!-- <div class="relative right-20 h-2 bg-black rounded-lg hover:animate-BorderB "></div> -->

<body class="  ">
    <div id="menu" class="cursor-pointer p-4 absolute top-0 ">
        <i class="fas fa-bars"></i>

    </div>
    <div id="SideBar" class="SideBar h-screen bg-gray-800 text-white shadow-xl py-10 w-64 !important">
        <div class=" mt-5 px-4 py-2 mb-6 text-lg font-semibold border-b border-gray-600 cursor-pointer" id="InsertData">
            Insert Data
        </div>
        <div class="px-4 py-2 mb-6 text-lg font-semibold border-b border-gray-600 cursor-pointer" id="EditData">
            Update Data
        </div>

        <ul class="list-none" id="UpdateData">
            <li id="UpdateCategories"
                class="p-3 my-2 mx-2 text-sm font-medium rounded-lg border-b border-gray-600 hover:bg-gray-700 hover:text-blue-400 transition duration-300 cursor-pointer">
                Update Categories
            </li>
            <li id="UpdateItems"
                class="p-3 my-2 mx-2 text-sm font-medium rounded-lg border-b border-gray-600 hover:bg-gray-700 hover:text-blue-400 transition duration-300 cursor-pointer">
                Update Items
            </li>
            <li id="UpdateImages"
                class="p-3 my-2 mx-2 text-sm font-medium rounded-lg border-b border-gray-600 hover:bg-gray-700 hover:text-blue-400 transition duration-300 cursor-pointer">
                Update Images
            </li>
        </ul>
    </div>

    <div id="AddData" class="hidden relative grid grid-cols-1 justify-items-center top-20 ">
        @include('./AdminPannel.AddData')
    </div>
    <div id="EditCategory" class="hidden p-12">
        @include('./AdminPannel.EditData.EditCategories')
    </div>

    <div id="EditImage" class="hidden p-12">
        @include('./AdminPannel.EditData.EditImages')
    </div>

    <div id="EditItem" class="hidden p-12">
        @include('./AdminPannel.EditData.EditItems')
    </div>

    <script>
    $(document).on('click', "#menu", function() {
        $("#SideBar").toggle();
    })
    $(document).on('click', "#InsertData", function() {
        $("#AddData").toggle();
        $("#SideBar").toggle();
        $("#UpdateData").hide();
        $("#EditCategory").hide();
        $("#EditItem").hide();


    })
    $(document).on('click', "#EditData", function() {
        $("#UpdateData").toggle();
        $("#AddData").hide();

    })
    $(document).on('click', "#UpdateCategories", function() {
        $("#EditCategory").toggle();
        $("#EditImage").hide();
        $("#EditItem").hide();

        $("#SideBar").hide();

    })
    $(document).on('click', "#UpdateItems", function() {
        $("#EditItem").toggle();
        $("#EditImage").hide();
        $("#EditCategory").hide();

        $("#SideBar").hide();

    })
    $(document).on('click', "#UpdateImages", function() {
        console.log("Update Images clicked!");
        $("#EditImage").show();
        $("#EditCategory").hide();
        $("#EditItem").hide();
        $("#SideBar").hide();

    })
    </script>
</body>

</html>
