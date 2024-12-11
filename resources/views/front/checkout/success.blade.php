@extends('front.layouts.master')
@section('content')
<div class="container">
    <div class="alert alert-success text-center">
        <h1>Thank You for Your Order!</h1>
        <p>Your order has been processed successfully.</p>
        <a href="{{ route('user.profile') }}" class="btn btn-primary">Go to Profile</a>

    </div>
</div>
@endsection
