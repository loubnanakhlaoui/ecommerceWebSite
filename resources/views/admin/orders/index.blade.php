@extends('admin.layouts.master')

@section('page')
    Orders
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('admin.layouts.message')

            <div class="card">
                <div class="header">
                    <h4 class="title">Orders</h4>
                    <p class="category">List of all orders</p>
                </div>
                <div class="content table-responsive table-full-width">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ optional($order->user)->name }}</td>
                            <td>
                                @foreach ($order->products as $item)
                                    <table class="table">
                                        <tr>
                                            <td>{{ $item->name }}</td>
                                        </tr>
                                    </table>
                                @endforeach
                            </td>

                            <td>
                                @foreach ($order->orderItems as $item)
                                    <table class="table">
                                        <tr>
                                            <td>{{ $item->quantity }}</td>
                                        </tr>
                                    </table>
                                @endforeach
                            </td>

                            <td>
                                @if ($order->status)
                                    <span class="label label-success">Confirmed</span>
                                @else
                                    <span class="label label-warning">Pending</span>
                                @endif
                            </td>

                            <td>
                                @if ($order->status)
                                    <a href="{{ route('order.pending', $order->id) }}" class="btn btn-warning btn-sm">Pending</a>
                                @else
                                    <a href="{{ route('order.confirm', $order->id) }}" class="btn btn-success btn-sm">Confirm</a>
                                @endif

                                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-success btn-sm">Details</a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection