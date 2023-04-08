<?php

namespace App\Repositories;

use App\Models\Payment;

class PaymentRepository extends CoreRepository
{
    public function __construct()
    {
        parent::__construct(Payment::class);
    }
}