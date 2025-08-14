<!-- CSRF Token for AJAX requests -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="bg-white rounded-xl shadow-xl w-full max-h-[90vh] overflow-y-auto p-8 m-4"
    style="position:fixed;left:50%;top:50%;transform:translate(-50%, -50%);z-index:300;background-color:white;overflow-y:auto;display:flex;flex-direction:column;width:fit-content;">
    <div class="flex justify-between items-center mb-6">
        <div class="text-2xl font-bold">Edit Item</div>
        <button type="button" id="CloseItem" class="text-gray-500 hover:text-red-500 text-2xl p-2 rounded-xl"
            @click="showForm = false">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>




    <!-- Container div for both forms -->
    <div class="mx-4" style="flex:1;overflow-y:auto;max-height:70vh;">

        <!-- Form for inputs -->
        <form action="{{ route('admin.items.update', $item->id) }}" method="POST" enctype="multipart/form-data"
            id="itemForm">
            @csrf
            @method('PUT')

            <div class="">
                <!-- Hidden input for storing image IDs -->
                <input type="hidden" id="image_ids" name="image_ids" value="">

                <div>
                    <label for="category_id" class="text-title">Category</label>
                    <br>
                    <select id="category_id" name="category_id"
                        class="bg-input px-4 py-2 rounded-xl focus:border-accent2 border-border hover:bg-opacity-80"
                        style="width:40rem;background-color: #f3f3f3a8;margin-left:0.5rem;margin-right:0.5rem;"
                        required>
                        @foreach(App\Models\Category::all() as $category)
                        <option value="{{ $category->id }}"
                            {{ (old('category_id', $item->category_id) == $category->id) ? 'selected' : '' }}>
                            {{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mt-8" style="margin-top: 1rem;">
                    <label for="name" class="text-title">Name</label>
                    <br>
                    <input type="text" id="name" name="name"
                        class="bg-input px-4 py-2 rounded-xl focus:border-accent2 border-border" placeholder="Item Name"
                        style="width:40rem;margin-left:0.5rem;margin-right:0.5rem;" required
                        value="{{ old('name', $item->name) }}">
                </div>
                <div class="mt-8" style="margin-top: 1rem;">
                    <label for="description" class="text-title">Description</label>
                    <br>
                    <textarea id="description" name="description"
                        class="bg-input px-4 py-2 rounded-xl focus:border-accent2 border-border"
                        placeholder="Item Description" style="width:40rem;margin-left:0.5rem;margin-right:0.5rem;height:100px;resize:vertical;"
                        required>{{ old('description', $item->description) }}</textarea>
                </div>
                <div class="mt-8" style="margin-top: 1rem;">
                    <label for="price" class="text-title">Price ($)</label>
                    <br>
                    <input type="number" step="0.01" id="price" name="price"
                        class="bg-input px-4 py-2 rounded-xl focus:border-accent2 border-border" placeholder="0.00"
                        style="width:40rem;margin-left:0.5rem;margin-right:0.5rem;" required
                        value="{{ old('price', $item->price) }}">
                </div>
            </div>

            <div class="mt-8 text-center"
                style="margin-top:2rem;flex-shrink:0;padding-top:1rem;border-top:1px solid #e5e7eb;">
                <button type="submit" class="bg-accent2 text-title px-4 py-2 rounded-xl">Update Item</button>
            </div>
        </form>

        <div class="mt-8">
            <div class="mt-6 mb-8" style="margin-top: 2rem; margin-bottom: 1rem;">Images</div>

            <!-- Images Container -->
            <div class="rounded-xl border border-black p-6 mt-4" style="border:1px gray solid; padding:30px">
                <!-- Header -->
                <div class="text-title text-xl font-semibold mb-4 flex items-center gap-2" style="margin-bottom: 2rem;">
                    <i class="fa-solid fa-images"></i>
                    <span id="imageCounter">Item Images {{ $item->images->count() }}</span>
                </div>

                <!-- Form for adding images -->
                <form id="addImageForm" action="{{ route('admin.images.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="item_id" value="{{ $item->id }}">

                    <!-- Image URL Input -->
                    <div class="mb-4" style="margin-bottom: 6rem;">
                        <label for="image_url" class="block text-title font-medium mb-2">Image URL</label>
                        <div class="flex gap-2 items-center">
                            <input type="file" id="images" name="images[]" multiple accept="image/*"
                                class="flex-1 bg-input px-4 py-2 rounded-xl focus:border-accent2 border-border file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-accent2 file:text-title hover:file:bg-opacity-80"
                                style="margin-left:0.5rem;margin-right:0.5rem;border:2px solid #000000;">
                            <button type="submit"
                                class="bg-accent2 text-title px-4 py-2 rounded-xl hover:bg-opacity-80 transition-colors flex items-center"
                                style="margin-left: 0.5rem;">
                                <i class="fa-solid fa-plus" style="margin-right: 0.5rem;"></i>Add
                            </button>
                        </div>
                        <div id="selectedFilesInfo" class="text-sm text-gray-600 mt-2" style="display: none;">
                            <span id="selectedFilesCount">0</span> file(s) selected
                        </div>
                    </div>
                </form>

                <!-- Image Preview Carousel -->
                <div id="imageCarousel" class="relative" style="display: none;">
                    <!-- Image Container -->
                    <div class="flex items-center justify-center gap-2" style="min-height: 200px;">
                        <div id="imageTrack" class="flex items-center gap-2 transition-all duration-300 ease-in-out">
                            <!-- Images will be dynamically added here -->
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="flex items-center justify-center gap-4 mt-4">
                        <button type="button" id="prevBtn" onclick="previousImage()"
                            class="bg-gray-200 hover:bg-gray-300 text-gray-700 p-3 rounded-full transition-colors">
                            <i class="fa-solid fa-chevron-left"></i>
                        </button>

                        <!-- Image Counter -->
                        <span id="carouselCounter" class="text-gray-600 font-medium mx-4">1 / 1</span>

                        <button type="button" id="nextBtn" onclick="nextImage()"
                            class="bg-gray-200 hover:bg-gray-300 text-gray-700 p-3 rounded-full transition-colors">
                            <i class="fa-solid fa-chevron-right"></i>
                        </button>
                    </div>
                </div>

                <!-- Grid list showing ALL images (always 3 columns) -->
                <div id="imageGrid" style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-top:1rem;">
                    @if($item->images->count() > 0)
                    @foreach($item->images as $image)
                    <div class="image-preview active" data-image-id="{{ $image->id }}">
                        <img src="{{ asset('storage/' . $image->image_path) }}" alt="Item Image"
                            style="width: 100%; height: 100%; object-fit: cover;">
                        <div class="delete-overlay">
                            <form action="{{ route('admin.images.destroy', $image->id) }}" method="POST"
                                style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-btn"
                                    onclick="return confirm('Are you sure you want to delete this image?')">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <div class="text-gray-500 text-center py-4">No images uploaded yet</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>





<style>
.image-preview {
    position: relative;
    flex-shrink: 0;
    border-radius: 12px;
    overflow: hidden;
    cursor: pointer;
    transition: all 0.3s ease-in-out;
    min-height: 100px;
    border: 1px solid #e5e7eb;
}

.image-preview.preview {
    width: 100px;
    height: 75px;
    opacity: 0.5;
    transform: scale(0.9);
}

.image-preview.active {
    width: 200px;
    height: 150px;
    opacity: 1;
    transform: scale(1);
}

.image-preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.delete-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: flex-start;
    justify-content: flex-end;
    opacity: 0;
    transition: opacity 0.2s ease-in-out;
    padding: 12px;
}

.image-preview:hover .delete-overlay {
    opacity: 1;
}

.delete-btn {
    background: #ef4444;
    color: white;
    border: none;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: background-color 0.2s ease-in-out;
    font-size: 16px;
}

.delete-btn:hover {
    background: #dc2626;
}

#imageCarousel button:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

/* Custom Scrollbar Styling */
#itemForm::-webkit-scrollbar {
    width: 8px;
}

