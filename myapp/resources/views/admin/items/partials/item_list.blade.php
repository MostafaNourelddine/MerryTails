@forelse($items as $item)
<div x-data="{ showForm: false }"
    x-init="$watch('showForm', value => { if (!value) document.getElementById('overlay').style.display = 'none' })">
    <div id="item-card-{{ $item->id }}" class="rounded-xl bg-card"
        style="width:28rem;padding:1.2rem 3rem;margin-bottom:2rem">
        <div class="flex justify-center mb-4">
            @if($item->images->isNotEmpty())
            <img src="{{ asset('storage/' . $item->images->first()->image_path) }}" alt=""
                class="rounded-xl shadow-lg mt-8 mx-auto" style="width: 22rem;height:8rem">
            @else
            <div class="rounded-xl shadow-lg mt-8 mx-auto bg-gray-200 flex items-center justify-center"
                style="width: 22rem;height:8rem">
                <span class="text-description">No image</span>
            </div>
            @endif
        </div>
        <div class="flex justify-between items-center px-2" style="margin-top: 1rem;">
            <div class="text-2xl font-semibold text-title">{{ $item->name }}</div>
            <div id="edit-delete-{{ $item->id }}" class="flex items-center gap-4" style="opacity:0;margin-top:10px;">
                <button id="openEditItem-{{ $item->id }}" @click="showForm = true"
                    class="text-title px-4 py-2 rounded-xl">
                    <i class="fa-solid fa-pen"></i>
                </button>
                <button class="text-black px-4 py-2 rounded-xl" @click.prevent="
                            if (confirm('Are you sure you want to delete this item?')) {
                                window.location.href = '{{ route('admin.items.delete', $item->id) }}';
                            }">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </div>
        </div>
        <div class="text-description text-lg description-text" style="max-height: 4.5rem; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; text-overflow: ellipsis;">{{ $item->description }}</div>
        <div class="flex items-center justify-between px-2 text-description mt-2">
            <div>Price: ${{ $item->price }}</div>
            <div>Category: {{ $item->category->name ?? '-' }}</div>
        </div>
        <div class="flex items-center px-2 text-description mt-2">
            <div>Created: {{ $item->created_at }}</div>
        </div>
    </div>
    <!-- Edit Form -->
    <div x-show="showForm" x-cloak class="shadow-xl bg-card rounded-xl border border-cardBorder p-8 font-semibold"
        style="position:fixed;left:50%;top:50%;transform:translate(-50%, -50%);z-index:1000;">
        @include('admin.items.edit', ['item' => $item, 'categories' => App\Models\Category::all()])
    </div>
</div>
@empty
<div class="w-full text-center py-12">
    <i class="fa-solid fa-search text-4xl text-gray-300 mb-4"></i>
    <div class="text-gray-600 text-lg font-semibold">No items found</div>
    <div class="text-gray-500 mt-2">Try adjusting your search terms</div>
</div>
@endforelse

<!-- JavaScript functions are handled in the main index.blade.php file -->
