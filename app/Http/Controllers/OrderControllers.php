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

    public function saveOrder(StoreOrderRequest $request, $slug)
    {
        // dd($request);
        // Ambil produk berdasarkan slug
        $product = Products::where('slug', $slug)->first();
        $validated = $request->validated();
        $validated['products_id'] = $product->id;

        $this->orderService->beginOrder($validated);
        return redirect()->route('front.booking', $product->slug);
    }

    public function booking()
    {
        $data = $this->orderService->getOrderDetails();

        // Debug untuk memastikan bentuknya
    // dd($data);
        return view('order.order', $data);
    }

    public function customerData()
    {
        $data = $this->orderService->getOrderDetails();
        return view('order.customer_order', $data);
    }

    public function saveCustomerData(StoreCustomerDataRequest $request)
    {
        // dd( $request);
        $validated = $request->validated();
        $this->orderService->updateCustomerData($validated);

        return redirect()->route('front.payment');
    }

    public function payment()
    {
        $data = $this->orderService->getOrderDetails();
        return view('order.payment', $data);
    }

    public function paymentConfirm(StorePayementRequest $request)
    {
        $validated = $request->validated();
        // dd( $validated);
        // dd(session()->all());

        $productTransactionId = $this->orderService->paymentConfirm($validated);
// dd( $productTransactionId);
        if ($productTransactionId) {
            return redirect()->route('front.order_finished', $productTransactionId);
        }
        return redirect()->back()->withErrors(['error' => 'Payment failed. Please try again']);
    }

    public function orderFinished(ProductTransactions $productTransaction)
    {
        return view('order.order_finished', compact('productTransaction'));
    }
}
