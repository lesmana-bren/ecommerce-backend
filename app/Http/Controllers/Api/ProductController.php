<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
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
            $query->where('name', 'like', '%' . $keyword . '%')
                  ->orWhere('description', 'like', '%' . $keyword . '%');
        }

        // Filter Kategori
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $limit = $request->get('limit', 10);
        return response()->json($query->latest()->paginate($limit));
    }

    public function show($id)
    {
        return response()->json(Product::with('category')->findOrFail($id));
    }

    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($request->name) . '-' . time();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $data['image'] = url('storage/' . $path);
        }

        $product = Product::create($data);
        return response()->json(['message' => 'Produk berhasil dibuat', 'data' => $product], 201);
    }

    public function update(UpdateProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);
        $data = $request->validated();
        $data['slug'] = Str::slug($request->name) . '-' . time();

        if ($request->hasFile('image')) {
            if ($product->image) {
                $oldPath = str_replace(url('storage/'), '', $product->image);
                Storage::disk('public')->delete($oldPath);
            }
            $path = $request->file('image')->store('products', 'public');
            $data['image'] = url('storage/' . $path);
        }

        $product->update($data);
        return response()->json(['message' => 'Produk berhasil diperbarui', 'data' => $product]);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        if ($product->image) {
            $oldPath = str_replace(url('storage/'), '', $product->image);
            Storage::disk('public')->delete($oldPath);
        }
        $product->delete();
        return response()->json(['message' => 'Produk berhasil dihapus']);
    }
}
