<?php

namespace App\Repositories\Contracts;

interface OrderRepositoriInterface
{

    public function createTransaction(array $data);
    public function findByTrxIdAndPhoneNumber($bookingTrxId, $phoneNumnber);
    public function saveToSession(array $data);
    public function updateSessionData(array $data);
    public function getOrderDataFromSession();
}
