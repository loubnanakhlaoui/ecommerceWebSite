@extends('admin.layouts.master')

@section('page')
    Order Details
@endsection

@section('content')
    @if(isset($order))
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4 class="title">Order Details</h4>
                        <p class="category">Order Information</p>
                    </div>
                    <div class="content table-responsive table-full-width">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Date</th>
                                <th>Address</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->date }}</td>
                                    <td>{{ $order->address }}</td>
                                    <td>
                                        @if ($order->status)
                                            <span class="label label-success">Confirmed</span>
                                        @else
                                            <span class="label label-warning">Pending</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($order->status)
                                            <a href="{{ route('order.pending', $order->id) }}" class="btn btn-warning btn-sm">Set Pending</a>
                                        @else
                                            <a href="{{ route('order.confirm', $order->id) }}" class="btn btn-success btn-sm">Confirm Order</a>
                                        @endif  
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card">
                    <div class="header">
                        <h4 class="title">Customer Details</h4>
                        <p class="category">Customer Information</p>
                    </div>
                    <div class="content table-responsive table-full-width">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Customer ID</th>
                                <td>{{ $order->user->id }}</td>
                            </tr>
                            <tr>
                                <th>Full Name</th>
                                <td>{{ $order->user->name }}</td>
                            </tr>
                            <tr>
                                <th>Email Address</th>
                                <td>{{ $order->user->email }}</td>
                            </tr>
                            <tr>
                                <th>Registration Date</th>
                                <td>{{ $order->user->created_at->diffForHumans() }}</td>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4 class="title">Product Details</h4>
                        <p class="category">Products in Order</p>
                    </div>
                    <div class="content table-responsive table-full-width">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Product Name</th>
                                    <th>Unit Price</th>
                                    <th>Quantity</th>
                                    <th>Product Image</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($order->products as $index => $product)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $order->orderItems[$index]->price }}</td>
                                        <td>{{ $order->orderItems[$index]->quantity }}</td>
                                        <td>
                                            <img src="{{ url('uploads') . '/' . $product->image }}" alt="{{ $product->name }}" style="width: 2em">
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No products found for this order</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <a href="{{ route('admin.orders.index') }}" class="btn btn-success">Back to Orders List</a>
    @else
        <div class="alert alert-danger">
            No order found for ID {{ request()->route('id') }}
        </div>
    @endif
@endsection