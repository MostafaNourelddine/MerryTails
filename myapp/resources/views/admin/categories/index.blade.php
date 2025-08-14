       <div id="overlay"
           style="height:100vh;width:100%; background-color:rgb(0,0,0,0.6); position:absolute;z-index:90;display:none">
       </div>


       @extends('layout.app')

       @section('title', 'Admin Dashboard')

       @section('content')






       @include('admin.categories.createcategory')


       @include('admin.categories.showcategories')


       <style>
input, textarea {
    border: 2px solid #e5e7eb !important;
    transition: all 0.3s ease;
}

input:focus, textarea:focus {
    outline: none;
    border: 2px solid #FABEB3 !important;
    box-shadow: 0 0 5px rgba(250, 190, 179, 0.5);
}

input,
textarea {
    background-color: #f3f3f3a8;
    margin-top: 0.3rem;

}

textarea:focus {
    outline: 2px solid #FABEB3;

    box-shadow: 0 0 5px rgba(250, 190, 179, 0.5);
}

button:hover {
    background-color: rgba(250, 190, 179, 0.8);
}

[x-cloak] {
    display: none;
}

/* Force text wrapping for description cards */
.description-text {
    width: 22rem !important;
    word-wrap: break-word !important;
    overflow-wrap: break-word !important;
    white-space: normal !important;
    overflow: hidden !important;
    display: block !important;
}
       </style>

       <script>
