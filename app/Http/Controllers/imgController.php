<?php
namespace App\Http\Controllers;

use App\Models\img;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class imgController extends Controller
{
    public function store(Request $request)
    {

        $itemId = $request->inputs[0]["item_id"];
        foreach ($request->inputs as $key => $value) {
            $imagePath = $value["src"]->store('images', 'public'); // this gives "images/filename.jpg"

            $value['item_id'] = $itemId;
            $value['src']     = $imagePath;
            img::create($value);
        }
        $validated = $request->validate([
            'inputs.*.item_id' => 'required',
            'inputs.*.image'   => 'required',
            'inputs.*.color'   => 'required',
        ]);
        return redirect()->back()->with('success', 'Comment stored successfully!');

    }
    public function editImg(img $img)
    {
        return view('edit.editimg', ['img' => $img]);
    }

    public function update(img $img, Request $request)
    {
        $input = $request->validate([
            'src'     => 'required',
            'item_id' => 'required',
        ]);

        $img->update($input);
        return redirect('/');
    }
    public function DeleteImage($id)
    {
        $image = img::find($id);
        Storage::disk('public')->delete($image->src);
        $image->delete();
        return redirect('/admin');
    }
}
