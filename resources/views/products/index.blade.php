@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Product List</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">+ Add New Product</a>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Image</th>
                <th>Name</th>
                <th>SKU</th>
                <th>Unit</th>
                <th>Unit Value</th>
                <th>Purchase Price</th>
                <th>Selling Price</th>
                <th>Discount (%)</th>
                <th>Tax (%)</th>
                <th>Variations</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $key => $product)
                <tr>
                    <td>{{ $products->firstItem() + $key }}</td>
                    <td>
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" width="50" height="50" alt="Image">
                        @else
                            N/A
                        @endif
                    </td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->sku }}</td>
                    <td>{{ $product->unit }}</td>
                    <td>{{ $product->unit_value }}</td>
                    <td>{{ number_format($product->purchase_price, 2) }}</td>
                    <td>{{ number_format($product->selling_price, 2) }}</td>
                    <td>{{ $product->discount ?? 0 }}</td>
                    <td>{{ $product->tax ?? 0 }}</td>
                    <td>
                        @if($product->variations->count())
                            <ul>
                                @foreach($product->variations as $variation)
                                    <li>
                                        <strong>{{ $variation->attribute }}:</strong> {{ $variation->value }}<br>
                                        Purchase: {{ number_format($variation->purchase_price, 2) }} |
                                        Selling: {{ number_format($variation->selling_price, 2) }}
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            No variations
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="11">No products found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $products->links() }}
    </div>
</div>
@endsection
