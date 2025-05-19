<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariation;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('variations')->latest()->paginate(10);
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:products,sku',
            'unit' => 'required|string',
            'unit_value' => 'required|string',
            'selling_price' => 'required|numeric',
            'purchase_price' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'tax' => 'nullable|numeric',
            'image' => 'nullable|image|max:2048',
            'variations.*.attribute' => 'required|string',
            'variations.*.value' => 'required|string',
            'variations.*.purchase_price' => 'required|numeric',
            'variations.*.selling_price' => 'required|numeric',
        ]);

        try {
            $imagePath = null;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imagePath = $image->store('products', 'public');
            }

            $product = Product::create([
                'name' => $request->name,
                'sku' => $request->sku,
                'unit' => $request->unit,
                'unit_value' => $request->unit_value,
                'selling_price' => $request->selling_price,
                'purchase_price' => $request->purchase_price,
                'discount' => $request->discount ?? 0,
                'tax' => $request->tax ?? 0,
                'image' => $imagePath,
            ]);

            foreach ($request->variations as $variation) {
                ProductVariation::create([
                    'product_id' => $product->id,
                    'attribute' => $variation['attribute'],
                    'value' => $variation['value'],
                    'purchase_price' => $variation['purchase_price'],
                    'selling_price' => $variation['selling_price'],
                ]);
            }

            return redirect()->route('products.index')->with('success', 'Product with variations added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Failed to create product: ' . $e->getMessage()]);
        }
    }
}
