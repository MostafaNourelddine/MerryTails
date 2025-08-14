<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Image;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    public function showItems()
    {
        $items = Item::with('images')->get();
        return view('items.index', compact('items'));
    }

    public function getItem($id)
    {
        $item = Item::with('images')->findOrFail($id);
        return view('items.showitem', compact('item'));
    }

    public function createItems()
    {
        return view('admin.items.create');
    }

    public function storeItem(Request $request)
    {
        try {
            // Parse image_ids if it comes as JSON string from form
            if ($request->has('image_ids') && is_string($request->image_ids)) {
                $imageIds = json_decode($request->image_ids, true);
                $request->merge(['image_ids' => $imageIds]);
            }

            $validated = $request->validate([
                'name'           => 'required|string|max:255|unique:items,name',
                'description'    => 'required|string|max:1000',
                'price'          => 'required|numeric|min:0',
                'category_id'    => 'required|exists:categories,id',
                'sale'           => 'nullable|boolean',
                'salepercentage' => 'nullable|numeric|min:0|max:100',
                'image_ids'      => 'required|array|min:1', // At least one image is required
                'image_ids.*'    => 'exists:images,id',
            ], [
                'name.unique'            => 'An item with this name already exists. Please choose a different name.',
                'name.required'          => 'Item name is required.',
                'description.required'   => 'Item description is required.',
                'price.required'         => 'Item price is required.',
                'price.numeric'          => 'Item price must be a valid number.',
                'price.min'              => 'Price must be greater than or equal to 0.',
                'category_id.required'   => 'Please select a category for this item.',
                'category_id.exists'     => 'The selected category does not exist.',
                'image_ids.required'     => 'At least one image is required for the item.',
                'image_ids.min'          => 'At least one image is required for the item.',
                'image_ids.*.exists'     => 'One or more selected images are invalid.',
                'salepercentage.numeric' => 'Sale percentage must be a valid number.',
                'salepercentage.min'     => 'Sale percentage cannot be negative.',
                'salepercentage.max'     => 'Sale percentage cannot be greater than 100.',
            ]);

            // Create the item
            $item = Item::create([
                'name'           => $request->name,
                'description'    => $request->description,
                'price'          => $request->price,
                'category_id'    => $request->category_id,
                'sale'           => $request->sale ?? false,
                'salepercentage' => $request->salepercentage,
            ]);

            // Link pre-uploaded images to this item
            if ($request->has('image_ids') && ! empty($request->image_ids)) {
                Image::whereIn('id', $request->image_ids)
                    ->whereNull('item_id')
                    ->update(['item_id' => $item->id]);
            }

            // Handle direct file uploads (fallback for non-AJAX usage)
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $img) {
                    $path = $img->store('items', 'public');

                    Image::create([
                        'item_id'    => $item->id,
                        'image_path' => $path,
                    ]);
                }
            }

            return redirect()->route('admin.items.index')->with('success', 'Item created successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create item: ' . $e->getMessage())->withInput();
        }
    }

    public function adminIndex()
    {
        $items = Item::with(['images', 'category'])->latest()->paginate(10);
        return view('admin.items.index', compact('items'));
    }

    public function editItem($id)
    {
        $item       = Item::with('images')->findOrFail($id);
        $categories = Category::all();
        return view('admin.items.edit', compact('item', 'categories'));
    }

    public function updateItem(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'name'           => 'required|string|max:255|unique:items,name,' . $id,
                'description'    => 'required|string|max:1000',
                'price'          => 'required|numeric|min:0',
                'category_id'    => 'required|exists:categories,id',
                'sale'           => 'nullable|boolean',
                'salepercentage' => 'nullable|numeric|min:0|max:100',
                'images.*'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'delete_images'  => 'nullable|array',
            ], [
                'name.required'          => 'Item name is required.',
                'description.required'   => 'Item description is required.',
                'price.required'         => 'Item price is required.',
                'price.numeric'          => 'Item price must be a valid number.',
                'price.min'              => 'Price must be greater than or equal to 0.',
                'category_id.required'   => 'Please select a category for this item.',
                'category_id.exists'     => 'The selected category does not exist.',
                'images.*.image'         => 'The uploaded file must be an image.',
                'images.*.mimes'         => 'The image must be a jpeg, png, jpg, or gif file.',
                'images.*.max'           => 'The image may not be greater than 2MB.',
                'salepercentage.numeric' => 'Sale percentage must be a valid number.',
                'salepercentage.min'     => 'Sale percentage cannot be negative.',
                'salepercentage.max'     => 'Sale percentage cannot be greater than 100.',
            ]);

            $item = Item::findOrFail($id);
            $item->update([
                'name'           => $request->name,
                'description'    => $request->description,
                'price'          => $request->price,
                'category_id'    => $request->category_id,
                'sale'           => $request->sale ?? false,
                'salepercentage' => $request->salepercentage,
            ]);

            // Handle image deletions
            if ($request->has('delete_images')) {
                foreach ($request->delete_images as $imageId) {
                    $image = Image::find($imageId);
                    if ($image && $image->item_id == $item->id) {
                        // Prevent deleting the last remaining image for the item
                        $remainingCount = Image::where('item_id', $item->id)->count();
                        if ($remainingCount <= 1) {
                            return redirect()->back()->with('error', 'Cannot delete image: an item must have at least one image.');
                        }
                        $imagePath = $image->image_path;

                        // Delete from storage/app/public
                        if (Storage::disk('public')->exists($imagePath)) {
                            Storage::disk('public')->delete($imagePath);
                        }

                        // Also try to delete from public path
                        $publicPath = public_path($imagePath);
                        if (file_exists($publicPath)) {
                            @unlink($publicPath);
                        }

                        // Also try to delete from storage/app/public/items directory
                        $storagePath = storage_path('app/public/' . $imagePath);
                        if (file_exists($storagePath)) {
                            @unlink($storagePath);
                        }

                        $image->delete();
                    }
                }
            }

            // Handle new images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $img) {
                    $path = $img->store('items', 'public');
                    Image::create([
                        'item_id'    => $item->id,
                        'image_path' => $path,
                    ]);
                }
            }

            return redirect()->route('admin.items.index')
                ->with('success', 'Item updated successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update item: ' . $e->getMessage())->withInput();
        }
    }

    public function deleteItem($id)
    {
        try {
            $item = Item::with('images')->findOrFail($id);

            // Delete all associated images
            foreach ($item->images as $image) {
                $imagePath = $image->image_path;

                // Delete from storage/app/public
                if (Storage::disk('public')->exists($imagePath)) {
                    Storage::disk('public')->delete($imagePath);
                }

                // Also try to delete from public path
                $publicPath = public_path($imagePath);
                if (file_exists($publicPath)) {
                    @unlink($publicPath);
                }

                // Also try to delete from storage/app/public/items directory
                $storagePath = storage_path('app/public/' . $imagePath);
                if (file_exists($storagePath)) {
                    @unlink($storagePath);
                }

                $image->delete();
            }

            $item->delete();

            return redirect()->route('admin.items.index')
                ->with('success', 'Item deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.items.index')
                ->with('error', 'Failed to delete item: ' . $e->getMessage());
        }
    }

    public function searchItem(Request $request)
    {
        $query = $request->input('query');

        $items = Item::with(['images', 'category'])->when($query, function ($q) use ($query) {
            return $q->where('name', 'like', '%' . $query . '%')
                ->orWhere('description', 'like', '%' . $query . '%')
                ->orWhereHas('category', function ($categoryQuery) use ($query) {
                    $categoryQuery->where('name', 'like', '%' . $query . '%');
                });
        })->latest()->get();

        return view('admin.items.partials.item_list', compact('items'));
    }
}
