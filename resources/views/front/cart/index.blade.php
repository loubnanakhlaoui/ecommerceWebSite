@extends('front.layouts.master')

@section('content')
    <h2 class="mt-5"><i class="fa fa-shopping-cart"></i> Shopping Cart</h2>
    <hr>

    @inject('cart', 'App\Services\Cart')
    
    @if ($cart->instance('default')->count() > 0)
        <h4 class="mt-5">{{ $cart->instance('default')->count() }} items(s) in Shopping Cart</h4>

        <div class="cart-items">
            <div class="row">
                <div class="col-md-12">
                    @if (session()->has('msg'))
                        <div class="alert alert-success">{{ session()->get('msg') }}</div>
                    @endif

                    @if (session()->has('errors'))
                        <div class="alert alert-warning">{{ session()->get('errors') }}</div>
                    @endif

                    <table class="table">
                        <tbody>
                        @foreach ($cart->instance('default')->getContent() as $item)
                            <tr>
                            <td>
    @if(isset($item['options']['image']))
        <img src="{{ url('/uploads') . '/'. $item['options']['image'] }}" style="width: 5em">
    @else
        <img src="{{ url('/uploads/default-product.jpg') }}" style="width: 5em">
    @endif
</td>

                                <td>
                                    <form action="{{ route('cart.destroy', $item['id']) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-link btn-link-dark">Remove</button>
                                    </form>

                                    <form action="{{ route('cart.saveLater', $item['id']) }}" method="post">
                                        @csrf
                                        <button type="submit" class="btn btn-link btn-link-dark">Save for later</button>
                                    </form>
                                </td>

                                <td>
                                    <select class="form-control quantity" style="width: 4.7em" data-id="{{ $item['id'] }}">
                                        @for ($i = 1; $i < 5 + 1; $i++)
                                            <option {{ $item['qty'] == $i ? 'selected' : '' }}>{{$i}}</option>
                                        @endfor
                                    </select>
                                </td>

                                <td>${{ $item['price'] * $item['qty'] }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Price Details -->
                <div class="col-md-6">
                    <div class="sub-total">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th colspan="2">Price Details</th>
                            </tr>
                            </thead>
                            <tr>
                                <td>Subtotal</td>
                                <td>${{ $cart->instance('default')->getSubtotal() }}</td>
                            </tr>
                            <tr>
                                <td>Tax</td>
                                <td>${{ $cart->instance('default')->getTax() }}</td>
                            </tr>
                            <tr>
                                <th>Total</th>
                                <th>${{ $cart->instance('default')->getTotal() }}</th>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Save for later  -->
                <div class="col-md-12">
                    <a href="/" class="btn btn-outline-dark">Continue Shopping</a>
                    <a href="/checkout" class="btn btn-outline-info">Proceed to checkout</a>
                    <hr>
                </div>
            @else
                <h3>There is no item in your Cart</h3>
                <a href="/" class="btn btn-outline-dark">Continue Shopping</a>
                <hr>
            @endif

            @if ($cart->instance('saveForLater')->count() > 0)
                <div class="col-md-12">
                    <h4>{{ $cart->instance('saveForLater')->count() }} items Save for Later</h4>
                    <table class="table">
                        <tbody>
                        @foreach ($cart->instance('saveForLater')->getContent() as $item)
                            <tr>
                                <td><img src="{{ url('/uploads') . '/'. $item['options']['image'] }}" style="width: 5em"></td>
                                <td>
                                    <strong>{{ $item['name'] }}</strong><br> {{ $item['options']['description'] }}
                                </td>

                                <td>
                                    <form action="{{ route('saveLater.destroy', $item['id']) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-link btn-link-dark">Remove</button>
                                    </form>

                                    <form action="{{ route('moveToCart', $item['id']) }}" method="post">
                                        @csrf
                                        <button type="submit" class="btn btn-link btn-link-dark">Move to cart</button>
                                    </form>
                                </td>

                                <td>
                                    <select name="" id="" class="form-control" style="width: 4.7em">
                                        <option value="">1</option>
                                        <option value="">2</option>
                                    </select>
                                </td>

                                <td>${{ $item['price'] * $item['qty'] }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        const className = document.querySelectorAll('.quantity');

        Array.from(className).forEach(function(el) {
            el.addEventListener('change', function() {
                const id = el.getAttribute('data-id');
                axios.patch(`/cart/update/${id}`, {
                    quantity: this.value
                })
                .then(function(response) {
                    location.reload();
                })
                .catch(function(error) {
                    console.log(error);
                    location.reload();
                });
            });
        });
    </script>
@endsection