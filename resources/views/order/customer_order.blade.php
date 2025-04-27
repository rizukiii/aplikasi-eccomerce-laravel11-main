@extends('layouts.front')

@section('title', 'Order')

@section('content')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="shop-checkout container">
            <h2 class="page-title">{{ __('customer_order.personal_information') }}</h2>
            <div class="checkout-steps">
                <a href="checkout.html" class="checkout-steps__item active">
                    <span class="checkout-steps__item-number">02</span>
                    <span class="checkout-steps__item-title">
                        <span>{{ __('customer_order.personal_information') }}</span>
                        <em>{{ __('customer_order.complete_your_personal_data') }}</em>
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
                                <h4>{{ __('customer_order.information_details') }}</h4>
                            </div>
                            <div class="col-6">
                            </div>
                        </div>

                        <div class="row mt-5">
                            <div class="col-md-6">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control" name="name" required>
                                    <label for="name">{{ __('customer_order.full_name') }} *</label>
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating my-3">
                                    <input type="number" class="form-control" name="phone" required>
                                    <label for="phone">{{ __('customer_order.phone_number') }} *</label>
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating my-3">
                                    <input type="email" class="form-control" name="email" required>
                                    <label for="email">{{ __('customer_order.email') }} *</label>
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating my-3">
                                    <input type="number" class="form-control" name="post_code" required>
                                    <label for="post_code">{{ __('customer_order.post_code') }} *</label>
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control" name="city" required>
                                    <label for="city">{{ __('customer_order.city') }} *</label>
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control" name="address" required>
                                    <label for="address">{{ __('customer_order.address') }} *</label>
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="checkout__totals-wrapper">
                        <div class="sticky-content">
                            <div class="checkout__totals">
                                <h3>{{ __('customer_order.your_order') }}</h3>
                                <table class="checkout-cart-items">
                                    <thead>
                                        <tr>
                                            <th>{{ __('customer_order.product') }}</th>
                                            <th align="right">{{ __('customer_order.subtotal') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                {{ $product->name }}
                                            </td>
                                            <td align="right">
                                                {{ __('front.format_price') }} {{ number_format($orderData['sub_total_amount'], 0, ',', '.') }}
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                                <table class="checkout-totals">
                                    <tbody>
                                        <tr>
                                            <th>{{ __('customer_order.subtotal') }}</th>
                                            <td align="right">{{ __('front.format_price') }}
                                                {{ number_format($orderData['sub_total_amount'], 0, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <th>{{ __('customer_order.discount') }}</th>
                                            <td align="right">{{ __('front.format_price') }} {{ number_format($orderData['discount_amount'] ?? 0, 0, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <th>{{ __('customer_order.tax') }}</th>
                                            <td align="right">{{ __('front.format_price') }} {{ number_format($orderData['total_tax'], 0, ',', '.') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>{{ __('customer_order.total') }}</th>
                                            <td align="right">{{ __('front.format_price') }}
                                                {{ number_format($orderData['grand_total_amount'], 0, ',', '.') }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <button type="submit" class="btn btn-primary btn-checkout">{{ __('customer_order.place_order') }}</button>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </main>
@endsection
