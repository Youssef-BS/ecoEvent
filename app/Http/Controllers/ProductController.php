<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Event;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function create(Event $event)
    {
        return view('admin.products.create', compact('event'));
    }

    public function store(Request $request, Event $event)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'images.*' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);

        try {
            $validated['event_id'] = $event->id;
            $product = Product::create($validated);

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('products', 'public');
                    
                    ProductImage::create([
                        'product_id' => $product->id,
                        'path' => $path,
                        'filename' => $image->hashName(),
                        'original_name' => $image->getClientOriginalName(),
                    ]);
                }
            }

            return redirect()->route('products.index', $event)
                           ->with('success', 'Product created successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Failed to create product. Please try again.');
        }
    }

    public function index(Event $event)
    {
        $products = $event->products()
                         ->with('images')
                         ->latest()
                         ->paginate(12);

        return view('admin.products.index', compact('event', 'products'));
    }

    public function edit(Event $event, Product $product)
    {
        return view('admin.products.edit', compact('event', 'product'));
    }

    public function update(Request $request, Event $event, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'images.*' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);

        try {
            $product->update($validated);

            if ($request->hasFile('images')) {
                // Delete old images
                foreach ($product->images as $image) {
                    Storage::disk('public')->delete($image->path);
                    $image->delete();
                }

                // Add new images
                foreach ($request->file('images') as $image) {
                    $path = $image->store('products', 'public');
                    
                    ProductImage::create([
                        'product_id' => $product->id,
                        'path' => $path,
                        'filename' => $image->hashName(),
                        'original_name' => $image->getClientOriginalName(),
                    ]);
                }
            }

            return redirect()->route('products.index', $event)
                           ->with('success', 'Product updated successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Failed to update product. Please try again.');
        }
    }

    public function destroy(Event $event, Product $product)
    {
        try {
            // Delete product images from storage
            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image->path);
                $image->delete();
            }

            // Delete the product
            $product->delete();

            return redirect()->route('products.index', $event)
                           ->with('success', 'Product deleted successfully!');

        } catch (\Exception $e) {
            return redirect()->route('products.index', $event)
                           ->with('error', 'Failed to delete product. Please try again.');
        }
    }
}