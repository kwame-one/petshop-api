<?php

namespace App\Models;

use App\Validators\OrderStatusRequestValidator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    use HasFactory;
    use OrderStatusRequestValidator;

    protected $guarded = ['id'];
}
