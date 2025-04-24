<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerDataRequest;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\StorePayementRequest;
use App\Models\Products;
use App\Models\ProductTransactions;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderControllers extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function saveOrder(StoreOrderRequest $request, Products $id){
        $validated = $request->validated();
        $validated['products_id'] = $id->id;
dd($id);
        $this->orderService->beginOrder($validated);
        return redirect()->route('front.booking', $id->id);
    }

    public function booking(){
        $data = $this->orderService->getOrderDetails();
        return view('order.order',$data);
    }

    public function customerData(){
        $data = $this->orderService->getOrderDetails();
        return view('order.customer_order',$data);
    }

    public function saveCustomerData(StoreCustomerDataRequest $request){
        $validated = $request->validated();
        $this->orderService->updateCustomerData($validated);

        return redirect()->route('front.payment');
    }

    public function payment(){
        $data = $this->orderService->getOrderDetails();
        return view('order.payment',$data);
    }

    public function paymentConfirm(StorePayementRequest $request){
        $validated = $request->validated();
        $productTransactionId = $this->orderService->paymentConfirm($validated);

        if ($productTransactionId) {
            return redirect()->route('front.order_finished', $productTransactionId);
        }
        return redirect()->route('front.index')->withErrors(['error' => 'Payment failed. Please try again']);
    }

    public function orderFinished(ProductTransactions $productTransaction){
        return view('front.order_finished',compact('productTransaction'));
    }
}
