@extends('front.layouts.master')

@section('content')

    <h2>Profile</h2>
    <hr>

    <h3>User Details</h3>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th colspan="2">User Details <a href="" class="pull-right"><i class="fa fa-cogs"></i> Edit user</a></th>
        </tr>
        </thead>
        <tr>
            <th>ID</th>
            <td>{{ $user->id }}</td>
        </tr>
        <tr>
            <th>Name</th>
            <td>{{ $user->name }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $user->email }}</td>
        </tr>
        <tr>
            <th>Registered At</th>
            <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
        </tr>
    </table>

    <h4 class="title">Orders</h4>
    <hr>
    <div class="content table-responsive table-full-width">
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @if ($user->orders->isNotEmpty())
                @foreach ($user->orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>
                            @foreach ($order->products as $product)
                                <div>{{ $product->name }}</div>
                            @endforeach
                        </td>
                        <td>
                            @foreach ($order->orderItems as $item)
                                <div>{{ $item->quantity }}</div>
                            @endforeach
                        </td>
                        <td>
                            @php
                                $total = $order->orderItems->sum(function($item) {
                                    return $item->quantity * $item->price;
                                });
                            @endphp
                            ${{ number_format($total, 2) }}
                        </td>
                        <td>
                            @if ($order->status)
                                <span class="badge badge-success">Confirmed</span>
                            @else
                                <span class="badge badge-warning">Pending</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ url('/user/order/' . $order->id) }}" class="btn btn-outline-dark btn-sm">Details</a>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="6" class="text-center">No orders found.</td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>

@endsection