#itemForm::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

#itemForm::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 10px;
}

#itemForm::-webkit-scrollbar-thumb:hover {
    background: #555;
}

/* For Firefox */
#itemForm {
    scrollbar-width: thin;
    scrollbar-color: #888 #f1f1f1;
    padding-right: 12px;
    /* create a little space left of the scrollbar */
    scrollbar-gutter: stable;
    /* reserve space for scrollbar so content doesn't shift */
}

/* Ensure image grid is visible */
#imageGrid {
    display: grid !important;
    grid-template-columns: repeat(3, 1fr) !important;
    gap: 16px !important;
    margin-top: 1rem !important;
    min-height: 100px;
}
</style>

@php
$initialImages = $item->images->map(function ($img) {
return [
'id' => $img->id,
'url' => asset('storage/' . ltrim($img->image_path, '/')),
'name' => '',
];
})->values();

// Debug: Log the images for troubleshooting
\Log::info('Item images for item ' . $item->id . ':', $initialImages->toArray());
@endphp

<script>
// Global variables
let selectedImages = [];
let currentImageIndex = 0;
let uploadedImageIds = []; // Store IDs of uploaded images

// CSRF Token for AJAX requests
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
    document.querySelector('input[name="_token"]')?.value;
// Current item id for linking uploads
const itemId = {
    {
        (int) $item - > id
    }
};

