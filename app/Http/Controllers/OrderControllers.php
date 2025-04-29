<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerDataRequest;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\StorePayementRequest;
use App\Http\Requests\UpdateCartRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Products;
use App\Models\ProductTransactions;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

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
        $validated = $request->validated();
        $product = Products::where('slug', $slug)->first();

        $this->orderService->beginOrder($validated);
        return redirect()->route('front.booking', $product->slug);
    }

    public function booking()
    {
        // dd(session()->all());
        $data = $this->orderService->getOrderDetails();


        // Debug untuk memastikan bentuknya
        // dd($data);
        return view('order.order', $data);
    }

    public function updateCart(UpdateCartRequest $request)
    {
        // dd($request->products_id);
        // Validasi input form
        $validated = $request->validated();

        // Update data order
        $orderData = $this->orderService->updateCartData($validated);

        // Update data ke session
        $this->orderService->updateCustomerData($orderData);

        // Redirect ke halaman booking/cart
        return redirect()->route('front.booking')->with('success', 'Keranjang berhasil diperbarui!');
    }

    public function customerData()
    {
        // dd(session()->all());
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
        // dd($data);
        return view('order.payment', $data);
    }

    public function paymentConfirm(StorePayementRequest $request)
    {
        $validated = $request->validated();
        // dd( $validated);

        $orderData = [
            'sub_total_amount' => $validated['sub_total_amount'],
            'grand_total_amount' => $validated['grand_total_amount'],
        ];

        $this->orderService->updateCustomerData($orderData);
        // dd(session()->all());

        $productTransactionId = $this->orderService->paymentConfirm($validated);
        // dd( $productTransactionId);
        if ($productTransactionId) {
            return redirect()->route('front.order_finished', $productTransactionId);
        }
        return redirect()->back()->withErrors(['error' => 'Payment failed. Please try again']);
    }

    public function orderFinished($id)
    {
        session()->forget('orderData');
        $productTransaction = ProductTransactions::findOrFail($id);
        return view('order.order_finished', compact('productTransaction'));
    }
}

