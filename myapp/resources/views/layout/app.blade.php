<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin Panel')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <script src="https://unpkg.com/alpinejs" defer></script>
    <style>
    .bg-soft-pink {
        background-color: #fce7f3;
        /* Very soft pink */
    }

    /* Global input styling */
    input, textarea {
        border: 2px solid #e5e7eb !important;
        transition: all 0.3s ease;
    }

    input:focus, textarea:focus {
        outline: none;
        border: 2px solid #FABEB3 !important;
        box-shadow: 0 0 5px rgba(250, 190, 179, 0.5);
    }
    </style>

</head>

<body class="flex min-h-screen bg-background">

    <div class="SideBar shadow-lg transition-transform duration-300 ease-in-out w-[18%] bg-card"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
        <div class="flex items-center justify-between p-4 border-b border-border">
            <div class="flex items-center space-x-4">
                <i class="fas fa-gear text-title bg-accent2 p-2 rounded-xl"></i>
                <span class="text-title text-2xl font-bold">Admin Panel</span>
            </div>
            <div class="hover:text-title text-description ml-8 transition">
                <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="flex items-center gap-2 text-description hover:text-title transition-colors">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>

        <ul class="list-none p-4 ml-4 text-description">
            <li
                class="mt-3 rounded-xl py-2 px-4 text-xl hover:bg-accent2 hover:text-title cursor-pointer {{ request()->routeIs('admin.index') ? 'bg-accent2 text-title' : '' }}">
                <a href="{{ route('admin.index') }}" class="flex items-center space-x-4">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li
                class="mt-3 rounded-xl py-2 px-4 text-xl hover:bg-accent2 hover:text-title cursor-pointer {{ request()->routeIs('admin.getcategories') ? 'bg-accent2 text-title' : '' }}">
                <a href="{{route('admin.getcategories')}}" class="flex items-center space-x-4">
                    <i class="fas fa-th-large"></i>
                    <span>Categories</span>
                </a>
            </li>

            <li
                class="mt-3 rounded-xl py-2 px-4 text-xl hover:bg-accent2 hover:text-title cursor-pointer {{ request()->routeIs('admin.items.*') ? 'bg-accent2 text-title' : '' }}">
                <a href="{{ route('admin.items.index') }}" class="flex items-center space-x-4">
                    <i class="fas fa-box"></i>
                    <span>Items</span>
                </a>
            </li>

        </ul>
    </div>
    <div>

    </div>
    <main class="flex-1 p-8 overflow-y-auto">
        @yield('content')
    </main>

    <!-- Global Success Alert -->
    <div id="globalSuccessAlert"
        class="fixed bottom-4 left-1/2 transform -translate-x-1/2 bg-green-500 text-white px-6 py-4 rounded-xl shadow-lg transform transition-all duration-300 opacity-0 scale-95"
        style="z-index: 9999;">
        <div class="flex items-center gap-2">
            <i class="fa-solid fa-check-circle"></i>
            <span id="globalSuccessMessage">Operation completed successfully!</span>
        </div>
    </div>

    <!-- Global Error Alert -->
    <div id="globalErrorAlert"
        class="fixed bottom-4 left-1/2 transform -translate-x-1/2 bg-red-500 text-white px-6 py-4 rounded-xl shadow-lg transform transition-all duration-300 opacity-0 scale-95 max-w-sm sm:max-w-md md:max-w-lg lg:max-w-xl xl:max-w-2xl mx-4"
        style="z-index: 9999;">
        <div class="flex items-start gap-2">
            <i class="fa-solid fa-exclamation-circle mt-1 flex-shrink-0"></i>
            <div class="min-w-0 flex-1">
                <div class="font-semibold mb-1">Error:</div>
                <span id="globalErrorMessage" class="break-words">An error occurred during the operation.</span>
            </div>
        </div>
    </div>

    <script>
        // Global alert functions
        function showGlobalSuccessAlert(message) {
            const alert = document.getElementById('globalSuccessAlert');
            const alertMessage = document.getElementById('globalSuccessMessage');
            alertMessage.textContent = message;

            // Show the alert
            alert.classList.remove('opacity-0', 'scale-95');
            alert.classList.add('opacity-100', 'scale-100');

            // Hide the alert after 3 seconds
            setTimeout(() => {
                alert.classList.remove('opacity-100', 'scale-100');
                alert.classList.add('opacity-0', 'scale-95');
            }, 3000);
        }

        function showGlobalErrorAlert(message) {
            const alert = document.getElementById('globalErrorAlert');
            const alertMessage = document.getElementById('globalErrorMessage');
            alertMessage.textContent = message;

            // Show the alert
            alert.classList.remove('opacity-0', 'scale-95');
            alert.classList.add('opacity-100', 'scale-100');

            // Hide the alert after 5 seconds
            setTimeout(() => {
                alert.classList.remove('opacity-100', 'scale-100');
                alert.classList.add('opacity-0', 'scale-95');
            }, 5000);
        }

        // Disable submit buttons on submit to prevent double submissions
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('form').forEach(function(form) {
                form.addEventListener('submit', function() {
                    const buttons = form.querySelectorAll('button[type="submit"], input[type="submit"]');
                    buttons.forEach(function(btn) {
                        btn.disabled = true;
                        btn.classList.add('opacity-50', 'cursor-not-allowed');
                    });
                }, { once: true });
            });
        });

        // Check for session messages on page load
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                showGlobalSuccessAlert('{{ session('success') }}');
            @endif

            @if(session('error'))
                showGlobalErrorAlert('{{ session('error') }}');
            @endif

            // Check for validation errors
            @if($errors->any())
                let errorMessage = '';
                @foreach($errors->all() as $error)
                    errorMessage += '{{ $error }} ';
                @endforeach
                showGlobalErrorAlert(errorMessage.trim());
            @endif
        });
    </script>

</body>

</html>
