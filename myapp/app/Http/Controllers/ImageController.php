<?php
namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    /**
     * Store uploaded images for a specific item
     */
    public function store(Request $request)
    {
        $request->validate([
            'images'   => 'required|array|min:1',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'item_id'  => 'nullable|exists:items,id',
        ], [
            'images.required'   => 'Please select at least one image to upload.',
            'images.min'        => 'Please select at least one image to upload.',
            'images.*.required' => 'Please select valid image files.',
            'images.*.image'    => 'The selected file must be an image.',
            'images.*.mimes'    => 'The image must be a file of type: jpeg, png, jpg, gif.',
            'images.*.max'      => 'The image may not be greater than 2MB.',
        ]);

        $uploadedImages = [];

        foreach ($request->file('images') as $image) {
            $path = $image->store('items', 'public');

            // Create image record in database (item_id can be null for new items)
            $imageRecord = Image::create([
                'image_path' => $path,
                'item_id'    => $request->item_id,
            ]);

            $uploadedImages[] = [
                'id'   => $imageRecord->id,
                'path' => $path,
                'url'  => Storage::url($path),
                'name' => $image->getClientOriginalName(),
            ];
        }

        // Return JSON response for AJAX requests
        return response()->json([
            'success' => true,
            'message' => count($uploadedImages) . ' image(s) uploaded successfully!',
            'images'  => $uploadedImages,
        ]);
    }

    /**
     * Delete a specific image
     */
    public function destroy($id)
    {
        try {
            $image  = Image::findOrFail($id);
            $itemId = $image->item_id; // Store item_id before deleting

            // Prevent deleting the only image of an item
            if ($itemId) {
                $imagesCount = Image::where('item_id', $itemId)->count();
                if ($imagesCount <= 1) {
                    return redirect()->route('admin.items.index')
                        ->with('error', 'Cannot delete image: an item must have at least one image.');
                }
            }
            $imagePath = $image->image_path;

            // Delete the file from storage (storage/app/public)
            if (Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }

            // Also attempt to delete from public path if it exists there
            $publicPath = public_path($imagePath);
            if (file_exists($publicPath)) {
                @unlink($publicPath);
            }

            // Also try to delete from storage/app/public/items directory
            $storagePath = storage_path('app/public/' . $imagePath);
            if (file_exists($storagePath)) {
                @unlink($storagePath);
            }

            // Delete the database record
            $image->delete();

            // Redirect to items list page with success message
            return redirect()->route('admin.items.index')
                ->with('success', 'Image deleted successfully from database and storage!');
        } catch (\Exception $e) {
            // Redirect to items list page with error message
            return redirect()->route('admin.items.index')
                ->with('error', 'Failed to delete image: ' . $e->getMessage());
        }
    }

    /**
     * Get all images for a specific item
     */
    public function getItemImages($itemId)
    {
        $item = Item::with('images')->findOrFail($itemId);

        $images = $item->images->map(function ($image) {
            return [
                'id'   => $image->id,
                'path' => $image->image_path,
                'url'  => Storage::url($image->image_path),
            ];
        });

        return response()->json([
            'success' => true,
            'images'  => $images,
        ]);
    }

    /**
     * Update item_id for images (used when item is created)
     */
    public function updateItemId(Request $request)
    {
        $request->validate([
            'image_ids' => 'required|array',
            'item_id'   => 'required|exists:items,id',
        ]);

        Image::whereIn('id', $request->image_ids)
            ->whereNull('item_id')
            ->update(['item_id' => $request->item_id]);

        return response()->json([
            'success' => true,
            'message' => 'Images linked to item successfully!',
        ]);
    }
}
