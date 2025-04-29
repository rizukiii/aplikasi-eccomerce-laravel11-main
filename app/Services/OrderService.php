<?php

namespace App\Services;

use App\Models\ProductSizes;
use App\Models\ProductTransactions;
use App\Models\PromoCodes;
use App\Repositories\Contracts\CategoryRepositoriInterface;
use App\Repositories\Contracts\OrderRepositoriInterface;
use App\Repositories\Contracts\ProductRepositoriInterface;
use App\Repositories\Contracts\PromoCodeRepositoriInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderService
{
    protected $categoryRepository;
    protected $promoCodeRepository;
    protected $orderRepository;
    protected $productRepository;

    public function __construct(
        PromoCodeRepositoriInterface $promoCodeRepository,
        CategoryRepositoriInterface $categoryRepository,
        OrderRepositoriInterface $orderRepository,
        ProductRepositoriInterface $productRepository
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->promoCodeRepository = $promoCodeRepository;
        $this->productRepository = $productRepository;
        $this->orderRepository = $orderRepository;
    }

    public function beginOrder(array $data)
    {
        // Ambil produk berdasarkan ID
        $product = $this->productRepository->find($data['products_id']);

        // Ambil size berdasarkan size_id yang dikirimkan
        $productSize = $product->sizes->where('id', $data['size_id'])->first();
        $productSize = $productSize ? $productSize->size : '';  // Set default jika tidak ditemukan

        // Menyiapkan data untuk disimpan dalam session
        $orderData = [
            'products_id' => $product->id,
            'product_size' => $productSize,
            'size_id' => $data['size_id'],
            'quantity' => $data['quantity'],
        ];

        // Simpan ke dalam session
        $this->orderRepository->saveToSession($orderData);
    }

    public function getOrderDetails()
    {
        $orderData = $this->orderRepository->getOrderDataFromSession();

        // 🚨 Cek dulu apakah products_id ada
        if (!isset($orderData['products_id'])) {
            return redirect()->back()->with('error', 'Silahkan pilih produk dahulu.');
        }

        // Cek apakah ada produk yang diambil di session
        $product = $this->productRepository->find($orderData['products_id']);

        // Tentukan jumlah produk (default 1 jika tidak ada)
        $quantity = isset($orderData['quantity']) ? $orderData['quantity'] : 1;

        // Hitung subtotal berdasarkan harga produk dan jumlah
        $subtotalAmount = $product->price * $quantity;

        // Cek apakah ada diskon yang diterapkan dari kode promo
        $discountAmount = isset($orderData['discount_amount']) ? $orderData['discount_amount'] : 0;

        // Hitung pajak (misalnya 11% dari subtotal setelah diskon)
        $taxRate = 0.11;
        $totalTax = ($subtotalAmount - $discountAmount) * $taxRate; // Pajak dihitung setelah diskon

        // Hitung grand total (subtotal - diskon + pajak)
        $grandtotalAmount = ($subtotalAmount - $discountAmount) + $totalTax;

        // Update orderData dengan informasi harga baru
        $orderData['sub_total_amount'] = $subtotalAmount;
        $orderData['total_tax'] = $totalTax;
        $orderData['grand_total_amount'] = $grandtotalAmount;

        // Return data untuk digunakan di view
        return compact('orderData', 'product');
    }

    public function applyPromoCode(string $code, int $subtotalAmount)
    {
        $promo = $this->promoCodeRepository->findByCode($code);

        if ($promo) {
            $discount = $promo->discount_amount;
            $grandtotalAmount = $subtotalAmount - $discount;
            $promoCodeId = $promo->id;
            return [
                'discount_amount' => $discount,
                'grand_total_amount' => $grandtotalAmount,
                'promo_codes_id' => $promoCodeId
            ];
        }
        return ['error' => 'Kode promo tidak tersedia'];
    }

    public function saveBookingTransaction(array $data)
    {
        $this->orderRepository->saveToSession($data);
    }

    public function updateCustomerData(array $data)
    {
        $this->orderRepository->updateSessionData($data);
    }

    public function paymentConfirm(array $validated)
    {
        // dd($validated);
        $orderData = $this->orderRepository->getOrderDataFromSession();
        // dd($orderData);
        $productTransactionId = null;
        // dd(session()->all());
        try {
            DB::transaction(function () use ($validated, &$productTransactionId, $orderData) {
                if (isset($validated['proof'])) {
                    $proofPath = $validated['proof']->store('proofs', 'public');
                    $validated['proof'] = $proofPath;
                }

                $validated['products_id'] = $orderData['products_id'];
                $validated['product_sizes_id'] = $orderData['size_id'];
                $validated['quantity'] = $orderData['quantity'];
                $validated['sub_total_amount'] = $orderData['sub_total_amount'];
                $validated['grand_total_amount'] = $orderData['grand_total_amount'];
                $validated['discount_amount'] = $orderData['discount_amount'] ?? 0;
                $validated['promo_codes_id'] = $orderData['promo_codes_id'] ?? null;
                $validated['name'] = $orderData['name'];
                $validated['email'] = $orderData['email'];
                $validated['phone'] = $orderData['phone'];
                $validated['address'] = $orderData['address'];
                $validated['post_code'] = $orderData['post_code'];
                $validated['city'] = $orderData['city'];
                $validated['is_paid'] = false;
                $validated['booking_trx_id'] = ProductTransactions::uniqGenerateTrxId();

                $newTransaction = $this->orderRepository->createTransaction($validated);
                // dd( $newTransaction);
                $productTransactionId = $newTransaction->id;
                // dd($productTransactionId);
                return $productTransactionId;
            });

        } catch (\Exception $e) {
            Log::error('Error in payment confirmation', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            session()->flash('error', $e->getMessage());
            return null;
        }
        return $productTransactionId;
    }

    /**
     * Validasi dan update cart dengan data terbaru
     *
     * @param array $validated
     * @return array
     */
    public function updateCartData(array $validated)
    {
        // dd( $validated);
        // Ambil produk berdasarkan ID
        $product = $this->productRepository->find($validated['products_id']);

        // Cari size berdasarkan ID
        $productSize = $this->productRepository->findProductSize($validated['size']);

        // Siapkan data order
        $orderData = [
            'product_size' => $productSize->size, // Ambil nama size-nya
            'size_id' => $productSize->id, // (optional) kalau mau simpan ID juga
            'quantity' => $validated['quantity'],
            'products_id' => $product->id,
        ];

        // Jika ada coupon code, proses promo code
        if (!empty($validated['coupon_code'])) {
            $promoResult = $this->applyPromoCode($validated['coupon_code'], $validated['sub_total_amount']);

            // Cek error dari promo
            if (isset($promoResult['error'])) {
                return $promoResult;
            }

            // Update hasil promo ke orderData
            $orderData['discount_amount'] = $promoResult['discount_amount'];
            $orderData['grand_total_amount'] = $promoResult['grand_total_amount'];
            $orderData['promo_code'] = $validated['coupon_code']; // Tetap simpan code

            // Cari ID dari promo code
            $promo = $this->productRepository->findPromoCode($validated['coupon_code']);
            if ($promo) {
                $orderData['promo_codes_id'] = $promo->id;
            }
        }

        return $orderData;
    }
}
