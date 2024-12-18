<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\ProductRequest;
use App\ProductGallery;

class DashboardProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['galleries', 'category'])
            ->where('users_id', Auth::user()->id)->get();
        return view('pages.dashboard-product', [
            'products' => $products
        ]);
    }

    public function detail(Request $request, $id)
    {
        $product = Product::with((['galleries', 'user', 'category']))->findOrFail($id);
        $categories = Category::all();
        return view('pages.dashboard-product-detail', [
            'categories' => $categories,
            'product' => $product
        ]);
    }

    public function uploadGallery(Request $request)
    {
        $data = $request->all();
        $data['photo'] = $request->file('photo')->store('assets/public', 'public');

        ProductGallery::create($data);

        return redirect()->route('dashboard-product-detail', $request->products_id);
    }

    public function deleteGallery(Request $request, $id)
    {
        $item = ProductGallery::findOrFail($id);
        $item->delete();

        return redirect()->route('dashboard-product-detail', $item->products_id);
    }

    public function create()
    {
        $categories = Category::all();
        return view('pages.dashboard-product-create', [
            'categories' => $categories
        ]);
    }


    public function store(ProductRequest $request)
    {
        $data = $request->all();
        $data['slug'] = Str::slug($request->name);

        $data['stock'] = $data['stock'] ?? 0;

        $product = Product::create($data);
        $gallery = [
            'products_id' => $product->id,
            'photo' => $request->file('photo')->store('assets/public', 'public')
        ];

        ProductGallery::create($gallery);

        return redirect()->route('dashboard-product');
    }

    public function update(ProductRequest $request, $id)
    {
        $data = $request->all();

        $item = Product::findOrFail($id);
        $data['slug'] = Str::slug($request->name);

        if (isset($data['stock'])) {
            $data['stock'] = $item->stock + $data['stock']; // Menambahkan stok baru ke stok yang sudah ada
        }

        $item->update($data);

        return redirect()->route('dashboard-product');
    }
}