// Seed initial images from server so they display immediately
const initialImages = @json($initialImages);

// Function to close the form modal
function closeForm() {

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
    const formContainer = document.querySelector('.bg-white.rounded-xl.shadow-xl');
    if (formContainer) {
        formContainer.style.display = 'none';
    }

    // Method 4: Trigger click on close button
    const closeButton = document.getElementById('CloseItem');
    if (closeButton) {
        closeButton.click();
    }

    // Reset form after closing
    setTimeout(() => {
        document.getElementById('itemForm').reset();
        selectedImages = [];
        uploadedImageIds = [];
        currentImageIndex = 0;
        updateImageCounter();
        renderImages();
    }, 100);
}



// Upload images via AJAX
async function uploadImages(files) {
    const formData = new FormData();

    // Add files to form data
    for (let file of files) {
        formData.append('images[]', file);
    }

    // Add CSRF token
    formData.append('_token', csrfToken);
    // Link uploads directly to this item when editing
    if (itemId) {
        formData.append('item_id', itemId);
    }

    try {
        console.log('Uploading images:', files.length, 'files');
        console.log('CSRF Token:', csrfToken);
        console.log('FormData contents:');
        for (let [key, value] of formData.entries()) {
            console.log(key, value);
        }

        const response = await fetch('/admin/images/store', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        });

        console.log('Upload response status:', response.status);

        if (!response.ok) {
            const errorText = await response.text();
            console.error('Upload error response:', errorText);
            throw new Error(`HTTP error! status: ${response.status}, response: ${errorText}`);
        }

        const result = await response.json();
        console.log('Upload result:', result);

        if (result.success) {
            // Add uploaded images to our arrays
            result.images.forEach(imageData => {
                console.log('Adding image:', imageData);
                selectedImages.push({
                    id: imageData.id,
                    url: imageData.url, // Use the full URL provided by the backend
                    name: imageData.name
                });
                uploadedImageIds.push(imageData.id);
            });

            console.log('Selected images:', selectedImages);
            console.log('Uploaded image IDs:', uploadedImageIds);

            // Update hidden input with image IDs
            updateImageIdsInput();

            // Re-render the carousel
            renderImages();
        } else {
            console.error('Upload failed:', result.message);
        }
    } catch (error) {
        console.error('Upload error:', error);
    }
}

