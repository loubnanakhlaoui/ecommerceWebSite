@extends('front.layouts.master')

@section('style')
    <script src="https://js.stripe.com/v3/"></script>
@endsection

@section('content')
    @inject('cart', 'App\Services\Cart')
    
    <h2 class="mt-5"><i class="fa fa-credit-card-alt"></i> Checkout</h2>
    <hr>

    <div class="row">
        <div class="col-md-7">
            @if (session()->has('error'))
                <div class="alert alert-danger">
                    {{ session()->get('error') }}
                </div>
            @endif

            @if (session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif

            <h4>Billing Details</h4>

            <form method="post" id="payment-form" action="{{ route('checkout') }}">
                @csrf

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Name" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" id="address" name="address" placeholder="1234 Main St" required>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="city">City</label>
                        <input type="text" class="form-control" id="city" name="city" placeholder="City" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="province">Province</label>
                        <input type="text" class="form-control" id="province" name="province" placeholder="Province" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="postal">Postal</label>
                        <input type="text" class="form-control" id="postal" name="postal" placeholder="Postal" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" class="form-control" id="phone" placeholder="Phone" name="phone" required>
                </div>
                <hr>
                <h5><i class="fa fa-credit-card"></i> Payment Details</h5>

                <div class="form-group">
                    <label for="name_on_card">Name on card</label>
                    <input type="text" class="form-control" id="name_on_card" name="name_on_card" placeholder="Name on card" required>
                </div>

                <div class="form-group">
                    <label for="card-element">Credit or debit card</label>
                    <div id="card-element">
                        <!-- A Stripe Element will be inserted here. -->
                    </div>

                    <!-- Used to display form errors. -->
                    <div id="card-errors" role="alert" class="text-danger mt-2"></div>
                </div>

                <button type="submit" class="btn btn-outline-info col-md-12">Complete Order</button>
            </form>
        </div>

        <div class="col-md-5">
            <h4>Your Order</h4>

            <table class="table your-order-table">
                <tr>
                    <th>Image</th>
                    <th>Details</th>
                    <th>Qty</th>
                </tr>

                @foreach ($cart->instance('default')->getContent() as $item)
                <tr>
                    <td>
                        @if(isset($item['options']['image']))
                            <img src="{{ url('/uploads') . '/'. $item['options']['image'] }}" alt="" style="width: 4em">
                        @else
                            <img src="{{ url('/uploads/default-product.jpg') }}" alt="" style="width: 4em">
                        @endif
                    </td>
                    <td>
                        <strong>{{ $item['name'] }}</strong><br>
                        {{ $item['options']['description'] ?? '' }} <br>
                        <span class="text-dark">${{ number_format($item['price'] * $item['qty'], 2) }}</span>
                    </td>
                    <td>
                        <span class="badge badge-light">{{ $item['qty'] }}</span>
                    </td>
                </tr>
                @endforeach
            </table>

            <hr>
            <table class="table your-order-table table-bordered">
                <tr>
                    <th colspan="2">Price Details</th>
                </tr>
                <tr>
                    <td>Subtotal</td>
                    <td>${{ $cart->getSubtotal() }}</td>
                </tr>
                <tr>
                    <td>Tax</td>
                    <td>${{ $cart->getTax() }}</td>
                </tr>
                <tr>
                    <th>Total</th>
                    <th>${{ $cart->getTotal() }}</th>
                </tr>
            </table>
        </div>
    </div>

    <div class="mt-5"><hr></div>
@endsection

@section('script')
    <script>
        // Create a Stripe client with the latest version
        const stripe = Stripe('pk_test_51QRCs9LJvVANMm0OIQQIILc1xTHMRRAtQQkRqoW9ftNPY5II0TfgsWLQuqOUiNgYkuuYtXrDmMrGYCMBPBPQwVJs00QA0h8VNy');

        // Create an instance of Elements
        const elements = stripe.elements();

        // Custom styling
        const style = {
            base: {
                color: '#32325d',
                lineHeight: '18px',
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                    color: '#aab7c4'
                }
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
            }
        };

        // Create card element
        const card = elements.create('card', {
            style: style,
            hidePostalCode: true
        });

        // Mount card element
        card.mount('#card-element');

        // Handle real-time validation errors
        card.addEventListener('change', function(event) {
            const displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        // Handle form submission
        const form = document.getElementById('payment-form');
        form.addEventListener('submit', async function(event) {
            event.preventDefault();
            
            // Disable the submit button to prevent double submission
            const submitButton = form.querySelector('button[type="submit"]');
            submitButton.disabled = true;
            
            try {
                const result = await stripe.createToken(card, {
                    name: document.getElementById('name_on_card').value,
                    address_line1: document.getElementById('address').value,
                    address_city: document.getElementById('city').value,
                    address_state: document.getElementById('province').value,
                    address_zip: document.getElementById('postal').value
                });

                if (result.error) {
                    // Handle errors
                    const errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                    submitButton.disabled = false;
                } else {
                    // Send token to server
                    stripeTokenHandler(result.token);
                }
            } catch (error) {
                console.error('Error:', error);
                const errorElement = document.getElementById('card-errors');
                errorElement.textContent = 'An error occurred while processing your payment. Please try again.';
                submitButton.disabled = false;
            }
        });

        // Submit the form with the token
        function stripeTokenHandler(token) {
            const form = document.getElementById('payment-form');
            const hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);
            form.submit();
        }
    </script>
@endsection