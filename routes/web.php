<?php

use App\Http\Controllers\FrontControllers;
use App\Http\Controllers\OrderControllers;
use Illuminate\Support\Facades\Route;

Route::get('/',[FrontControllers::class, 'index'])->name('front.index');
Route::get('/browse/{category:slug}',[FrontControllers::class, 'category'])->name('front.category');
Route::get('/details/{products:slug}',[FrontControllers::class, 'details'])->name('front.details');

Route::post('/order/begin/{id}',[OrderControllers::class, 'saveOrder'])->name('front.save_order');
Route::get('/order/booking',[OrderControllers::class, 'booking'])->name('front.booking');

Route::get('/order/booking/customer-data',[OrderControllers::class, 'customerData'])->name('front.customer_data');
Route::post('/order/booking/customer-data/save',[OrderControllers::class, 'saveCustomerData'])->name('front.save_customer_data');

Route::get('/order/payment',[OrderControllers::class, 'payment'])->name('front.payment');
Route::post('/order/payment/confirm',[OrderControllers::class, 'paymentConfirm'])->name('front.payment_confirm');


Route::get('/order/finished',[OrderControllers::class, 'orderFinished'])->name('front.order_finished'); // 'front.details ubah jadi front_order.details karena bentrok dengan line 9


