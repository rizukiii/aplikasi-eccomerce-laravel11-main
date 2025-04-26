@extends('layouts.front')

@section('title', 'Order')

@section('content')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="shop-checkout container">
            <h2 class="page-title">Payment</h2>
            <div class="checkout-steps">
                <a href="checkout.html" class="checkout-steps__item active">
                    <span class="checkout-steps__item-number">03</span>
                    <span class="checkout-steps__item-title">
                        <span>Payment</span>
                        <em>Pay Your Items List</em>
                    </span>
                </a>
            </div>
            <br>
            <br>
            <div class="checkout__payment-methods col-6">
                <div class="form-check">
                    <input class="form-check-input form-check-input_fill" type="radio" name="checkout_payment_method"
                        id="checkout_payment_method_1" checked>
                    <label class="form-check-label" for="checkout_payment_method_1">
                        Direct bank transfer
                        <p class="option-detail">
                            Make your payment directly into our bank account. Please use your Order ID as
                            the payment
                            reference.Your order will not be shipped until the funds have cleared in our
                            account.
                        </p>
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input form-check-input_fill" type="radio" name="checkout_payment_method"
                        id="checkout_payment_method_2">
                    <label class="form-check-label" for="checkout_payment_method_2">
                        Qris
                        <p class="option-detail">
                            Phasellus sed volutpat orci. Fusce eget lore mauris vehicula elementum gravida
                            nec dui. Aenean
                            aliquam varius ipsum, non ultricies tellus sodales eu. Donec dignissim viverra
                            nunc, ut aliquet
                            magna posuere eget.
                        </p>
                    </label>
                </div>
                {{-- <div class="form-check">
                    <input class="form-check-input form-check-input_fill" type="radio" name="checkout_payment_method"
                        id="checkout_payment_method_3">
                    <label class="form-check-label" for="checkout_payment_method_3">
                        Cash on delivery
                        <p class="option-detail">
                            Phasellus sed volutpat orci. Fusce eget lore mauris vehicula elementum gravida nec dui. Aenean
                            aliquam varius ipsum, non ultricies tellus sodales eu. Donec dignissim viverra nunc, ut aliquet
                            magna posuere eget.
                        </p>
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input form-check-input_fill" type="radio" name="checkout_payment_method"
                        id="checkout_payment_method_4">
                    <label class="form-check-label" for="checkout_payment_method_4">
                        Paypal
                        <p class="option-detail">
                            Phasellus sed volutpat orci. Fusce eget lore mauris vehicula elementum gravida nec dui. Aenean
                            aliquam varius ipsum, non ultricies tellus sodales eu. Donec dignissim viverra nunc, ut aliquet
                            magna posuere eget.
                        </p>
                    </label>
                </div> --}}
                <div class="policy-text">
                    Your personal data will be used to process your order, support your experience
                    throughout this
                    website, and for other purposes described in our <a href="terms.html" target="_blank">privacy
                        policy</a>.
                </div>
            </div>
            <form action="{{ route('front.payment_confirm') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="proof">Upload Proof of Payment</label>
                    <input type="file" name="proof" class="form-control" required>
                </div>

                {{-- <div class="form-group">
                    <label for="promo_code">Promo Code (Optional)</label>
                    <input type="text" name="promo_code" class="form-control"
                        placeholder="Enter promo code if available">
                </div> --}}

                <button type="submit" class="btn btn-success">Confirm Payment</button>
            </form>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            </div>
            <div class="checkout__totals-wrapper">
                <div class="sticky-content">
                    <div class="checkout__totals">
                        <h3>Your Order</h3>
                        <table class="checkout-cart-items">
                            <thead>
                                <tr>
                                    <th>PRODUCT</th>
                                    <th align="right">SUBTOTAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        {{ $product->name }}
                                    </td>
                                    <td align="right">
                                        Rp {{ number_format($orderData['sub_total_amount'], 0, ',', '.') }}
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                        <table class="checkout-totals">
                            <tbody>
                                <tr>
                                    <th>SUBTOTAL</th>
                                    <td align="right">Rp
                                        {{ number_format($orderData['sub_total_amount'], 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>DICS</th>
                                    <td align="right">Rp 0</td>
                                </tr>
                                <tr>
                                    <th>TAX</th>
                                    <td align="right">Rp {{ number_format($orderData['total_tax'], 0, ',', '.') }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>TOTAL</th>
                                    <td align="right">Rp
                                        {{ number_format($orderData['grand_total_amount'], 0, ',', '.') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </section>
    </main>
@endsection
