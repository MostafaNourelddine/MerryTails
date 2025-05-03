<?php
namespace App\Http\Controllers;

use App\Models\category;
use App\Models\img;
use App\Models\items;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemsController extends Controller
{
    public function index()
    {
        $items      = DB::table('items')->get();
        $categories = DB::table('category')->get();
        $images     = DB::table('imgs')->get();
        return view('AdminPannel', compact('items', 'categories', 'images'));
    }
    public function Home()
    {
        $items      = DB::table('items')->get();
        $categories = DB::table('category')->get();
        $images     = DB::table('imgs')->get();
        return view('Global.HomePage', compact('items', 'categories', 'images'));
    }
    public function Contact()
    {
        $items      = DB::table('items')->get();
        $categories = DB::table('category')->get();
        $images     = DB::table('imgs')->get();
        return view('Global.ContactUs', compact('items', 'categories', 'images'));
    }

    public function StoreItem(Request $request)
    {
        $validated = $request->validate([
            'Name'        => 'required',
            'Price'       => 'required',
            'Description' => 'required',
            'Category'    => 'required',
        ]);
        $item              = new items();
        $item->name        = $request->input('Name');
        $item->price       = $request->input('Price');
        $item->description = $request->input('Description');
        $item->cat_id      = $request->input('Category');
        $item->save();
        return redirect()->back()->with('success', 'Comment stored successfully!');
    }
    public function editItem(items $item)
    {
        return view('edit.edititem', ['item' => $item]);
    }

    public function update(items $item, Request $request)
    {
        $input = $request->validate([
            'name'        => 'required',
            'description' => 'required',
        ]);

        $item->update($input);
        return redirect('/');
    }
    public function ViewItem($id, Request $request)
    {
        $item       = items::find($id);
        $items      = DB::table('items')->get();
        $images     = Img::where('item_id', $id)->get();
        $image      = Img::where('item_id', $id)->get();
        $categories = DB::table('category')->get();

        return view('Global.QuickView', compact('item', 'images', 'categories', 'items'));
    }
    public function Products($id)
    {
        $category   = category::find($id);
        $categories = DB::table('category')->get();

        $count  = items::where('cat_id', $id)->count();
        $items  = items::where('cat_id', $id)->paginate(10);
        $images = DB::table('imgs')->get();

        return view('Global.Products', compact('items', 'category', 'count', 'images', 'categories'));
    }
    public function Search(Request $request)
    {
        $items = items::query()->when(
            $request->search,
            function (Builder $builder) use ($request) {
                $builder->where('name', 'like', "%{$request->search}%")
                    ->orWhere('description', 'like', "%{$request->search}%");
            }
        )->paginate(8);

        $images     = DB::table('imgs')->get();
        $categories = DB::table('category')->get();
        return view('Global.SearchResults', compact('items', 'categories', 'images'));
    }
    public function DeleteItem($id)
    {

        // Then delete the item
        $item = Items::find($id);

        if ($item) {
            $item->images()->delete(); // delete related images first
            $item->delete();           // then delete the item
        }

        return redirect('/admin');
    }
}
