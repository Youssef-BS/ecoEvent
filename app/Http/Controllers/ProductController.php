<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Event;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function create(Event $event)
    {
        return view('admin.products.create', compact('event'));
    }

public function store(Request $request, Event $event) // Add Event parameter
{
    $validated = $request->validate([
        // Remove 'event_id' from validation since we get it from route
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'quantity' => 'required|integer|min:0',
        'images.*' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
    ]);

    try {
        // Add event_id to the product data
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

        return redirect()->route('admin.products.index', $event) // Use route model binding
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
}