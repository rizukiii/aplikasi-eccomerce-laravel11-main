@extends('layouts.front')

@section('title', 'Order')

@section('content')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="shop-checkout container">
            <h2 class="page-title">Shipping and Checkout</h2>
            <div class="checkout-steps">
                <a href="checkout.html" class="checkout-steps__item active">
                    <span class="checkout-steps__item-number">02</span>
                    <span class="checkout-steps__item-title">
                        <span>Shipping and Checkout</span>
                        <em>Checkout Your Items List</em>
                    </span>
                </a>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form name="checkout-form" action="{{ route('front.save_customer_data') }}" method="post">
                @csrf
                <div class="checkout-form">
                    <div class="billing-info__wrapper">
                        <div class="row">
                            <div class="col-6">
                                <h4>SHIPPING DETAILS</h4>
                            </div>
                            <div class="col-6">
                            </div>
                        </div>

                        <div class="row mt-5">
                            <div class="col-md-6">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control" name="name" required>
                                    <label for="name">Full Name *</label>
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating my-3">
                                    <input type="number" class="form-control" name="phone" required>
                                    <label for="phone">Phone Number *</label>
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating my-3">
                                    <input type="email" class="form-control" name="email" required>
                                    <label for="email">Email *</label>
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating my-3">
                                    <input type="number" class="form-control" name="post_code" required>
                                    <label for="post_code">Post Code *</label>
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control" name="city" required>
                                    <label for="city">City *</label>
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control" name="address" required>
                                    <label for="address">Address *</label>
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                        </div>
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
                                            <td align="right">Rp {{ number_format($orderData['discount_amount'], 0, ',', '.') }}</td>
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
                            <button type="submit" class="btn btn-primary btn-checkout">PLACE ORDER</button>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </main>
@endsection
