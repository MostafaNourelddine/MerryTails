@extends('layout.app')
@section('title', 'Admin Dashboard')
@section('content')

<div class="min-h-screen bg-gray-50 p-8">
    <!-- Header Section -->
    <div class="flex justify-between items-center p-4 px-20 border-b border-border mb-20">
        <div>
            <h1 class="text-2xl font-bold text-title">Dashboard</h1>
            <div class="text-description text-sm">Welcome to your MerryTails admin dashboard. Monitor your store's
                performance, manage categories, items, and track your inventory in real-time.</div>
        </div>
    </div>

    <!-- Statistics Cards Flex -->
    <div class="flex justify-center animate-fade-in p-6">

        <!-- Total Categories Card -->
        <div class="bg-white rounded-xl shadow-sm hover:-translate-y-1 hover:shadow-lg transition-all duration-300 admin-shadow"
            style="animation-delay: 0ms; margin-left: 3rem; margin-right: 3rem; margin-top: 4rem; width: 350px; min-height: 150px;">
            <div class="p-8">
                <div class="flex items-center justify-between space-y-0 pb-2">
                    <h3 class="text-sm font-medium text-gray-900">Total Categories</h3>
                    <div class="p-2 bg-blue-500 bg-opacity-10 rounded-lg">
                        <i class="fa-solid fa-tag h-4 w-4 text-blue-500"></i>
                    </div>
                </div>
                <div class="space-y-1">
                    <div class="text-2xl font-bold text-gray-900">{{ $stats['categories']['count'] }}</div>
                    <p class="text-xs text-gray-600">Active categories</p>
                </div>
            </div>
        </div>

        <!-- Total Items Card -->
        <div class="bg-white rounded-xl shadow-sm hover:-translate-y-1 hover:shadow-lg transition-all duration-300 admin-shadow"
            style="animation-delay: 100ms; margin-left: 3rem; margin-right: 3rem; margin-top: 4rem; width: 350px; min-height: 150px;">
            <div class="p-8">
                <div class="flex items-center justify-between space-y-0 pb-2">
                    <h3 class="text-sm font-medium text-gray-900">Total Items</h3>
                    <div class="p-2 bg-green-500 bg-opacity-10 rounded-lg">
                        <i class="fa-solid fa-box h-4 w-4 text-green-500"></i>
                    </div>
                </div>
                <div class="space-y-1">
                    <div class="text-2xl font-bold text-gray-900">{{ $stats['items']['count'] }}</div>
                    <p class="text-xs text-gray-600">Items in inventory</p>
                </div>
            </div>
        </div>

        <!-- Total Images Card -->
        <div class="bg-white rounded-xl shadow-sm hover:-translate-y-1 hover:shadow-lg transition-all duration-300 admin-shadow"
            style="animation-delay: 200ms; margin-left: 3rem; margin-right: 3rem; margin-top: 4rem; width: 350px; min-height: 150px;">
            <div class="p-8">
                <div class="flex items-center justify-between space-y-0 pb-2">
                    <h3 class="text-sm font-medium text-gray-900">Total Images</h3>
                    <div class="p-2 bg-purple-500 bg-opacity-10 rounded-lg">
                        <i class="fa-solid fa-images h-4 w-4 text-purple-500"></i>
                    </div>
                </div>
                <div class="space-y-1">
                    <div class="text-2xl font-bold text-gray-900">{{ $stats['images']['count'] }}</div>
                    <p class="text-xs text-gray-600">Images uploaded</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Animation Classes */
.animate-fade-in {
    animation: fadeIn 0.6s ease-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Enhanced Card Shadows */
.admin-shadow {
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
}

.admin-shadow:hover {
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

/* Icon Sizing */
.h-4 {
    height: 1rem;
    width: 1rem;
}

.w-4 {
    width: 1rem;
}

/* Color Palette */
.bg-gray-50 {
    background-color: #FAFAFA;
}

.text-gray-900 {
    color: #0C0A09;
}

.text-gray-600 {
    color: #71717A;
}

.text-blue-500 {
    color: #3B82F6;
}

.text-green-500 {
    color: #10B981;
}

.text-purple-500 {
    color: #8B5CF6;
}

.bg-blue-500 {
    background-color: #3B82F6;
}

.bg-green-500 {
    background-color: #10B981;
}

.bg-purple-500 {
    background-color: #8B5CF6;
}

/* Smooth Transitions */
.transition-all {
    transition-property: all;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
}

.duration-300 {
    transition-duration: 300ms;
}

/* Hover Effects */
.hover\:-translate-y-1:hover {
    transform: translateY(-0.25rem);
}

.hover\:shadow-lg:hover {
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

/* Card Spacing and Layout */
.space-y-1>*+* {
    margin-top: 0.25rem;
}

.space-y-0>*+* {
    margin-top: 0;
}

.pb-2 {
    padding-bottom: 0.5rem;
}

/* Background Opacity */
.bg-opacity-10 {
    background-color: rgba(var(--bg-opacity-value), 0.1);
}

.bg-blue-500.bg-opacity-10 {
    background-color: rgba(59, 130, 246, 0.1);
}

.bg-green-500.bg-opacity-10 {
    background-color: rgba(16, 185, 129, 0.1);
}

.bg-purple-500.bg-opacity-10 {
    background-color: rgba(139, 92, 246, 0.1);
}

/* Text Classes from Items Page */
.text-title {
    color: #1f2937;
    /* Gray 800 */
}

.text-description {
    color: #6b7280;
    /* Gray 500 */
}

/* Border Classes */
.border-border {
    border-color: #e5e7eb;
    /* Gray 200 */
}
</style>

@endsection
