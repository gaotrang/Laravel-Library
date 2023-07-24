<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Order Mail</title>
</head>
<body>
    <h1>Order Email</h1>
    <table>
        <thead>
            <tr>
                <th>STT</th>
                <th>Product Name</th>
                <th>Product Price</th>
                <th>Product Quantity</th>
                <th>Product Total</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0 @endphp
            @foreach ($order->order_items as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->price }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>{{ number_format($item->qty * $item->price, 2) }}</td>
                </tr>
                @php $total += $item->qty * $item->price @endphp
            @endforeach
            <tr>
                <td>Total: </td>
                <td colspan="4">{{ number_format($total, 2) }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
