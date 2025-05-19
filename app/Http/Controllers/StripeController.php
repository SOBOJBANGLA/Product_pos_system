<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;
use Illuminate\Support\Facades\Log;

class StripeController extends Controller
{
    public function __construct()
    {
        $this->middleware('web');
    }

    public function createCheckoutSession(Request $request)
    {
        try {
            if (!config('services.stripe.secret')) {
                throw new \Exception('Stripe secret key is not configured');
            }

            Stripe::setApiKey(config('services.stripe.secret'));

            // Validate request data
            $request->validate([
                'items' => 'required|array',
                'items.*.product_id' => 'required|exists:products,id',
                'items.*.quantity' => 'required|integer|min:1',
                'items.*.price' => 'required|numeric|min:0',
                'subtotal' => 'required|numeric|min:0',
                'discount' => 'required|numeric|min:0',
                'tax' => 'required|numeric|min:0',
                'total' => 'required|numeric|min:0',
            ]);

            $order = Order::create([
                'post_code' => $request->post_code,
                'subtotal' => $request->subtotal,
                'discount' => $request->discount,
                'tax' => $request->tax,
                'total' => $request->total,
                'status' => 'pending'
            ]);

            foreach ($request->items as $item) {
                $order->items()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'variation_id' => $item['variation_id'] ?? null
                ]);
            }

            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'bdt',
                        'product_data' => [
                            'name' => 'Order #' . $order->id,
                        ],
                        'unit_amount' => (int)($request->total * 100), // Convert to cents
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('payment.success', ['order' => $order->id]),
                'cancel_url' => route('payment.cancel', ['order' => $order->id]),
                'metadata' => [
                    'order_id' => $order->id
                ]
            ]);

            return response()->json(['id' => $session->id]);
        } catch (ApiErrorException $e) {
            Log::error('Stripe API Error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        } catch (\Exception $e) {
            Log::error('Error creating checkout session: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function success(Request $request, Order $order)
    {
        $order->update(['status' => 'paid']);
        return redirect()->route('orders.show', $order)->with('success', 'Payment successful!');
    }

    public function cancel(Request $request, Order $order)
    {
        $order->update(['status' => 'cancelled']);
        return redirect()->route('pos.index')->with('error', 'Payment cancelled.');
    }

    public function downloadInvoice(Order $order)
    {
        $pdf = \PDF::loadView('invoice', compact('order'));
        return $pdf->download('invoice-' . $order->id . '.pdf');
    }
} 