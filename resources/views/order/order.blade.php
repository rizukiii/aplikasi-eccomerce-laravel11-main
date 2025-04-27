@extends('layouts.front')

@section('title', 'Order')

@section('content')
    <main>
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
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
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
                        <form action="{{ route('front.updatecart') }}" class="position-relative bg-body" method="post">
                            @csrf
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
                                                <!-- Dropdown untuk ukuran -->
                                                <li>
                                                    <div class="qty-control position-relative mb-2">
                                                        <select name="size" class="form-control">
                                                            @foreach ($product->sizes as $size)
                                                                <option value="{{ $size->id }}"
                                                                    {{ $size->size == $orderData['product_size'] ? 'selected' : '' }}>
                                                                    {{ $size->size }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                    <td>
                                        <span
                                            class="shopping-cart__product-price">Rp{{ number_format($product->price, 0, ',', '.') }}
                                        </span>
                                    </td>
                                    <td>
                                        <small>Tersedia: {{ $product->stock }}</small>
                                        <div class="qty-control position-relative">
                                            <!-- Quantity dibatasi berdasarkan stok -->
                                            <input type="number" name="quantity" value="{{ old('quantity', $orderData['quantity'] ?? 1) }}"
                                                min="1" max="{{ $product->stock }}"
                                                class="qty-control__number text-center">

                                        </div>
                                    </td>
                                    <td>
                                        <span class="shopping-cart__subtotal">Rp
                                            {{ number_format($orderData['sub_total_amount'], 0, ',', '.') }}
                                        </span>
                                    </td>

                                </tr>
                            </tbody>
                    </table>



                    <div class="cart-table-footer">

                        <input class="form-control" type="text" name="coupon_code" placeholder="Coupon Code">
                        <input type="hidden" name="sub_total_amount" value="{{ $orderData['sub_total_amount'] }}">
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <button type="submit" class="btn btn-light">UPDATE CART</button>
                        </form>
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
                                            {{ number_format($orderData['discount_amount'] ?? 0, 0, ',', '.') }}
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
                                <a href="{{ route('front.customer_data') }}" class="btn btn-primary btn-checkout">PROCEED
                                    TO CHECKOUT</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>



@endsection
