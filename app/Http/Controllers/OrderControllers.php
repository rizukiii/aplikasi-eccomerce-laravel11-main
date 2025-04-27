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
        // dd(session()->all());
        $data = $this->orderService->getOrderDetails();

        // Debug untuk memastikan bentuknya
        // dd($data);
        return view('order.order', $data);
    }

    public function updateCart(Request $request)
    {
        // Ambil produk berdasarkan ID
        $product = Products::findOrFail($request->product_id);

        // Validasi input form
        $validated = $request->validate([
            'coupon_code' => 'nullable|string|exists:promo_codes,code',
            'size' => 'required|string|exists:product_sizes,id',
            'quantity' => 'required|integer|min:1|max:' . $product->stock,
            'sub_total_amount' => 'required|numeric',
        ]);

        // Update data size dan quantity ke session
        // Cari data size berdasarkan ID
        $productSize = \App\Models\ProductSizes::findOrFail($validated['size']); // <-- cari size berdasarkan ID

        $orderData['product_size'] = $productSize->size; // Ambil nama size-nya
        $orderData['size_id'] = $productSize->id; // (optional) kalau mau simpan ID juga

        $orderData['quantity'] = $validated['quantity'];

        // Jika user input coupon code, proses promo code
        if (!empty($validated['coupon_code'])) {
            $promoResult = $this->orderService->applyPromoCode($validated['coupon_code'], $validated['sub_total_amount']);

            // Cek error dari promo
            if (isset($promoResult['error'])) {
                return back()->withErrors(['coupon_code' => $promoResult['error']]);
            }

            // Update hasil promo ke orderData
            $orderData['discount_amount'] = $promoResult['discount_amount'];
            $orderData['grand_total_amount'] = $promoResult['grand_total_amount'];
            $orderData['promo_code'] = $validated['coupon_code']; // Tetap simpan code

            // Cari ID dari promo code
            $promo = \App\Models\PromoCodes::where('code', $validated['coupon_code'])->first();
            if ($promo) {
                $orderData['promo_codes_id'] = $promo->id;
            }
        }

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

