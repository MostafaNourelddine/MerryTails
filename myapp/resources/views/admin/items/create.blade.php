<!-- CSRF Token for AJAX requests -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="bg-white rounded-xl shadow-xl w-full max-h-[90vh] overflow-y-auto p-8 m-4"
    style="position:fixed;left:50%;top:50%;transform:translate(-50%, -50%);z-index:300;background-color:white;overflow-y:auto;display:flex;flex-direction:column;width:fit-content;">
    <div class="flex justify-between items-center mb-6">
        <div class="text-2xl font-bold">Add New Item</div>
        <button type="button" id="CloseItem" class="text-gray-500 hover:text-red-500 text-2xl p-2 rounded-xl"
            @click="showForm = false">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>


    <form action="{{ route('admin.items.store') }}" method="POST" enctype="multipart/form-data" id="itemForm"
        class="mx-4" style="flex:1;overflow-y:auto;max-height:70vh;">
        @csrf

        <div class="">
            <!-- Hidden input for storing image IDs -->
            <input type="hidden" id="image_ids" name="image_ids" value="">

            <div>
                <label for="category_id" class="text-title">Category</label>
                <br>
                <select id="category_id" name="category_id"
                    class="bg-input px-4 py-2 rounded-xl focus:border-accent2 border-border hover:bg-opacity-80"
                    style="width:40rem;background-color: #f3f3f3a8;margin-left:0.5rem;margin-right:0.5rem;" required>
                    @foreach(App\Models\Category::all() as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mt-8" style="margin-top: 1rem;">
                <label for="name" class="text-title">Name</label>
                <br>
                <input type="text" id="name" name="name"
                    class="bg-input px-4 py-2 rounded-xl focus:border-accent2 border-border" placeholder="Item Name"
                    style="width:40rem;margin-left:0.5rem;margin-right:0.5rem;" required>
            </div>
            <div class="mt-8" style="margin-top: 1rem;">
                <label for="description" class="text-title">Description</label>
                <br>
                <textarea id="description" name="description"
                    class="bg-input px-4 py-2 rounded-xl focus:border-accent2 border-border"
                    placeholder="Item Description" style="width:40rem;margin-left:0.5rem;margin-right:0.5rem;height:100px;resize:vertical;"
                    required></textarea>
            </div>
            <div class="mt-8" style="margin-top: 1rem;">
                <label for="price" class="text-title">Price ($)</label>
                <br>
                <input type="number" step="0.01" id="price" name="price"
                    class="bg-input px-4 py-2 rounded-xl focus:border-accent2 border-border" placeholder="0.00"
                    style="width:40rem;margin-left:0.5rem;margin-right:0.5rem;" required>
            </div>


        </div>
        <div>
            <div class="mt-6 mb-8" style="margin-top: 2rem; margin-bottom: 1rem;">Images</div>

            <!-- Images Container -->
            <div class="rounded-xl border border-black p-6 mt-4" style="border:1px gray solid; padding:30px">
                <!-- Header -->
                <div class="text-title text-xl font-semibold mb-4 flex items-center gap-2" style="margin-bottom: 2rem;">
                    <i class="fa-solid fa-images"></i>
                    <span id="imageCounter">Item Images (0)</span>
                </div>

                <!-- Image URL Input -->
                <div class="mb-4" style="margin-bottom: 6rem;">
                    <label for="image_url" class="block text-title font-medium mb-2">Image URL</label>
                    <div class="flex gap-2 items-center">
                        <input type="file" id="images" name="images[]" multiple accept="image/*"
                            class="flex-1 bg-input px-4 py-2 rounded-xl focus:border-accent2 border-border file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-accent2 file:text-title hover:file:bg-opacity-80"
                            style="margin-left:0.5rem;margin-right:0.5rem;">
                        <button type="button" onclick="document.getElementById('images').click()"
                            class="bg-accent2 text-title px-4 py-2 rounded-xl hover:bg-opacity-80 transition-colors flex items-center"
                            style="margin-left: 0.5rem;">
                            <i class="fa-solid fa-plus" style="margin-right: 0.5rem;"></i>Add
                        </button>
                    </div>
                </div>

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
            </div>
        </div>

        <div class="mt-8 text-center"
            style="margin-top:2rem;flex-shrink:0;padding-top:1rem;border-top:1px solid #e5e7eb;">
            <button type="submit" class="bg-accent2 text-title px-4 py-2 rounded-xl">Create Item</button>
        </div>
    </form>
</div>



<style>
.image-preview {
    position: relative;
    flex-shrink: 0;
    border-radius: 12px;
    overflow: hidden;
    cursor: pointer;
    transition: all 0.3s ease-in-out;
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
</style>

<script>
// Global variables
let selectedImages = []; // Store selected files before upload
let currentImageIndex = 0;
let uploadedImageIds = []; // Store IDs of uploaded images
let selectedFiles = []; // Store the actual File objects

// CSRF Token for AJAX requests
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
    document.querySelector('input[name="_token"]')?.value;

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

        // Revoke all object URLs to free memory
        selectedImages.forEach(img => {
            if (img.url && img.url.startsWith('blob:')) {
                URL.revokeObjectURL(img.url);
            }
        });

        selectedImages = [];
        selectedFiles = [];
        uploadedImageIds = [];
        currentImageIndex = 0;
        updateImageCounter();
        renderImages();
    }, 100);
}



