@extends('layouts.front')

@section('title', 'Order')

@section('content')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="shop-checkout container">
            <h2 class="page-title">Cart</h2>
            <div class="checkout-steps">
                <a href="cart.html" class="checkout-steps__item active">
                    <span class="checkout-steps__item-number">01</span>
                    <span class="checkout-steps__item-title">
                        <span>Shopping Bag</span>
                        <em>Manage Your Items List</em>
                    </span>
                </a>
            </div>
            <div class="shopping-cart">
                <div class="cart-table__wrapper">
                    <table class="cart-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th></th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="shopping-cart__product-item">
                                        <img loading="lazy" src="{{ Storage::url($product->thumbnail) }}" width="120"
                                            height="120" alt="{{ $product->name }}" />
                                    </div>
                                </td>
                                <td>
                                    <div class="shopping-cart__product-item__detail">
                                        <h4>{{ $product->name }}</h4>
                                        <ul class="shopping-cart__product-item__options">
                                            <li>{{ $product->size ?? 'S' }}</li>
                                        </ul>
                                    </div>
                                </td>
                                <td>
                                    <span class="shopping-cart__product-price">Rp{{ number_format($product->price, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td>
                                    <div class="qty-control position-relative">
                                        <input type="number" name="quantity" value="3" min="1"
                                            class="qty-control__number text-center" disabled>

                                    </div>
                                </td>
                                <td>
                                    <span class="shopping-cart__subtotal">Rp {{ number_format($orderData['sub_total_amount'], 0, ',', '.') }}
                                    </span>
                                </td>
                                <td>
                                    <a href="#" class="remove-cart">
                                        <svg width="10" height="10" viewBox="0 0 10 10" fill="#767676"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M0.259435 8.85506L9.11449 0L10 0.885506L1.14494 9.74056L0.259435 8.85506Z" />
                                            <path
                                                d="M0.885506 0.0889838L9.74057 8.94404L8.85506 9.82955L0 0.97449L0.885506 0.0889838Z" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="cart-table-footer">
                        <form action="#" class="position-relative bg-body">
                            <input class="form-control" type="text" name="coupon_code" placeholder="Coupon Code">
                            <input class="btn-link fw-medium position-absolute top-0 end-0 h-100 px-4" type="submit"
                                value="APPLY COUPON">
                        </form>
                        <button class="btn btn-light">UPDATE CART</button>
                    </div>
                </div>
                <div class="shopping-cart__totals-wrapper">
                    <div class="sticky-content">
                        <div class="shopping-cart__totals">
                            <h3>Cart Totals</h3>
                            <table class="cart-totals">
                                <tbody>
                                    <tr>
                                        <th>Subtotal</th>
                                        <td>Rp {{ number_format($orderData['sub_total_amount'], 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Disc</th>
                                        <td>Rp
                                            {{-- {{ number_format($orderData['total_disc'], 0, ',', '.') ?? 0 }} --}} 0
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Tax</th>
                                        <td>Rp {{ number_format($orderData['total_tax'], 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Total</th>
                                        <td>Rp {{ number_format($orderData['grand_total_amount'], 0, ',', '.') }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="mobile_fixed-btn_wrapper">
                            <div class="button-wrapper container">
                                <a href="{{ route('front.customer_data') }}" class="btn btn-primary btn-checkout">PROCEED TO CHECKOUT</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>



@endsection