document.addEventListener('DOMContentLoaded', () => {
    const overlay = document.getElementById('overlay');

    // Initialize hover effects
    initializeCategoryHoverEffects();

    // Show overlay when clicking any edit button
    const editButtons = document.querySelectorAll('[id^="openEditCategory-"]');
    editButtons.forEach(button => {
        button.addEventListener('click', () => {
            overlay.style.display = 'block';
        });
    });

    // Hide overlay when clicking any close button inside forms
    const closeButtons = document.querySelectorAll('[id^="CloseEditCategory-"]');
    closeButtons.forEach(button => {
        button.addEventListener('click', () => {
            overlay.style.display = 'none';
            // Close the specific form
            const form = button.closest('[x-data]');
            if (form && form._x_dataStack && form._x_dataStack[0] && form._x_dataStack[0].showForm !== undefined) {
                form._x_dataStack[0].showForm = false;
            }
        });
    });

    // Hide overlay and close category forms if user clicks on the overlay background itself
    overlay.addEventListener('click', () => {
        overlay.style.display = 'none';
        // Close category forms only
        const categoryForms = document.querySelectorAll('[x-data]');
        categoryForms.forEach(form => {
            if (form._x_dataStack && form._x_dataStack[0] && form._x_dataStack[0].showForm !== undefined) {
                form._x_dataStack[0].showForm = false;
            }
        });
    });

    // Enhanced search functionality
    const searchInput = document.getElementById('category-search-input');
    const categoryListContainer = document.getElementById('category-list-container');
    let timer = null;
    let originalContent = categoryListContainer ? categoryListContainer.innerHTML : '';

    if (searchInput && categoryListContainer) {
        // Handle input changes
        searchInput.addEventListener('input', function() {
            clearTimeout(timer);
            const query = this.value.trim();

            timer = setTimeout(() => {
                if (query.length === 0) {
                    // Restore original content when search is empty
                    categoryListContainer.innerHTML = originalContent;
                    initializeCategoryHoverEffects();
                    attachOverlayListeners();
                    return;
                }

                // Show loading state
                categoryListContainer.innerHTML = `
                    <div class="w-full text-center py-12">
                        <i class="fa-solid fa-spinner fa-spin text-3xl text-accent2 mb-4"></i>
                        <p class="text-description text-lg">Searching categories...</p>
                    </div>
                `;

                fetch(`/admin/categories/search?query=${encodeURIComponent(query)}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'text/html'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(
                                `HTTP ${response.status}: ${response.statusText}`);
                        }
                        return response.text();
                    })
                    .then(html => {
                        if (html.trim() === '') {
                            categoryListContainer.innerHTML = `
                            <div class="w-full text-center py-12">
                                <i class="fa-solid fa-search text-4xl text-gray-300 mb-4"></i>
                                <p class="text-gray-500 text-lg font-medium">No categories found</p>
                                <p class="text-gray-400 text-sm mt-2">Try adjusting your search terms</p>
                            </div>
                        `;
                        } else {
                            categoryListContainer.innerHTML = html;
                            // Re-initialize hover effects for new content
                            initializeCategoryHoverEffects();
                            // Re-attach overlay event listeners
                            attachOverlayListeners();
                        }
                    })
                    .catch(error => {
                        console.error('Search error:', error);
                        categoryListContainer.innerHTML = `
                        <div class="w-full text-center py-12">
                            <i class="fa-solid fa-exclamation-triangle text-4xl text-red-400 mb-4"></i>
                            <p class="text-red-600 text-lg font-medium">Search Error</p>
                            <p class="text-red-500 text-sm mt-2">${error.message}</p>
                            <button onclick="location.reload()" class="mt-4 bg-red-500 text-white px-4 py-2 rounded-xl hover:bg-red-600 transition-colors">
                                <i class="fa-solid fa-refresh mr-2"></i>Reload Page
                            </button>
                        </div>
                    `;
                    });
            }, 300); // Debounce delay
        });

        // Handle escape key to clear search
        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && this.value.length > 0) {
                this.value = '';
                categoryListContainer.innerHTML = originalContent;
                initializeCategoryHoverEffects();
                attachOverlayListeners();
            }
        });
    }
});

// Function to initialize hover effects (can be called after AJAX updates)
function initializeCategoryHoverEffects() {
    const cards = document.querySelectorAll('[id^="category-card-"]');
    cards.forEach(card => {
        const id = card.id.split('-').pop();
        const editDelete = document.getElementById(`edit-delete-${id}`);

        if (editDelete) {
            // Remove existing listeners to prevent duplicates
            card.removeEventListener('mouseenter', card.hoverInHandler);
            card.removeEventListener('mouseleave', card.hoverOutHandler);

            // Create and store handlers
            card.hoverInHandler = () => {
                editDelete.style.opacity = '1';
                card.style.transform = 'translateY(-5px)';
                card.style.boxShadow = '0 10px 20px rgba(0, 0, 0, 0.15)';
                card.style.transition = 'all 0.3s ease';
            };

            card.hoverOutHandler = () => {
                editDelete.style.opacity = '0';
                card.style.transform = 'translateY(0)';
                card.style.boxShadow = 'none';
                card.style.transition = 'all 0.3s ease';
            };

            // Add new listeners
            card.addEventListener('mouseenter', card.hoverInHandler);
            card.addEventListener('mouseleave', card.hoverOutHandler);
        }
    });
}

// Function to re-attach overlay listeners after AJAX updates
function attachOverlayListeners() {
    const overlay = document.getElementById('overlay');

    // Re-attach edit button listeners
    const editButtons = document.querySelectorAll('[id^="openEditCategory-"]');
    editButtons.forEach(button => {
        // Remove existing listener to prevent duplicates
        button.removeEventListener('click', button.overlayHandler);

        // Create and store handler
        button.overlayHandler = () => {
            overlay.style.display = 'block';
        };

        button.addEventListener('click', button.overlayHandler);
    });

    // Re-attach close button listeners
    const closeButtons = document.querySelectorAll('[id^="CloseEditCategory-"]');
    closeButtons.forEach(button => {
        // Remove existing listener to prevent duplicates
        button.removeEventListener('click', button.closeHandler);

        // Create and store handler
        button.closeHandler = () => {
            overlay.style.display = 'none';
        };

        button.addEventListener('click', button.closeHandler);
    });
}
       </script>
       @endsection
