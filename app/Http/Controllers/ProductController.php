<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::paginate(10);

        return response()->json($products);
    }

    public function productById($id)
    {
        $product = Product::find($id);

        return response()->json($product);
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->save();
        return response()->json($product);
    }


    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'name' => 'required',
        ]);

        $product = Product::find($request->id);
        $product->name = $request->name;
        $product->save();

        return response()->json($product);
    }

    public function destroy(Request $request)
    {
        $product = Product::destroy($request->id);
        return response()->json($product);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'image' => 'required'
        ]);


        $product = Product::find($request->id);

        $fileName = time() . '.' . $request->image->extension();
        Storage::putFileAs('images/' . $product->id, $request->image, $fileName);

        $product->image = $fileName;
        $product->save();

        return response()->json($product);
    }
}
