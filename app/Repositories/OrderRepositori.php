<?php

namespace App\Repositories;

use App\Models\ProductTransactions;
use App\Repositories\Contracts\OrderRepositoriInterface;
use Illuminate\Support\Facades\Session;

class OrderRepositori implements OrderRepositoriInterface
{
    public function createTransaction(array $data)
    {
        return ProductTransactions::create($data);
    }

    public function findByTrxIdAndPhoneNumber($bookingTrxId, $phoneNumnber)
    {
        return ProductTransactions::where('booking_trx_id',$bookingTrxId)
                                    ->where('phone_number',$phoneNumnber)
                                    ->first();
    }

    public function saveToSession(array $data)
    {
        Session::put('orderData', $data);
    }

    public function getOrderDataFromSession()
    {
        return session('orderData',[]);

    }

    public function updateSessionData(array $data)
    {
        $orderData = session('orderData',[]);
        $orderData = array_merge($orderData, $data);
        session(['orderData' => $orderData]);
    }
}
