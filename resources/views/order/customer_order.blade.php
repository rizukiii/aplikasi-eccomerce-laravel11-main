@extends('layouts.front')

@section('title','Order')

@section('content')
<!-- resources/views/order/booking.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Order Details</h2>

    <form action="{{ route('front.save_customer_data') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $orderData['name'] ?? '') }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $orderData['email'] ?? '') }}" required>
        </div>

        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone', $orderData['phone'] ?? '') }}" required>
        </div>

        <div class="form-group">
            <label for="address">Address</label>
            <textarea name="address" class="form-control" required>{{ old('address', $orderData['address'] ?? '') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Save Customer Data</button>
    </form>
</div>
@endsection

@endsection
