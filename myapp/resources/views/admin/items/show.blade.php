@extends('layout.app')
@section('title', 'Item Details')
@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow">
    <h2 class="text-2xl font-bold mb-6">Item Details</h2>
    <div class="mb-4">
        <span class="font-semibold">Name:</span> {{ $item->name }}
    </div>
    <div class="mb-4">
        <span class="font-semibold">Description:</span> {{ $item->description }}
    </div>
    <div class="mb-4">
        <span class="font-semibold">Price:</span> ${{ $item->price }}
    </div>
    <div class="mb-4">
        <span class="font-semibold">Category:</span> {{ $item->category->name ?? '-' }}
    </div>

    <div class="mb-6">
        <span class="font-semibold">Images:</span>
        @if($item->images->isNotEmpty())
        <div class="flex flex-wrap gap-4 mt-2">
            @foreach($item->images as $img)
            <img src="{{ asset('storage/' . $img->image_path) }}" alt="Image"
                class="w-24 h-24 object-cover rounded shadow">
            @endforeach
        </div>
        @else
        <span class="text-description">No images</span>
        @endif
    </div>
    <div class="flex justify-end space-x-2">
        <a href="{{ route('admin.items.edit', $item->id) }}"
            class="bg-yellow-500 text-white px-4 py-2 rounded-xl shadow hover:bg-yellow-600 transition">Edit</a>
        <a href="{{ route('admin.items.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-xl">Back to
            List</a>
    </div>
</div>
@endsection
