@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add Product with Variations</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Base Product Info --}}
        <div class="mb-3">
            <label for="name" class="form-label">Product Name</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="sku" class="form-label">SKU</label>
            <input type="text" name="sku" id="sku" class="form-control @error('sku') is-invalid @enderror" value="{{ old('sku') }}" required>
            @error('sku')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="unit" class="form-label">Unit</label>
            <input type="text" name="unit" id="unit" class="form-control @error('unit') is-invalid @enderror" value="{{ old('unit') }}" placeholder="e.g., kg" required>
            @error('unit')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="unit_value" class="form-label">Unit Value</label>
            <input type="text" name="unit_value" id="unit_value" class="form-control @error('unit_value') is-invalid @enderror" value="{{ old('unit_value') }}" placeholder="e.g., 1kg" required>
            @error('unit_value')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="selling_price" class="form-label">Selling Price</label>
            <input type="number" name="selling_price" id="selling_price" step="0.01" class="form-control @error('selling_price') is-invalid @enderror" value="{{ old('selling_price') }}" required>
            @error('selling_price')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="purchase_price" class="form-label">Purchase Price</label>
            <input type="number" name="purchase_price" id="purchase_price" step="0.01" class="form-control @error('purchase_price') is-invalid @enderror" value="{{ old('purchase_price') }}" required>
            @error('purchase_price')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="discount" class="form-label">Discount (%)</label>
            <input type="number" name="discount" id="discount" step="0.01" class="form-control @error('discount') is-invalid @enderror" value="{{ old('discount', 0) }}">
            @error('discount')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="tax" class="form-label">Tax (%)</label>
            <input type="number" name="tax" id="tax" step="0.01" class="form-control @error('tax') is-invalid @enderror" value="{{ old('tax', 0) }}">
            @error('tax')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Product Image</label>
            <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror">
            @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <hr>

        {{-- Dynamic Variation Fields --}}
        <h5>Product Variations</h5>
        <div id="variations">
            <div class="row variation">
                <div class="col">
                    <input type="text" name="variations[0][attribute]" class="form-control" placeholder="Attribute (e.g., Color)" required>
                </div>
                <div class="col">
                    <input type="text" name="variations[0][value]" class="form-control" placeholder="Value (e.g., Red)" required>
                </div>
                <div class="col">
                    <input type="number" name="variations[0][purchase_price]" class="form-control" placeholder="Purchase Price" step="0.01" required>
                </div>
                <div class="col">
                    <input type="number" name="variations[0][selling_price]" class="form-control" placeholder="Selling Price" step="0.01" required>
                </div>
                <div class="col">
                    <button type="button" class="btn btn-danger remove-variation">X</button>
                </div>
            </div>
        </div>

        <button type="button" id="add-variation" class="btn btn-sm btn-success mt-2">+ Add Variation</button>

        <br><br>
        <button type="submit" class="btn btn-primary">Add Product</button>
    </form>
</div>

<script>
let index = 1;

document.getElementById('add-variation').addEventListener('click', function () {
    const html = `
        <div class="row variation mt-2">
            <div class="col">
                <input type="text" name="variations[${index}][attribute]" class="form-control" placeholder="Attribute" required>
            </div>
            <div class="col">
                <input type="text" name="variations[${index}][value]" class="form-control" placeholder="Value" required>
            </div>
            <div class="col">
                <input type="number" name="variations[${index}][purchase_price]" class="form-control" placeholder="Purchase Price" step="0.01" required>
            </div>
            <div class="col">
                <input type="number" name="variations[${index}][selling_price]" class="form-control" placeholder="Selling Price" step="0.01" required>
            </div>
            <div class="col">
                <button type="button" class="btn btn-danger remove-variation">X</button>
            </div>
        </div>`;
    document.getElementById('variations').insertAdjacentHTML('beforeend', html);
    index++;
});

document.addEventListener('click', function (e) {
    if (e.target.classList.contains('remove-variation')) {
        e.target.closest('.variation').remove();
    }
});
</script>
@endsection
