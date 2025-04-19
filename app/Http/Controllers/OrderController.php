<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('items.product')->latest()->paginate(10);

        return Inertia::render('Orders/Index', [
            'orders' => $orders,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'subtotal' => 'required|numeric',
            'tax' => 'required|numeric',
            'total' => 'required|numeric',
        ]);

        $order = Order::create([
            'subtotal' => $request->subtotal,
            'tax' => $request->tax,
            'total' => $request->total,
            'post_code' => $request->post_code,
        ]);

        foreach ($request->items as $item) {
            $order->items()->create([
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        return redirect()->route('orders.index')->with('success', 'Order placed!');
    }

    public function show(Order $order)
{
    $order->load('items.product'); // Load related items & product details

    return Inertia::render('Orders/Show', [
        'order' => $order
    ]);
}
}
