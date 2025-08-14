<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - MerryTails</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#FABEB3',
                        'primary-soft': '#FCE7F3',
                        accent2: '#FABEB3',
                        title: '#1F2937',
                        description: '#6B7280',
                        card: '#FFFFFF',
                        border: '#E5E7EB',
                        input: '#F9FAFB',
                    }
                }
            }
        }
    </script>
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #FABEB3 0%, #FCE7F3 50%, #FABEB3 100%);
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .input-focus {
            transition: all 0.3s ease;
        }

        .input-focus:focus {
            outline: none;
            border: 2px solid #FABEB3;
            box-shadow: 0 0 20px rgba(250, 190, 179, 0.3);
            transform: translateY(-2px);
        }

        .btn-hover {
            transition: all 0.3s ease;
        }

        .btn-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(250, 190, 179, 0.4);
        }

        .floating-animation {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .pulse-glow {
            animation: pulse-glow 2s ease-in-out infinite alternate;
        }

        @keyframes pulse-glow {
            from { box-shadow: 0 0 20px rgba(250, 190, 179, 0.3); }
            to { box-shadow: 0 0 30px rgba(250, 190, 179, 0.6); }
        }
    </style>
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center p-4">
    <!-- Background decorative elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 left-20 w-32 h-32 bg-white/10 rounded-full floating-animation"></div>
        <div class="absolute bottom-20 right-20 w-24 h-24 bg-white/10 rounded-full floating-animation" style="animation-delay: -2s;"></div>
        <div class="absolute top-1/2 left-10 w-16 h-16 bg-white/10 rounded-full floating-animation" style="animation-delay: -4s;"></div>
        <div class="absolute top-1/3 right-10 w-20 h-20 bg-white/10 rounded-full floating-animation" style="animation-delay: -1s;"></div>
    </div>

    <!-- Main Login Container -->
    <div class="glass-effect rounded-3xl shadow-2xl p-8 w-full max-w-md pulse-glow">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-gradient-to-br from-primary to-primary-soft rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                <i class="fas fa-shield-alt text-white text-3xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-title mb-2">Admin Access</h1>
            <p class="text-description">Enter your credentials to continue</p>
        </div>

        <!-- Success Message -->
        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
        </div>
        @endif

        <!-- Error Message -->
        @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6 flex items-center">
            <i class="fas fa-exclamation-circle mr-2"></i>
            {{ $errors->first() }}
        </div>
        @endif

        <!-- Login Form -->
        <form method="POST" action="{{ route('admin.login') }}" class="space-y-6">
            @csrf

            <!-- Username Field -->
            <div class="space-y-2">
                <label for="username" class="block text-sm font-medium text-title">
                    <i class="fas fa-user mr-2 text-primary"></i>Username
                </label>
                <div class="relative">
                    <input
                        type="text"
                        id="username"
                        name="username"
                        value="{{ old('username') }}"
                        class="w-full px-4 py-3 bg-input border-2 border-border rounded-xl input-focus text-title placeholder-description"
                        placeholder="Enter your username"
                        required
                        autocomplete="username"
                    >
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <i class="fas fa-user text-description"></i>
                    </div>
                </div>
            </div>

            <!-- Password Field -->
            <div class="space-y-2">
                <label for="password" class="block text-sm font-medium text-title">
                    <i class="fas fa-lock mr-2 text-primary"></i>Password
                </label>
                <div class="relative">
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="w-full px-4 py-3 bg-input border-2 border-border rounded-xl input-focus text-title placeholder-description pr-10"
                        placeholder="Enter your password"
                        required
                        autocomplete="current-password"
                    >
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <i class="fas fa-lock text-description"></i>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <button
                type="submit"
                class="w-full bg-gradient-to-r from-primary to-primary-soft text-white font-semibold py-3 px-6 rounded-xl btn-hover flex items-center justify-center"
            >
                <i class="fas fa-sign-in-alt mr-2"></i>
                Sign In
            </button>
        </form>

        <!-- Footer -->
        <div class="text-center mt-8 pt-6 border-t border-border">
            <p class="text-sm text-description">
                <i class="fas fa-shield-alt mr-1"></i>
                Secure Admin Access
            </p>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Add some interactive effects
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('input');
            const form = document.querySelector('form');

            // Add focus effects
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('scale-105');
                });

                input.addEventListener('blur', function() {
                    this.parentElement.classList.remove('scale-105');
                });
            });

            // Form submission animation
            form.addEventListener('submit', function() {
                const button = this.querySelector('button[type="submit"]');
                button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Signing In...';
                button.disabled = true;
            });
        });
    </script>
</body>
</html>

