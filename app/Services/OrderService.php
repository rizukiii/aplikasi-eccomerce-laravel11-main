<?php

namespace App\Services;

use App\Models\ProductTransactions;
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
        // dd($data); // Debug data yang diterima
        $orderData = [
            'product_size' => $data['product_size'],
            'size_id' => $data['size_id'],
            'products_id' => $data['products_id']
        ];

        $this->orderRepository->saveToSession($orderData);
    }


    public function getOrderDetails()
    {
        $orderData = $this->orderRepository->getOrderDataFromSession();

        $product = $this->productRepository->find($orderData['products_id']);

        $quantity = isset($orderData['quantity']) ? $orderData['quantity'] : 1;

        $subtotalAmount = $product->price * $quantity;

        $taxRate = 0.11;
        $totalTax = $subtotalAmount * $taxRate;

        $grandtotalAmount = $subtotalAmount + $totalTax;

        $orderData['sub_total_amount'] = $subtotalAmount;
        $orderData['total_tax'] = $totalTax;
        $orderData['grand_total_amount'] = $grandtotalAmount;

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
                'discount' => $discount,
                'grandTotalAmount' => $grandtotalAmount,
                'promoCodeId' => $promoCodeId
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
}
