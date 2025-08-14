<div x-data="{ sidebarOpen: true }">


    <!-- Sidebar -->
    <div class="SideBar shadow-lg transition-transform duration-300 ease-in-out fixed top-0 left-0 h-full w-64 z-40"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" style="background-color: #FAFAFA;">

        <!-- Header -->
        <div class="flex items-center justify-between p-4 text-2xl font-bold">
            <div class="flex items-center space-x-4">
                <i class="fas fa-gear text-white bg-softPink p-2 rounded-xl"></i>
                <span class="text-gray-800">Admin Panel</span>
            </div>
            <button @click="sidebarOpen = false" class="hover:text-black text-[#424242] ml-6 transition">
                <i class="fas fa-xmark text-xl"></i>
            </button>
        </div>

        <!-- Menu Items -->
        <ul class="list-none p-4 ml-4 text-[#424242]">
            <li class="mt-3 rounded-xl py-2 px-4 text-xl cursor-pointer
    {{ request()->routeIs('admin.index') ? 'bg-softPink text-title' : 'hover:bg-softPink' }}">
                <a href="{{ route('admin.index') }}" class="flex items-center space-x-4">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="mt-3 rounded-xl py-2 px-4 text-xl cursor-pointer
    {{ Request::is('admin/categories*') ? 'bg-softPink text-title' : 'hover:bg-softPink' }}">
                <a href="{{ route('admin.getcategories') }}" class="flex items-center space-x-4">
                    <i class="fas fa-th-large"></i>
                    <span>Categories</span>
                </a>
            </li>


            <li class="mt-3 rounded-xl py-2 px-4 text-xl cursor-pointer
    {{ request()->routeIs('admin.items') ? 'bg-softPink' : '' }} hover:bg-softPink">
                <a href="{{ route('admin.items') }}" class="flex items-center space-x-4">
                    <i class="fas fa-box"></i>
                    <span>Items</span>
                </a>
            </li>

        </ul>
    </div>
</div>
<style>

</style>
