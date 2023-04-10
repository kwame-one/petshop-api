<?php

namespace App\Services;

use App\Repositories\ICoreRepository;
use App\Repositories\OrderStatusRepository;
use App\Repositories\PaymentRepository;
use App\Repositories\ProductRepository;
use App\Repositories\UserRepository;

class OrderService extends CoreService
{
    private UserRepository $userRepository;
    private PaymentRepository $paymentRepository;
    private OrderStatusRepository $orderStatusRepository;
    private ProductRepository $productRepository;

    public function __construct(
        ICoreRepository $repository,
        UserRepository $userRepository,
        PaymentRepository $paymentRepository,
        OrderStatusRepository $orderStatusRepository,
        ProductRepository $productRepository,
    ) {
        parent::__construct($repository);
        $this->userRepository = $userRepository;
        $this->paymentRepository = $paymentRepository;
        $this->orderStatusRepository = $orderStatusRepository;
        $this->productRepository = $productRepository;
    }

    public function store(array $data): mixed
    {
        $user = $this->userRepository->find($data['uuid']);
        $orderStatus = $this->orderStatusRepository->find($data['order_status_uuid']);
        $payment = $this->paymentRepository->find($data['payment_uuid']);
        $productsData = collect($data['products']);
        $products = $this->productRepository->findByUuidIn($productsData->pluck('uuid')->toArray());
        $productsMap = [];
        foreach ($products as $product) {
            $productsMap[$product->uuid] = $product;
        }
        $total = $productsData->map(fn($item) => $productsMap[$item['uuid']]['price'] * $item['quantity'])->sum();
        $orderData = [
            'user_id' => $user['id'],
            'order_status_id' => $orderStatus['id'],
            'payment_id' => $payment['id'],
            'products' => $data['products'],
            'address' => $data['address'],
            'amount' => $total,
        ];
        $order =  $this->repository->store($orderData);
        return ['uuid' => $order['uuid']];
    }
}