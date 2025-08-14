@foreach($categories as $category)
<div x-data="{ showForm: false }">
    <div id="category-card-{{ $category->id }}" class="rounded-xl bg-card"
        style="width:28rem;padding:1.2rem 3rem;margin-bottom:2rem">

        <img src="{{ asset($category->image_path) }}" alt="" class="rounded-xl shadow-lg mt-8 mx-auto"
            style="width: 22rem;height:8rem">

        <div class="flex justify-between items-center px-2" style="margin-top: 1rem;">
            <div class="text-2xl font-semibold text-title">{{ $category->name }}</div>

            <div id="edit-delete-{{ $category->id }}" class="flex items-center gap-4"
                style="opacity:0;margin-top:10px;">
                <button id="openEditCategory-{{ $category->id }}" @click="showForm = true"
                    class="text-title px-4 py-2 rounded-xl">
                    <i class="fa-solid fa-pen"></i>
                </button>
                <button class="text-black px-4 py-2 rounded-xl" @click.prevent="
                            if (confirm('Are you sure you want to delete this category?')) {
                                window.location.href = '{{ route('admin.categories.delete', $category->id) }}';
                            }">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </div>
        </div>

        <div class="text-description text-lg description-text" style="max-height: 4.5rem; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; text-overflow: ellipsis; width: 22rem; word-wrap: break-word; overflow-wrap: break-word;">{{ $category->description }}</div>

        <div class="flex items-center justify-between px-2 text-description">
            <div>created at: {{ $category->created_at }}</div>
            <div><i class="fa-solid fa-image" title="Image"></i></div>
        </div>
    </div>

    <!-- Edit Form -->
    <div x-show="showForm" x-cloak class="shadow-xl bg-white rounded-xl p-8 font-semibold"
        style="position:fixed;left:50%;top:50%;transform:translate(-50%, -50%);z-index:100;">
        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div class="flex justify-between items-center" style="margin-bottom: 2rem;">
                <div class="text-2xl text-title">Edit Category</div>
                <div class="cursor-pointer text-xl px-4 py-2 hover:bg-accent2 rounded-xl text-description"
                    @click="showForm = false;" id="CloseEditCategory-{{ $category->id }}">
                    <i class="fa-solid fa-xmark cursor-pointer"></i>
                </div>
            </div>

            <div>
                <label for="name" class="text-title">Name</label><br>
                <input type="text" id="name" name="name"
                    class="bg-input px-4 py-2 rounded-xl focus:border-accent2 border-border" placeholder="Category Name"
                    style="width:20rem;" required value="{{ $category->name }}">
            </div>

            <div class="mt-8" style="margin-top: 1rem;">
                <label for="description" class="text-title">Description</label><br>
                <textarea id="description" name="description"
                    class="bg-input px-4 py-2 rounded-xl focus:border-accent2 border-border"
                    placeholder="Category Description" style="width:20rem;height:100px;resize:vertical;"
                    required>{{ $category->description }}</textarea>
            </div>

            <div style="margin-top: 1rem;">
                <label for="image_path" class="text-title">Image</label><br>
                <input type="file" id="image_path" name="image_path"
                    class="bg-input px-4 py-2 rounded-xl focus:border-accent2 border-border" style="width:20rem;">
                <div class="flex justify-center" style="margin-top:1.5rem">
                    <img src="{{ asset($category->image_path) }}" alt=""
                        class="rounded-xl shadow-lg mt-8 mx-auto text-center" style="width: 17rem;height:8rem">
                </div>
                <div class="mt-8 text-center" style="margin-top:2rem">
                    <button class="bg-accent2 text-title px-4 py-2 rounded-xl">Update Category</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endforeach

<!-- JavaScript functions are handled in the main index.blade.php file -->
