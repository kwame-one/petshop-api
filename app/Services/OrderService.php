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
        $formattedProducts = $productsData->map(fn($item) => [
            'uuid' => $productsMap[$item['uuid']]['uuid'],
            'price' => $productsMap[$item['uuid']]['price'],
            'product' => $productsMap[$item['uuid']]['title'],
            'quantity' => $item['quantity'],
        ])->toArray();
        $orderData = [
            'user_id' => $user['id'],
            'order_status_id' => $orderStatus['id'],
            'payment_id' => $payment['id'],
            'products' => $formattedProducts,
            'address' => $data['address'],
            'amount' => $total,
            'delivery_fee' => $total > 500 ? 0 : 15,
        ];
        $order = $this->repository->store($orderData);
        return ['uuid' => $order['uuid']];
    }

    public function find($id, $data = null): mixed
    {
        if (is_null($data)) {
            return $this->repository->find($id);
        }
        $user = $this->userRepository->find($data['uuid']);
        return $this->repository->findByIdAndUserId($id, $user ? $user->id : 0);
    }

    public function delete($id, $data = null): bool
    {
        $user = $this->userRepository->find($data['uuid']);
        $resource = $this->repository->findByIdAndUserId($id, $user ? $user->id : 0);

        if (!$resource) {
            return false;
        }

        $resource->delete();
        return true;
    }
}