// Add selected files to the form (without uploading)
function addSelectedFiles(files) {
    files.forEach(file => {
        // Create a preview URL for the file
        const imageUrl = URL.createObjectURL(file);

        // Add to selectedImages array with temporary data
        selectedImages.push({
            id: null, // No ID yet since not uploaded
            url: imageUrl,
            name: file.name,
            file: file // Store the actual file object
        });

        // Add to selectedFiles array
        selectedFiles.push(file);
    });

    // Re-render the carousel
    renderImages();
    updateImageCounter();
}

// Remove image from form (before upload)
function removeImage(index) {
    const imageToRemove = selectedImages[index];

    // Revoke the object URL to free memory
    if (imageToRemove.url && imageToRemove.url.startsWith('blob:')) {
        URL.revokeObjectURL(imageToRemove.url);
    }

    // Remove from selectedImages array
    selectedImages.splice(index, 1);

    // Remove from selectedFiles array if it exists
    if (imageToRemove.file) {
        const fileIndex = selectedFiles.findIndex(file => file === imageToRemove.file);
        if (fileIndex !== -1) {
            selectedFiles.splice(fileIndex, 1);
        }
    }

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
    updateImageCounter();
}

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
    const imageTrack = document.getElementById('imageTrack');
    imageTrack.innerHTML = '';

    const imagesToShow = getVisibleImages();

    imagesToShow.forEach((imageInfo) => {
        const imageDiv = document.createElement('div');
        imageDiv.className = `image-preview ${imageInfo.type}`;
        imageDiv.innerHTML = `
            <img src="${selectedImages[imageInfo.index].url}" alt="Preview ${imageInfo.index + 1}">
            <div class="delete-overlay">
                <button type="button" class="delete-btn" onclick="removeImage(${imageInfo.index})">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </div>
        `;
        imageTrack.appendChild(imageDiv);
    });

    updateImageCounter();
    updateCarouselButtons();
    showCarousel();
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

// Handle form submission - Upload images and submit form
document.getElementById('itemForm').addEventListener('submit', async function(e) {
    e.preventDefault(); // Prevent default form submission

    // Show loading state
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.textContent;
    submitBtn.textContent = 'Uploading...';
    submitBtn.disabled = true;

    try {
        // Upload images first if there are any
        if (selectedFiles.length > 0) {
            const formData = new FormData();

            // Add files to form data
            for (let file of selectedFiles) {
                formData.append('images[]', file);
            }

            // Add CSRF token
            formData.append('_token', csrfToken);

            const response = await fetch('/admin/images/store', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            if (!response.ok) {
                throw new Error(`Upload failed: ${response.status}`);
            }

            const result = await response.json();

            if (result.success) {
                // Store the uploaded image IDs
                uploadedImageIds = result.images.map(img => img.id);
            } else {
                throw new Error(result.message || 'Upload failed');
            }
        }

        // Update hidden input with image IDs
        document.getElementById('image_ids').value = JSON.stringify(uploadedImageIds);

        // Now submit the form normally
        this.submit();

    } catch (error) {
        console.error('Form submission error:', error);
        alert('Error uploading images: ' + error.message);

        // Reset button state
        submitBtn.textContent = originalText;
        submitBtn.disabled = false;
    }
});

// Handle file input change
document.getElementById('images').addEventListener('change', function(e) {
    const files = Array.from(e.target.files);

    if (files.length === 0) return;

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

    if (validFiles.length > 0) {
        addSelectedFiles(validFiles);
    }

    // Reset the file input
    this.value = '';
});

// Initialize
document.addEventListener('DOMContentLoaded', function() {
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

    // Test if we can access the image upload route
    console.log('Testing image upload route accessibility...');
});
</script>
