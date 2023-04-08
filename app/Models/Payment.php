<?php

namespace App\Models;

use App\Validators\PaymentRequestValidator;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    use PaymentRequestValidator;

    protected $guarded = ['id'];

    protected $hidden = ['id'];

    protected $casts = [
        'details' => 'json',
    ];
}
