@extends('layout.app')
@section('title', 'Items Management')
@section('content')

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
</style>



<div id="overlay"
    style="height:100vh;width:100vw; background-color:rgb(0,0,0,0.6); position:fixed;top:0;left:0;z-index:100;display:none">
</div>

<div x-data="{showForm:false}">
    <div class="flex justify-between items-center p-4 px-20 border-b border-border mb-4">
        <div>
            <h1 class="text-2xl font-bold text-title">Items</h1>
            <div class="text-description text-sm">Manage your Product Items</div>
        </div>
        <button @click="showForm = true" id="openItem"
            class="flex items-center gap-4 text-title bg-accent2 px-4 py-2 rounded-xl">
            <i class="fas fa-plus text-title"></i>
            <div class="ml-4">Add Item</div>
        </button>
    </div>
    <div x-show="showForm" x-cloak class="shadow-xl bg-card rounded-xl border border-cardBorder p-8 font-semibold"
        style="position:fixed;left:50%;top:50%;transform:translate(-50%, -50%);z-index:300;">
        @include('admin.items.create')
    </div>
</div>

<div class="p-8 bg-card shadow-lg rounded-xl font-semibold" style="margin-bottom: 6rem;">
    <input type="text" id="item-search-input" name="Search"
        class="w-[100%] bg-input px-4 py-2 rounded-xl focus:border-accent2 border-border" placeholder="Search Items..."
        style="width:100%;">
</div>

<div id="item-list-container" class="flex flex-wrap" style="flex-wrap:wrap;justify-content:space-around">
    @forelse($items as $item)
    <div x-data="{ showForm: false }"
        x-init="$watch('showForm', value => { if (!value) document.getElementById('overlay').style.display = 'none' })">
        <div id="item-card-{{ $item->id }}" class="rounded-xl bg-card"
            style="width:fit-content;padding:1.2rem 3rem;margin-bottom:2rem">
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
                <div id="edit-delete-{{ $item->id }}" class="flex items-center gap-4"
                    style="opacity:0;margin-top:10px;">
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
        <div x-show="showForm" x-cloak class="shadow-xl bg-card rounded-xl p-8 font-semibold">
            @include('admin.items.edit', ['item' => $item, 'categories' => App\Models\Category::all()])
        </div>
    </div>
    @empty
    <div class="w-full text-center py-16">
        <i class="fa-solid fa-box-open text-5xl text-gray-300 mb-4"></i>
        <div class="text-gray-600 text-xl font-semibold">No items yet</div>
        <div class="text-gray-500 mt-2">Click "Add Item" to create your first item.</div>
    </div>
    @endforelse
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const overlay = document.getElementById('overlay');
    // Hover effect for each item card
    const cards = document.querySelectorAll('[id^="item-card-"]');
    cards.forEach(card => {
        const id = card.id.split('-').pop();
        const editDelete = document.getElementById(`edit-delete-${id}`);
        card.addEventListener('mouseenter', () => {
            editDelete.style.opacity = '1';
            card.style.transform = 'translateY(-5px)';
            card.style.boxShadow = '0 10px 20px rgba(0, 0, 0, 0.15)';
            card.style.transition = 'all 0.3s ease';
        });
        card.addEventListener('mouseleave', () => {
            editDelete.style.opacity = '0';
            card.style.transform = 'translateY(0)';
            card.style.boxShadow = 'none';
            card.style.transition = 'all 0.3s ease';
        });
    });
    // Show overlay when clicking "Add Item" button
    const addItemButton = document.getElementById('openItem');
    if (addItemButton) {
        addItemButton.addEventListener('click', () => {
            overlay.style.display = 'block';
        });
    }

    // Show overlay when clicking any edit button
    const editButtons = document.querySelectorAll('[id^="openEditItem-"]');
    editButtons.forEach(button => {
        button.addEventListener('click', () => {
            overlay.style.display = 'block';
        });
    });

    // Hide overlay when clicking any close button inside forms
    const closeButtons = document.querySelectorAll('[id^="CloseEditItem-"], #CloseItem');
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

    // Hide overlay and close item forms if user clicks on the overlay background itself
    overlay.addEventListener('click', () => {
        overlay.style.display = 'none';
        // Close item forms only
        const itemForms = document.querySelectorAll('[x-data]');
        itemForms.forEach(form => {
            if (form._x_dataStack && form._x_dataStack[0] && form._x_dataStack[0].showForm !== undefined) {
                form._x_dataStack[0].showForm = false;
            }
        });
    });

    // Enhanced search functionality
    const searchInput = document.getElementById('item-search-input');
    const itemListContainer = document.getElementById('item-list-container');
    let timer = null;
    let originalContent = itemListContainer ? itemListContainer.innerHTML : '';

    if (searchInput && itemListContainer) {
        // Handle input changes
        searchInput.addEventListener('input', function() {
            clearTimeout(timer);
            const query = this.value.trim();

            timer = setTimeout(() => {
                if (query.length === 0) {
                    // Restore original content when search is empty
                    itemListContainer.innerHTML = originalContent;
                    initializeItemHoverEffects();
                    attachOverlayListeners();
                    return;
                }

                // Show loading state
                itemListContainer.innerHTML = `
                    <div class="w-full text-center py-12">
                        <i class="fa-solid fa-spinner fa-spin text-3xl text-accent2 mb-4"></i>
                        <p class="text-description text-lg">Searching items...</p>
                    </div>
                `;

                fetch(`/admin/items/search?query=${encodeURIComponent(query)}`, {
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
                            itemListContainer.innerHTML = `
                            <div class="w-full text-center py-12">
                                <i class="fa-solid fa-search text-4xl text-gray-300 mb-4"></i>
                                <p class="text-gray-500 text-lg font-medium">No items found</p>
                                <p class="text-gray-400 text-sm mt-2">Try adjusting your search terms</p>
                            </div>
                        `;
                        } else {
                            itemListContainer.innerHTML = html;
                            // Re-initialize hover effects for new content
                            initializeItemHoverEffects();
                            // Re-attach overlay event listeners
                            attachOverlayListeners();
                        }
                    })
                    .catch(error => {
                        console.error('Search error:', error);
                        itemListContainer.innerHTML = `
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
                itemListContainer.innerHTML = originalContent;
                initializeItemHoverEffects();
                attachOverlayListeners();
            }
        });
    }
});

// Function to initialize hover effects (can be called after AJAX updates)
function initializeItemHoverEffects() {
    const cards = document.querySelectorAll('[id^="item-card-"]');
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
    const editButtons = document.querySelectorAll('[id^="openEditItem-"]');
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
    const closeButtons = document.querySelectorAll('[id^="CloseEditItem-"], #CloseItem');
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

<style>
input:focus {
    outline: 2px solid #FABEB3;
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

/* Select category hover effects */
select#category_id option:hover,
select#category_id option:focus {
    background-color: #FABEB3 !important;
    /* softPink color */
    color: #333 !important;
}

select#category_id:hover {
    background-color: #f3f3f3a8;
}

select#category_id:focus option:checked {
    background-color: #FABEB3 !important;
    /* softPink for selected */
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


@endsection
