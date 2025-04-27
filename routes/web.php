<?php

use App\Http\Controllers\FrontControllers;
use App\Http\Controllers\OrderControllers;
use Illuminate\Support\Facades\Route;

Route::get('/',[FrontControllers::class, 'index'])->name('front.index');
Route::get('/browse/{slug}',[FrontControllers::class, 'category'])->name('front.category');
Route::get('/details/{slug}',[FrontControllers::class, 'details'])->name('front.details');

Route::post('/order/begin/{slug}',[OrderControllers::class, 'saveOrder'])->name('front.save_order');
Route::get('/order/booking',[OrderControllers::class, 'booking'])->name('front.booking'); // cart
Route::post('/order/updatecart',[OrderControllers::class, 'updateCart'])->name('front.updatecart'); // cart
// untuk menambah produk ke cart, posisi user masi disini bisa menambah/mengubah produknya, dan ada tombol checkout jika di klik maka semua data di local storage akan dikirim ke route '/order/booking/customer-data'

Route::get('/order/booking/customer-data',[OrderControllers::class, 'customerData'])->name('front.customer_data');
// ini isinya list barang yang akan di payment atau order,
Route::post('/order/booking/customer-data/save',[OrderControllers::class, 'saveCustomerData'])->name('front.save_customer_data');

Route::get('/order/payment',[OrderControllers::class, 'payment'])->name('front.payment');
Route::post('/order/payment/confirm',[OrderControllers::class, 'paymentConfirm'])->name('front.payment_confirm');


Route::get('/order/finished/{id}',[OrderControllers::class, 'orderFinished'])->name('front.order_finished'); // 'front.details ubah jadi front_order.details karena bentrok dengan line 9

