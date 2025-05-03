<?php
namespace App\Http\Controllers;

use App\Models\category;
use Illuminate\Http\Request;

class categoryController extends Controller
{
    public function Storecategory(Request $request)
    {
        // Validate the input
        $request->validate([
            'Name'        => 'required',
            'Description' => 'required',
            'Image'       => 'required|image|mimes:jpg,jpeg,png,gif,svg|max:2048',
        ]);

        // Handle the image upload and get the path
        $imagePath = null;
        if ($request->hasFile('Image')) {
            $imagePath = $request->file('Image')->store('images', 'public'); // this gives "images/filename.jpg"
        } else {
            return back()->with('error', 'Image upload failed.');
        }

        // Now create and save the category with the image path
        $category              = new Category();
        $category->name        = $request->input('Name');
        $category->description = $request->input('Description');
        $category->src         = $imagePath; // this stores something like "images/cat.jpg"
        $category->save();

        return redirect()->back()->with('success', 'Category stored successfully!');
    }

    public function editCategory(category $category)
    {
        return view('edit.editCategory', ['category' => $category]);
    }

    public function update(category $category, Request $request)
    {
        $input = $request->validate([
            'name'        => 'required',
            'description' => 'required',
        ]);

        $category->update($input);
        return redirect('/');
    }
    public function deleteCategory($id)
    {
        $category = category::find($id);
        if ($category) {
            $category->delete();
        }

        return redirect('/admin');

    }
}
