<?php

namespace App\Models;

use App\Validators\OrderRequestValidator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    use OrderRequestValidator;

    protected $guarded = ['id'];

    protected $hidden = ['id'];

    protected $casts = [
        'products' => 'json',
        'address' => 'json'
    ];
}
