@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add Product with Variations</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Base Product Info --}}
        <div class="mb-3"><input type="text" name="name" class="form-control" placeholder="Product Name" required></div>
        <div class="mb-3"><input type="text" name="sku" class="form-control" placeholder="SKU" required></div>
        <div class="mb-3"><input type="text" name="unit" class="form-control" placeholder="Unit (e.g., kg)" required></div>
        <div class="mb-3"><input type="text" name="unit_value" class="form-control" placeholder="Unit Value (e.g., 1kg)" required></div>
        <div class="mb-3"><input type="number" name="selling_price" step="0.01" class="form-control" placeholder="Default Selling Price" required></div>
        <div class="mb-3"><input type="number" name="purchase_price" step="0.01" class="form-control" placeholder="Default Purchase Price" required></div>
        <div class="mb-3"><input type="number" name="discount" step="0.01" class="form-control" placeholder="Discount %"></div>
        <div class="mb-3"><input type="number" name="tax" step="0.01" class="form-control" placeholder="Tax %"></div>
        <div class="mb-3"><input type="file" name="image" class="form-control"></div>

        <hr>

        {{-- Dynamic Variation Fields --}}
        <h5>Product Variations</h5>
        <div id="variations">
            <div class="row variation">
                <div class="col"><input type="text" name="variations[0][attribute]" class="form-control" placeholder="Attribute (e.g., Color)" required></div>
                <div class="col"><input type="text" name="variations[0][value]" class="form-control" placeholder="Value (e.g., Size)" required></div>
                <div class="col"><input type="number" name="variations[0][purchase_price]" class="form-control" placeholder="Purchase Price" step="0.01" required></div>
                <div class="col"><input type="number" name="variations[0][selling_price]" class="form-control" placeholder="Selling Price" step="0.01" required></div>
                <div class="col"><button type="button" class="btn btn-danger remove-variation">X</button></div>
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
            <div class="col"><input type="text" name="variations[${index}][attribute]" class="form-control" placeholder="Attribute" required></div>
            <div class="col"><input type="text" name="variations[${index}][value]" class="form-control" placeholder="Value" required></div>
            <div class="col"><input type="number" name="variations[${index}][purchase_price]" class="form-control" placeholder="Purchase Price" step="0.01" required></div>
            <div class="col"><input type="number" name="variations[${index}][selling_price]" class="form-control" placeholder="Selling Price" step="0.01" required></div>
            <div class="col"><button type="button" class="btn btn-danger remove-variation">X</button></div>
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