// Delete image via AJAX
async function removeImage(index) {
    const imageToRemove = selectedImages[index];

    if (!imageToRemove.id) {
        // If it's a local image without an ID, just remove from array
        selectedImages.splice(index, 1);
        renderImages();
        return;
    }

    try {
        const response = await fetch(`/admin/images/${imageToRemove.id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json'
            }
        });

        const result = await response.json();

        if (result.success) {
            // Remove from arrays
            selectedImages.splice(index, 1);
            uploadedImageIds = uploadedImageIds.filter(id => id !== imageToRemove.id);

            // Update hidden input
            updateImageIdsInput();

            // Adjust current index if necessary
            if (selectedImages.length === 0) {
                currentImageIndex = 0;
            } else if (currentImageIndex >= selectedImages.length) {
                currentImageIndex = Math.max(0, selectedImages.length - 2);
                if (currentImageIndex % 2 !== 0 && currentImageIndex > 0) {
                    currentImageIndex -= 1;
                }
            }

            // Re-render images
            renderImages();
        } else {
            console.error('Delete failed:', result.message);
        }
    } catch (error) {
        console.error('Delete error:', error);
    }
}

// No JS deletion needed; deletion is handled via normal POST form per image

// Update the hidden input with current image IDs
function updateImageIdsInput() {
    // Keep this for backup, but main submission now uses FormData directly
    document.getElementById('image_ids').value = uploadedImageIds.join(',');
}

// Update image counter
function updateImageCounter() {
    document.getElementById('imageCounter').textContent = `Item Images (${selectedImages.length})`;
    if (selectedImages.length > 0) {
        const startIndex = currentImageIndex + 1;
        const endIndex = Math.min(currentImageIndex + 2, selectedImages.length);
        if (startIndex === endIndex) {
            document.getElementById('carouselCounter').textContent = `${startIndex} / ${selectedImages.length}`;
        } else {
            document.getElementById('carouselCounter').textContent =
                `${startIndex}-${endIndex} / ${selectedImages.length}`;
        }
    } else {
        document.getElementById('carouselCounter').textContent = '0 / 0';
    }
}

// Update carousel navigation buttons
function updateCarouselButtons() {
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');

    prevBtn.disabled = currentImageIndex === 0;
    nextBtn.disabled = currentImageIndex >= selectedImages.length - 1;
}

// Show/hide carousel
function showCarousel() {
    const carousel = document.getElementById('imageCarousel');
    if (selectedImages.length > 0) {
        carousel.style.display = 'block';
    } else {
        carousel.style.display = 'none';
    }
}

// Render images in carousel
function renderImages() {
    console.log('Rendering images:', selectedImages);

    // Always show all images in a grid
    const grid = document.getElementById('imageGrid');
    console.log('Image grid element in renderImages:', grid);

    if (grid) {
        grid.innerHTML = '';

        if (selectedImages.length === 0) {
            console.log('No images to render');
            grid.innerHTML = '<div class="text-gray-500 text-center py-4">No images uploaded yet</div>';
            return;
        }

        selectedImages.forEach((img, index) => {
            console.log('Rendering image:', img);
            const imageDiv = document.createElement('div');
            imageDiv.className = 'image-preview active';
            imageDiv.setAttribute('data-image-id', String(img.id || ''));
            imageDiv.innerHTML = `
                <img src="${img.url}" alt="Image ${index + 1}" onerror="console.error('Failed to load image:', '${img.url}')">
                <div class="delete-overlay">
                    <button type="button" class="delete-btn" onclick="submitDelete(${img.id})">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </div>
            `;
            grid.appendChild(imageDiv);
            console.log('Added image div to grid:', imageDiv);
        });
    } else {
        console.error('Image grid element not found');
    }

    // Hide the carousel UI since we now render all images
    const carousel = document.getElementById('imageCarousel');
    if (carousel) {
        carousel.style.display = 'none';
    }

    updateImageCounter();
}

// Get visible images for carousel
function getVisibleImages() {
    const visible = [];

    // Left preview (if exists)
    if (currentImageIndex > 0) {
        visible.push({
            index: currentImageIndex - 1,
            type: 'preview'
        });
    }

    // Main active images (2 images)
    if (currentImageIndex < selectedImages.length) {
        visible.push({
            index: currentImageIndex,
            type: 'active'
        });
    }
    if (currentImageIndex + 1 < selectedImages.length) {
        visible.push({
            index: currentImageIndex + 1,
            type: 'active'
        });
    }

    // Right preview (if exists)
    if (currentImageIndex + 2 < selectedImages.length) {
        visible.push({
            index: currentImageIndex + 2,
            type: 'preview'
        });
    }

    return visible;
}

// Navigation functions
function nextImage() {
    if (currentImageIndex + 2 < selectedImages.length) {
        currentImageIndex += 2;
    } else if (currentImageIndex + 1 < selectedImages.length) {
        currentImageIndex += 1;
    }
    renderImages();
}

function previousImage() {
    if (currentImageIndex >= 2) {
        currentImageIndex -= 2;
    } else {
        currentImageIndex = 0;
    }
    renderImages();
}

// Handle form submission - Simple form submission like categories
document.getElementById('itemForm').addEventListener('submit', function(e) {
    // Check if item name is filled (client-side validation)
    const itemName = document.getElementById('name').value.trim();
    if (!itemName) {
        e.preventDefault();
        return;
    }

    // Update image IDs field before form submission
    const imgIdsInput = document.getElementById('image_ids');
    if (imgIdsInput) {
        imgIdsInput.value = JSON.stringify(uploadedImageIds || []);
    }

    // Form submits normally (no e.preventDefault() here)
    console.log('Submitting form with image IDs:', uploadedImageIds);
});

// Handle file input change - Show selected files info
document.getElementById('images').addEventListener('change', function(e) {
    const files = Array.from(e.target.files);
    const selectedFilesInfo = document.getElementById('selectedFilesInfo');
    const selectedFilesCount = document.getElementById('selectedFilesCount');

    if (files.length === 0) {
        selectedFilesInfo.style.display = 'none';
        return;
    }

    // Validate files
    const validFiles = files.filter(file => {
        if (!file.type.startsWith('image/')) {
            console.error(`${file.name} is not an image file.`);
            return false;
        }
        if (file.size > 2048 * 1024) { // 2MB limit
            console.error(`${file.name} is too large. Maximum size is 2MB.`);
            return false;
        }
        return true;
    });

    // Show selected files info
    selectedFilesCount.textContent = validFiles.length;
    selectedFilesInfo.style.display = 'block';
});

// Function to upload selected images when +Add button is clicked
async function uploadSelectedImages() {
    const fileInput = document.getElementById('images');
    const files = Array.from(fileInput.files);

    if (files.length === 0) {
        console.error('Please select images first!');
        return;
    }

    // Validate files
    const validFiles = files.filter(file => {
        if (!file.type.startsWith('image/')) {
            console.error(`${file.name} is not an image file.`);
            return false;
        }
        if (file.size > 2048 * 1024) { // 2MB limit
            console.error(`${file.name} is too large. Maximum size is 2MB.`);
            return false;
        }
        return true;
    });

    if (validFiles.length === 0) {
        return;
    }

    // Upload images to database
    await uploadImagesToDatabase(validFiles);
}

// Function to upload images directly to database
async function uploadImagesToDatabase(files) {
    const formData = new FormData();

    // Add files to form data
    for (let file of files) {
        formData.append('images[]', file);
    }

    // Add CSRF token and item ID
    formData.append('_token', csrfToken);
    formData.append('item_id', itemId);

    try {
        console.log('Uploading images to database:', files.length, 'files');

        const response = await fetch('/admin/images/store', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        });

        if (!response.ok) {
            const errorText = await response.text();
            console.error('Upload error response:', errorText);
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const result = await response.json();
        console.log('Upload result:', result);

        if (result.success) {
            // Reset file input and hide selected files info
            document.getElementById('images').value = '';
            document.getElementById('selectedFilesInfo').style.display = 'none';

            // Reload the page to show the new images
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        } else {
            console.error('Upload failed:', result.message);
        }
    } catch (error) {
        console.error('Upload error:', error);
    }
}

// Initialize
document.addEventListener('DOMContentLoaded', async function() {
    console.log('DOM loaded, initializing...');
    console.log('Initial images from server:', initialImages);
    console.log('Image grid element:', document.getElementById('imageGrid'));
    console.log('Item ID:', itemId);

    // Test if we can access the item images directly
    console.log('Testing direct item access...');

    // Use initial images immediately
    try {
        if (Array.isArray(initialImages) && initialImages.length > 0) {
            selectedImages = initialImages.slice();
            uploadedImageIds = initialImages.map(img => img.id);
            currentImageIndex = 0;
            console.log('Setting initial images:', selectedImages);
            console.log('Selected images count:', selectedImages.length);
            renderImages();
        } else {
            console.log('No initial images found, will try API');
            // Try to load from API if no initial images
            await reloadImagesFromServer();
        }
    } catch (e) {
        console.error('Failed to seed initial images', e);
        // Fallback to API
        await reloadImagesFromServer();
    }

    updateImageCounter();

    // Verify CSRF token
    console.log('CSRF Token on page load:', csrfToken);

    // Add CSRF token to meta tag if not present
    if (!document.querySelector('meta[name="csrf-token"]')) {
        const meta = document.createElement('meta');
        meta.name = 'csrf-token';
        meta.content = csrfToken;
        document.head.appendChild(meta);
        console.log('Added CSRF meta tag');
    }

    // Fallback: Force render images after a short delay to ensure they display
    setTimeout(() => {
        console.log('Fallback: Forcing image render');
        console.log('Current selectedImages:', selectedImages);
        renderImages();

        // If still no images, add a test image to verify rendering works
        if (selectedImages.length === 0) {
            console.log('Adding test image to verify rendering...');
            selectedImages.push({
                id: 'test',
                url: 'https://via.placeholder.com/200x150/cccccc/666666?text=Test+Image',
                name: 'Test Image'
            });
            renderImages();
        }
    }, 500);


});

async function reloadImagesFromServer() {
    try {
        console.log('Reloading images from server for item:', itemId);
        const res = await fetch(`/admin/items/${itemId}/images`);
        console.log('API response status:', res.status);

        if (!res.ok) {
            console.error('API request failed:', res.status, res.statusText);
            return;
        }

        const data = await res.json();
        console.log('API response data:', data);

        if (data.success && Array.isArray(data.images)) {
            selectedImages = data.images.map(img => ({
                id: img.id,
                url: img.url,
                name: ''
            }));
            uploadedImageIds = data.images.map(img => img.id);
            currentImageIndex = 0;
            console.log('Loaded images from API:', selectedImages);
            renderImages();
        } else {
            console.log('No images found in API response or invalid format');
        }
    } catch (e) {
        console.error('Failed to reload item images', e);
    }
}

// Helper to submit deletion via AJAX to avoid form conflicts
async function submitDelete(imageId) {
    if (!confirm('Delete this image?')) return;

    try {
        const response = await fetch(`/admin/images/${imageId}/delete`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json'
            }
        });

        const result = await response.json();

        if (result.success) {
            // Remove from arrays
            selectedImages = selectedImages.filter(img => img.id !== imageId);
            uploadedImageIds = uploadedImageIds.filter(id => id !== imageId);

            // Update hidden input
            updateImageIdsInput();

            // Re-render images
            renderImages();
        } else {
            console.error('Delete failed:', result.message);
        }
    } catch (error) {
        console.error('Delete error:', error);
    }
}
</script>
