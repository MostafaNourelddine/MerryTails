<!-- CSRF Token for AJAX requests -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<div x-data="{showForm:false}">
    <div class="flex justify-between items-center p-4 px-20 border-b border-border mb-4">
        <div>
            <h1 class="text-2xl font-bold text-title">Categories</h1>
            <div class="text-description text-sm">Manage your Product categories</div>
        </div>
        <button @click="showForm = true" id="openCategory"
            class="flex items-center gap-4 text-title bg-accent2 px-4 py-2 rounded-xl">
            <i class="fas fa-plus text-title"></i>
            <div class="ml-4">Add Category</div>
        </button>
    </div>

    <div x-show="showForm" x-cloak class="flex items-center justify-center z-50"
        style="position:fixed;left:50%;top:50%;transform:translate(-50%, -50%);z-index:100;">
        <div class="bg-white rounded-xl shadow-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto p-8">


            <form action="{{ route('admin.categories.store') }}" id="category-form" method="POST"
                enctype="multipart/form-data">

                @csrf
                <div class="flex justify-between items-center" style="margin-bottom: 2rem;">
                    <div class="text-2xl text-title">Add New Category</div>
                    <div class="cursor-pointer text-xl px-4 py-2 hover:bg-accent2 rounded-xl text-description"
                        @click="showForm = false" id="CloseCategory">
                        <i class="fa-solid fa-xmark cursor-pointer"></i>
                    </div>
                </div>
                <div>
                    <label for="name" class="text-title">Name</label>
                    <br>
                    <input type="text" id="name" name="name"
                        class="bg-input px-4 py-2 rounded-xl focus:border-accent2 border-border"
                        placeholder="Category Name" style="width:20rem;" required>
                </div>
                <div class="mt-8" style="margin-top: 1rem;">
                    <label for="description" class="text-title">Description</label>
                    <br>
                    <textarea id="description" name="description"
                        class="bg-input px-4 py-2 rounded-xl focus:border-accent2 border-border"
                        placeholder="Category Description" style="width:20rem;height:100px;resize:vertical;" required></textarea>
                </div>
                <div class="" style="margin-top: 1rem;">
                    <label for="image_path" class="text-title">Image</label>
                    <br>
                    <input type="file" id="image_path" name="image_path" enctype="multipart/form-data"
                        class="bg-input px-4 py-2 rounded-xl focus:border-accent2 border-border" style="width:20rem;"
                        required>
                    <div class="mt-8 text-center" style="margin-top:2rem">
                        <button type="submit" class="bg-accent2 text-title px-4 py-2 rounded-xl">Create Category</button>
                    </div>
            </form>
        </div>
    </div>
</div>

<!-- Success Alert -->

<script>
// CSRF Token for AJAX requests
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
    document.querySelector('input[name="_token"]')?.value;

// Function to close the form modal
function closeCategoryForm() {


    // Try multiple methods to close the form

    // Method 1: Alpine.js event dispatch
    window.dispatchEvent(new CustomEvent('close-modal'));

    // Method 2: Look for Alpine.js showForm variable
    const formElement = document.querySelector('[x-data]');
    if (formElement) {
        // Try to set showForm to false if it exists
        try {
            if (formElement._x_dataStack && formElement._x_dataStack[0]) {
                formElement._x_dataStack[0].showForm = false;
            }
        } catch (e) {
            console.log('Could not close via Alpine.js:', e);
        }
    }

    // Method 3: Hide the form manually
    const formContainer = document.querySelector('.bg-white.rounded-2xl.shadow-xl');
    if (formContainer) {
        formContainer.style.display = 'none';
    }

    // Method 4: Trigger click on close button
    const closeButton = document.getElementById('CloseCategory');
    if (closeButton) {
        closeButton.click();
    }

    // Reset form after closing
    setTimeout(() => {
        document.getElementById('category-form').reset();
    }, 100);
}



// Handle form submission - Simple form submission
document.getElementById('category-form').addEventListener('submit', function(e) {
    // Let the form submit normally - server-side validation will handle errors
    // This will do a regular form submission with redirect and session flash
});

// Existing overlay functionality
let overlayer = document.getElementById('overlay');
let openCategory = document.getElementById('openCategory');
if (openCategory) {
    openCategory.addEventListener('click', function() {
        console.log('Open Category Clicked');
        if (overlayer) {
            overlayer.style.display = 'block';
        }
    });
}

const closeButton = document.getElementById('CloseCategory');
if (closeButton) {
    closeButton.addEventListener('click', function() {
        if (overlayer) {
            overlayer.style.display = 'none';
        }
        console.log('close Category Clicked');
    });
}
</script>
