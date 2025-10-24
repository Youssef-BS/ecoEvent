<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class CheckoutController extends Controller
{
    public function createCheckoutSession(Request $request, Event $event, Product $product)
    {
        Log::info('Checkout session requested', [
            'event_id' => $event->id,
            'product_id' => $product->id
        ]);

        // Check if product is available
        if ($product->quantity <= 0) {
            return redirect()->back()->with('error', 'Product is out of stock');
        }

        try {
            // Set your Stripe API key
            Stripe::setApiKey(config('services.stripe.secret'));

            // Prepare image URL for Stripe
            $imageUrls = [];
            if ($product->images->isNotEmpty()) {
                $firstImage = $product->images->first();
                $imageUrls = [url(Storage::url($firstImage->path))];
            }

            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => $product->name,
                            'description' => $product->description ?: 'No description',
                            'images' => $imageUrls,
                        ],
                        'unit_amount' => (int)($product->price * 100), // Convert to cents
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => url("/events/{$event->id}/products/{$product->id}/checkout/success") . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => url("/events/{$event->id}/products"),
                'metadata' => [
                    'event_id' => $event->id,
                    'product_id' => $product->id,
                ],
            ]);

            Log::info('Checkout session created', ['session_id' => $session->id]);

            // Redirect directly to Stripe Checkout
            return redirect($session->url);

        } catch (\Exception $e) {
            Log::error('Checkout session error', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Unable to create checkout session: ' . $e->getMessage());
        }
    }

    public function success(Request $request, Event $event, Product $product)
    {
        $sessionId = $request->get('session_id');
        
        // Handle successful payment
        return view('client.products.success', compact('event', 'product', 'sessionId'));
    }
}