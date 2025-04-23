@extends('layouts.front')

@section('title','Order')

@section('content')
<!-- resources/views/order/payment.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Payment Confirmation</h2>

    <form action="{{ route('front.payment_confirm') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="proof">Upload Proof of Payment</label>
            <input type="file" name="proof" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="promo_code">Promo Code (Optional)</label>
            <input type="text" name="promo_code" class="form-control" placeholder="Enter promo code if available">
        </div>

        <button type="submit" class="btn btn-success">Confirm Payment</button>
    </form>
</div>
@endsection

@endsection
