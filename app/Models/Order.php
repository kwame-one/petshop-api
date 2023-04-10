<?php

namespace App\Models;

use App\Validators\OrderRequestValidator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

class Order extends Model
{
    use HasFactory;
    use OrderRequestValidator;
    use HasJsonRelationships;

    protected $guarded = ['id'];

    protected $hidden = ['id'];

    protected $with = ['user', 'payment', 'orderStatus'];

    protected $casts = [
        'products' => 'json',
        'address' => 'json'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class, 'payment_id');
    }

    public function orderStatus(): BelongsTo
    {
        return $this->belongsTo(OrderStatus::class, 'order_status_id');
    }
}
