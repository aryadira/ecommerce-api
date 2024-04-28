<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();

        if (!$products) {
            return response()->json([
                'message' => "No products were found"
            ]);
        }

        return response()->json([
            'data' => [
                'count' => $products->count(),
                'products' => $products
            ]
        ]);
    }

    public function show($id)
    {
        $user = Auth::user();

        $product = Product::where('id', $id)->where('user_id', $user->id)->first();

        if (!$product) {
            return response()->json([
                'message' => 'Product not found'
            ]);
        }

        return response()->json([
            'data' => [
                'product' => $product
            ]
        ]);
    }

    public function store(ProductStoreRequest $request)
    {
        $data = $request->validated();
        $user = Auth::user();

        $product  = Product::create([
            'name' => $data['name'],
            'price' => $data['price'],
            'description' => $data['description'],
            'user_id' => $user->id
        ]);

        return response()->json([
            'message' => 'Product created successfully',
            'data' => [
                'product' => $product
            ],
            'user' => $user->id
        ]);
    }

    public function update(ProductUpdateRequest $request, $id)
    {
        $user = Auth::user();
        $data = $request->validated();

        $product = Product::where('id', $id)->where('user_id', $user->id)->first();

        if (!$product) {
            return response()->json([
                'message' => 'Product not found'
            ]);
        }

        $product->name = $data['name'];
        $product->price = $data['price'];
        $product->description = $data['description'];

        $product->save();

        return response()->json([
            'message' => 'Product updated successfully'
        ]);
    }

    public function destroy($id)
    {
        $user = Auth::user();

        $product = Product::where('id', $id)->where('user_id', $user->id)->first();

        if (!$product) {
            return response()->json([
                'message' => 'Product not found'
            ]);
        }

        $product->delete();

        return response()->json([
            'message' => 'Product deleted successfully'
        ]);
    }

    public function showProductByUser()
    {
        $user = Auth::user();

        $products = Product::where('user_id', $user->id)->get();

        if (!$products) {
            return response()->json([
                'message' => 'Product not found'
            ]);
        }

        return response()->json([
            'data' => [
                'user' => $user->id,
                'products' => $products
            ]
        ]);
    }
}
