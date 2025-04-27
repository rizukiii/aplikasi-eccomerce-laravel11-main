<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerDataRequest;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\StorePayementRequest;
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

    // public function saveOrder(StoreOrderRequest $request, $slug)
    // {
    //     // dd($request);
    //     // Ambil produk berdasarkan slug
    //     $product = Products::where('slug', $slug)->first();
    //     $validated = $request->validated();
    //     $validated['products_id'] = $product->id;

    //     $this->orderService->beginOrder($validated);
    //     return redirect()->route('front.booking', $product->slug);
    // }

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
        $productTransaction = ProductTransactions::findOrFail($id);
        return view('order.order_finished', compact('productTransaction'));
    }

    // public function saveOrder(StoreOrderRequest $request, $slug)
    // {
    //     // dd($request);
    //     // Ambil produk berdasarkan slug
    //     $product = Products::where('slug', $slug)->first();
    //     $validated = $request->validated();
    //     $validated['products_id'] = $product->id;

    //     $this->orderService->beginOrder($validated);
    //     return redirect()->route('front.booking', $product->slug);
    // }

    public function saveOrder(Request $request, $slug)
    {
        $request->validate([
            'quantity' => ['required', 'numeric', 'min:1'],
            'size_id' => ['required', 'integer', 'min:1'],
        ]);

        $validated = $request->only([
            'quantity',
            'size_id',
        ]);

        // Cari produk berdasarkan slug
        $product = Products::where('slug', $slug)->firstOrFail();

        // Ambil size berdasarkan size_id yang dikirimkan
        $productSize = $product->sizes->where('id', $validated['size_id'])->first();

        // Jika ukuran produk tidak ditemukan, set default atau kosong
        $productSize = $productSize ? $productSize->size : '';

        // Menyiapkan data untuk disimpan dalam session
        $orderData = [
            'products_id' => $product->id,
            'product_size' => $productSize,
            'size_id' => $validated['size_id'],
            'quantity' => $validated['quantity'],
        ];

        // Simpan ke dalam session
        Session::put('orderData', $orderData);

        // Redirect ke halaman booking
        return redirect()->route('front.booking', $product->slug);
    }

}

