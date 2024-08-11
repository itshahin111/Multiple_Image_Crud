<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        $products = Product::latest()->paginate(5);
        return view('products.index', compact('products'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create(): View
    {
        return view('products.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'detail' => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $input = $request->all();
        $images = [];

        if ($files = $request->file('images')) {
            foreach ($files as $image) {
                $destinationPath = 'storage/';
                $profileImage = date('YmdHis') . uniqid() . "." . $image->getClientOriginalExtension();
                $image->move($destinationPath, $profileImage);
                $images[] = $profileImage;
            }
        }

        $input['images'] = json_encode($images);
        Product::create($input);

        return redirect()->route('products.index')
            ->with('success', 'Product created successfully.');
    }

    public function show(Product $product): View
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product): View
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product): RedirectResponse
{
    $request->validate([
        'name' => 'required',
        'detail' => 'required',
        'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $input = $request->all();
    $images = json_decode($product->images, true) ?? [];

    if ($files = $request->file('images')) {
        foreach ($files as $image) {
            $destinationPath = 'storage/';
            $profileImage = date('YmdHis') . uniqid() . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $images[] = $profileImage;
        }
    }

    // Handle removed images
    if ($removedImages = $request->input('removed_images', [])) {
        foreach ($removedImages as $removedImage) {
            $filePath = public_path('storage/' . $removedImage);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            // Remove from images array
            $images = array_filter($images, function($img) use ($removedImage) {
                return $img !== $removedImage;
            });
        }
    }

    $input['images'] = json_encode(array_values($images));
    $product->update($input);

    return redirect()->route('products.index')
        ->with('success', 'Product updated successfully.');
}


    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();
        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully.');
    }
}
