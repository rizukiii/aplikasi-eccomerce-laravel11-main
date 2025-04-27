@extends('layouts.front')

@section('title', 'Payment')

@section('content')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="shop-checkout container">
            <h2 class="page-title">{{ __('payment.payment') }}</h2>
            <div class="checkout-steps">
                <a href="order-confirmation.html" class="checkout-steps__item">
                    <span class="checkout-steps__item-number">03</span>
                    <span class="checkout-steps__item-title">
                        <span>{{ __('payment.process_payment') }}</span>
                        <em>{{ __('payment.pay_and_submit_order') }}</em>
                    </span>
                </a>
            </div>
            <div class="shopping-cart__totals-wrapper">
                <div class="row">
                    <div class="col-8 text-center mt-4">
                        <h2>{{ __('payment.qris') }}</h2>
                        <img src="https://gkjw.or.id/wp-content/uploads/2023/05/QRIS-Dummy.jpg" alt=""
                            style="width: 600px; height: 600px;">
                        <h3 class="mt-3">A.N Rinaldi Firdaus</h3>
                    </div>

                    <div class="col-4 mt-5">
                        <div class="mt-5">
                            <form action="{{ route('front.payment_confirm') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="shopping-cart__totals ms-3 mt-5">
                                    <h3>{{ __('payment.grand_totals') }}</h3>
                                    <table class="cart-totals">
                                        <tbody>
                                            <tr>
                                                <th>{{ __('payment.subtotal') }}</th>
                                                <td>Rp {{ number_format($orderData['sub_total_amount'], 0, ',', '.') }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('payment.disc') }}</th>
                                                <td>Rp
                                                    {{ number_format($orderData['discount_amount'], 0, ',', '.') }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('payment.tax') }}</th>
                                                <td>Rp {{ number_format($orderData['total_tax'], 0, ',', '.') }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>{{ __('payment.total') }}</th>
                                                <td>Rp {{ number_format($orderData['grand_total_amount'], 0, ',', '.') }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="mb-3 mt-5">
                                    <label for="proof" class="form-label">{{ __('payment.proof_of_payment') }}</label>
                                    <input type="file" class="form-control" name="proof" id="proof"
                                        placeholder="{{ __('payment.proof_of_payment') }}" />
                                </div>
                                <input type="hidden" name="sub_total_amount" value="{{ $orderData['sub_total_amount'] }}">
                                <input type="hidden" name="grand_total_amount" value="{{ $orderData['grand_total_amount'] }}">
                                <div class="mobile_fixed-btn_wrapper">
                                    <div class="button-wrapper container">
                                        <button type="submit"
                                            class="btn btn-primary btn-checkout">{{ __('payment.proceed_to_payment') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <h2 class="text-center mt-1">{{ __('payment.transfer_bank') }}</h2>
                <div class="col-3 text-center">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRUA2kqUQIf_RTz3evvjkgAjnKC_piTxR0RUg&sa "
                        alt="" style="width: 266px;height: 190px; object-fit: cover;">
                    <h3>{{ __('payment.account_number') }}: 8723450982</h3>
                    <p>{{ __('payment.account_name') }}: A.N Rizki FEbian</p>
                </div>
                <div class="col-3 text-center">
                    <img src="https://buatlogoonline.com/wp-content/uploads/2022/10/Logo-BCA-PNG.png" alt=""
                        style="width: 266px;height: 190px; object-fit: cover;">
                    <h3>{{ __('payment.account_number') }}: 8723450982</h3>
                    <p>{{ __('payment.account_name') }}: A.N Rizki FEbian</p>
                </div>
                <div class="col-3 text-center">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcShne_g0DhrXLV1yNO6k48XQuzfkn6QNtQcOg&s"
                        alt="" style="width: 266px;height: 190px; object-fit: cover;">
                    <h3>{{ __('payment.account_number') }}: 8723450982</h3>
                    <p>{{ __('payment.account_name') }}: A.N Rizki FEbian</p>
                </div>
                <div class="col-3 text-center">
                    <img src="https://images.seeklogo.com/logo-png/40/1/bank-syariah-indonesia-logo-png_seeklogo-400980.png"
                        alt="" style="width: 266px;height: 190px; object-fit: cover;">
                    <h3>{{ __('payment.account_number') }}: 8723450982</h3>
                    <p>{{ __('payment.account_name') }}: A.N Rizki FEbian</p>
                </div>
            </div>
        </section>
    </main>

@endsection
