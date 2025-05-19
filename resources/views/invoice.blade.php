<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->id }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
        }
        .invoice-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 2px solid #eee;
        }
        .invoice-header h1 {
            color: #2c3e50;
            margin: 0;
        }
        .invoice-details {
            margin-bottom: 30px;
        }
        .invoice-details p {
            margin: 5px 0;
        }
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .invoice-table th,
        .invoice-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        .invoice-table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .invoice-total {
            text-align: right;
            margin-top: 20px;
        }
        .invoice-total table {
            width: 300px;
            margin-left: auto;
        }
        .invoice-total td {
            padding: 8px;
        }
        .invoice-total tr:last-child {
            font-weight: bold;
            font-size: 1.2em;
            border-top: 2px solid #eee;
        }
        .status-paid {
            color: #28a745;
            font-weight: bold;
        }
        .status-pending {
            color: #ffc107;
            font-weight: bold;
        }
        .status-cancelled {
            color: #dc3545;
            font-weight: bold;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            color: #666;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="invoice-header">
            <h1>INVOICE</h1>
            <div>
                <p><strong>Invoice #:</strong> {{ $order->id }}</p>
                <p><strong>Date:</strong> {{ $order->created_at->format('d M Y') }}</p>
                <p><strong>Status:</strong> 
                    <span class="status-{{ $order->status }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </p>
            </div>
        </div>

        <div class="invoice-details">
            <p><strong>Post Code:</strong> {{ $order->post_code ?? 'N/A' }}</p>
        </div>

        <table class="invoice-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>
                        {{ $item->product->name }}
                        @if($item->variation)
                            <br>
                            <small class="text-gray-500">
                                {{ $item->variation->attribute }}: {{ $item->variation->value }}
                            </small>
                        @endif
                    </td>
                    <td>{{ $item->quantity }}</td>
                    <td>৳{{ number_format($item->price, 2) }}</td>
                    <td>৳{{ number_format($item->price * $item->quantity, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="invoice-total">
            <table>
                <tr>
                    <td>Subtotal:</td>
                    <td>৳{{ number_format($order->subtotal, 2) }}</td>
                </tr>
                <tr>
                    <td>Discount:</td>
                    <td>৳{{ number_format($order->discount, 2) }}</td>
                </tr>
                <tr>
                    <td>Tax:</td>
                    <td>৳{{ number_format($order->tax, 2) }}</td>
                </tr>
                <tr>
                    <td>Total:</td>
                    <td>৳{{ number_format($order->total, 2) }}</td>
                </tr>
            </table>
        </div>

        <div class="footer">
            <p>Thank you for your business!</p>
            <p>This is a computer-generated invoice, no signature required.</p>
        </div>
    </div>
</body>
</html> 