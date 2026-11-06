<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource; 
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Pencarian Kata Kunci
        if ($request->filled('s') || $request->filled('keyword')) {
            $keyword = $request->get('s') ?? $request->get('keyword');
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', '%' . $keyword . '%')
                  ->orWhere('description', 'like', '%' . $keyword . '%');
            });
        }

        // Filter Kategori
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $limit = $request->get('limit', 10);
        $products = $query->latest()->paginate($limit);

        // Return menggunakan Resource Collection
        return ProductResource::collection($products);
    }

    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);
        return new ProductResource($product);
    }

    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($request->name) . '-' . time();

        // Cek file dari 'image' atau 'img'
        $file = $request->file('image') ?? $request->file('img');
        if ($file) {
            $data['image'] = $file->store('products', 'public');
        }
        
        unset($data['img']); // Hapus 'img' agar tidak error SQL

        $product = Product::create($data);
        return new ProductResource($product);
    }

    public function update(UpdateProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);
        $data = $request->validated();
        $data['slug'] = Str::slug($request->name) . '-' . time();

        $file = $request->file('image') ?? $request->file('img');
        if ($file) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $file->store('products', 'public');
        }

        unset($data['img']); // Hapus 'img' agar tidak error SQL

        $product->update($data);
        return new ProductResource($product);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->img && Storage::disk('public')->exists($product->img)) {
            Storage::disk('public')->delete($product->img);
        }

        $product->delete();

        return response()->json(['message' => 'Produk berhasil dihapus']);
    }
}
