<?php
namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index()
    {
        $categories      = Category::all();
        $categoriesarray = Category::all()->toArray();
        return view('admin.categories.index', compact('categories', 'categoriesarray'));
    }
    public function getCategoriesWithItems($id)
    {
        $categories = Category::with('items')->findOrFail($id);
        return view('categories.index', compact('categories'));
    }

    public function showCategory($id)
    {
        $category = Category::findOrFail($id);
        return view('categories.show', compact('category'));
    }

    public function createCategory()
    {
        return view('categories.create');
    }

    public function storeCategory(Request $request)
    {
        try {
            $request->validate([
                'name'        => 'required|string|max:255|unique:categories,name',
                'description' => 'required|string|max:20',
                'image_path'  => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // image validation
            ], [
                'name.unique'          => 'A category with this name already exists. Please choose a different name.',
                'name.required'        => 'Category name is required.',
                'description.required' => 'Category description is required.',
                'description.max'      => 'Category description cannot be longer than 20 characters.',
                'image_path.required'  => 'Category image is required.',
                'image_path.image'     => 'The uploaded file must be an image.',
                'image_path.mimes'     => 'Category image must be a jpeg, png, jpg, gif, or svg file.',
                'image_path.max'       => 'Category image cannot be larger than 2MB.',
            ]);

            $category              = new Category();
            $category->name        = $request->name;
            $category->description = $request->description;

            if ($request->hasFile('image_path')) {
                $file     = $request->file('image_path');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('categories'), $filename);
                $category->image_path = 'categories/' . $filename;
            }

            $category->save();

            return redirect()->route('admin.getcategories')->with('success', 'Category created successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create category: ' . $e->getMessage())->withInput();
        }
    }

    public function editCategory($id)
    {
        $category = Category::findOrFail($id);
        return view('categories.edit', compact('category'));
    }

    public function updateCategory(Request $request, $id)
    {
        try {
            $request->validate([
                'name'        => 'required|string|max:255|unique:categories,name,' . $id,
                'description' => 'required|string',
                'image_path'  => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ], [
                'name.required'        => 'Category name is required.',
                'name.unique'          => 'A category with this name already exists. Please choose a different name.',
                'description.required' => 'Category description is required.',
                'image_path.image'     => 'The uploaded file must be an image.',
                'image_path.mimes'     => 'Category image must be a jpeg, png, jpg, or gif file.',
                'image_path.max'       => 'Category image cannot be larger than 2MB.',
            ]);

            $category              = Category::findOrFail($id);
            $category->name        = $request->name;
            $category->description = $request->description;

            if ($request->hasFile('image_path')) {
                $oldImagePath = $category->image_path; // keep reference to delete after updating

                $file     = $request->file('image_path');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('categories'), $filename);
                $category->image_path = 'categories/' . $filename;

                // Delete old image file from possible locations
                if ($oldImagePath) {
                    if (Storage::disk('public')->exists($oldImagePath)) {
                        Storage::disk('public')->delete($oldImagePath);
                    }
                    $publicPath = public_path($oldImagePath);
                    if (file_exists($publicPath)) {
                        @unlink($publicPath);
                    }
                    $storagePath = storage_path('app/public/' . $oldImagePath);
                    if (file_exists($storagePath)) {
                        @unlink($storagePath);
                    }
                }
            }

            $category->save();

            return redirect()->route('admin.getcategories')->with('success', 'Category updated successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update category: ' . $e->getMessage())->withInput();
        }
    }

    public function adminIndex()
    {
        $categories = Category::withCount('items')->latest()->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function deleteCategory($id)
    {
        try {
            $category = Category::findOrFail($id);
            // Ensure relations are loaded
            $category->loadMissing('items.images');
            $itemsCount  = 0;
            $imagesCount = 0;

            // Delete all items and their images
            foreach ($category->items as $item) {
                // Delete all images for this item
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

                    // Also try to delete from public/storage symlink path
                    $publicStoragePath = public_path('storage/' . ltrim($imagePath, '/'));
                    if (file_exists($publicStoragePath)) {
                        @unlink($publicStoragePath);
                    }

                    // Also try to delete from storage/app/public/items directory
                    $storagePath = storage_path('app/public/' . $imagePath);
                    if (file_exists($storagePath)) {
                        @unlink($storagePath);
                    }

                    $image->delete();
                    $imagesCount++;
                }

                // Delete the item
                $item->delete();
                $itemsCount++;
            }

            // Delete the category image from public/categories
            if ($category->image_path) {
                $imagePath = public_path($category->image_path);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
                // Also try to delete category image if stored via storage disk
                if (\Illuminate\Support\Facades\Storage::disk('public')->exists($category->image_path)) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($category->image_path);
                }
                $publicStoragePath = public_path('storage/' . ltrim($category->image_path, '/'));
                if (file_exists($publicStoragePath)) {
                    @unlink($publicStoragePath);
                }
            }

            // Delete the category
            $category->delete();

            $message = 'Category deleted successfully.';
            if ($itemsCount > 0) {
                $message .= " Deleted {$itemsCount} item(s) and {$imagesCount} image(s).";
            }

            return redirect()->route('admin.getcategories')
                ->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->route('admin.getcategories')
                ->with('error', 'Failed to delete category: ' . $e->getMessage());
        }
    }
    public function searchCategory(Request $request)
    {
        $query = $request->input('query');

        $categories = Category::when($query, function ($q) use ($query) {
            return $q->where('name', 'like', '%' . $query . '%')
                ->orWhere('description', 'like', '%' . $query . '%');
        })->get();

        return view('admin.categories.partials.category_list', compact('categories'));
    }

}
