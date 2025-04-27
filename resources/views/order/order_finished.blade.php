@extends('layouts.front')

@section('title', __('order_finished.order_received'))

@section('content')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="shop-checkout container">
            <h2 class="page-title">{{ __('order_finished.order_received') }}</h2>
            <div class="checkout-steps">
                <a href="order-confirmation.html" class="checkout-steps__item active">
                    <span class="checkout-steps__item-number">04</span>
                    <span class="checkout-steps__item-title">
                        <span>{{ __('order_finished.confirmation') }}</span>
                        <em>{{ __('order_finished.review_and_submit_order') }}</em>
                    </span>
                </a>
            </div>
            <div class="order-complete">
                <div class="order-complete__message">
                    <svg width="80" height="80" viewBox="0 0 80 80" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <circle cx="40" cy="40" r="40" fill="#B9A16B" />
                        <path
                            d="M52.9743 35.7612C52.9743 35.3426 52.8069 34.9241 52.5056 34.6228L50.2288 32.346C49.9275 32.0446 49.5089 31.8772 49.0904 31.8772C48.6719 31.8772 48.2533 32.0446 47.952 32.346L36.9699 43.3449L32.048 38.4062C31.7467 38.1049 31.3281 37.9375 30.9096 37.9375C30.4911 37.9375 30.0725 38.1049 29.7712 38.4062L27.4944 40.683C27.1931 40.9844 27.0257 41.4029 27.0257 41.8214C27.0257 42.24 27.1931 42.6585 27.4944 42.9598L33.5547 49.0201L35.8315 51.2969C36.1328 51.5982 36.5513 51.7656 36.9699 51.7656C37.3884 51.7656 37.8069 51.5982 38.1083 51.2969L40.385 49.0201L52.5056 36.8996C52.8069 36.5982 52.9743 36.1797 52.9743 35.7612Z"
                            fill="white" />
                    </svg>
                    <h3>{{ __('order_finished.your_order_is_completed') }}</h3>
                    <p>{{ __('order_finished.thank_you') }}</p>
                </div>
                <div class="order-info">
                    <div class="order-info__item">
                        <label>{{ __('order_finished.order_number') }}</label>
                        <span>{{ $productTransaction->booking_trx_id }}</span>
                    </div>
                    <div class="order-info__item">
                        <label>{{ __('order_finished.date') }}</label>
                        <span>{{ $productTransaction->created_at->format('d/m/Y') }}</span>
                    </div>
                    <div class="order-info__item">
                        <label>{{ __('order_finished.post_code') }}</label>
                        <span>{{ $productTransaction->post_code }}</span>
                    </div>
                    <div class="order-info__item">
                        <label>{{ __('order_finished.name') }}</label>
                        <span>{{ $productTransaction->name }}</span>
                    </div>
                </div>
                <div class="order-info">
                    <div class="order-info__item">
                        <label>{{ __('order_finished.phone') }}</label>
                        <span>{{ $productTransaction->phone }}</span>
                    </div>
                    <div class="order-info__item">
                        <label>{{ __('order_finished.email') }}</label>
                        <span>{{ $productTransaction->email }}</span>
                    </div>
                    <div class="order-info__item">
                        <label>{{ __('order_finished.city') }}</label>
                        <span>{{ $productTransaction->city }}</span>
                    </div>
                    <div class="order-info__item">
                        <label>{{ __('order_finished.address') }}</label>
                        <span>{{ $productTransaction->address }}</span>
                    </div>
                </div>
                <div class="checkout__totals-wrapper">
                    <div class="checkout__totals">
                        <h3>{{ __('order_finished.order_details') }}</h3>
                        <table class="checkout-cart-items">
                            <thead>
                                <tr>
                                    <th>{{ __('order_finished.product') }}</th>
                                    <th>{{ __('order_finished.subtotal') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        {{ $productTransaction->product->name }} x {{ $productTransaction->quantity }}
                                    </td>
                                    <td>
                                        Rp {{ number_format($productTransaction->product->price, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="checkout-totals">
                            <tbody>
                                <tr>
                                    <th>{{ __('order_finished.subtotal') }}</th>
                                    <td>Rp {{ number_format($productTransaction->sub_total_amount, 0, ',', '.') }}</td>
                                </tr>
                                {{-- <tr>
                                    <th>{{ __('order_finished.shipping') }}</th>
                                    <td>{{ __('order_finished.free_shipping') }}</td>
                                </tr> --}}
                                <tr>
                                    <th>{{ __('order_finished.disc') }}</th>
                                    <td>Rp {{ number_format($productTransaction->discount_amount, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('order_finished.total') }}</th>
                                    <td>Rp {{ number_format($productTransaction->grand_total_amount, 0, ',', '.') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="mobile_fixed-btn_wrapper text-center">
                        <div class="button-wrapper container">
                            <a href="{{ route('front.index') }}"
                                class="btn btn-primary btn-checkout">{{ __('order_finished.back_to_home') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

@endsection
