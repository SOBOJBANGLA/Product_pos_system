<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Product;
use Illuminate\Http\Request;

class PosController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Pos/Index', [
            'products' => Product::with(['variations'])
                ->filter($request->only('search'))
                ->paginate(10)
                ->withQueryString()
        ]);
    }
}
