<?php

namespace App\Models;

use App\Validators\OrderRequestValidator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Schema;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

class Order extends Model
{
    use HasFactory;
    use OrderRequestValidator;
    use HasJsonRelationships;

    protected $guarded = ['id'];

    protected $hidden = ['id', 'payment_id', 'order_status_id', 'user_id', 'updated_at'];

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

    public function scopeExclude($query, $columns)
    {
        return $query->select(array_diff(Schema::getColumnListing($this->getTable()), (array) $columns));
    }
}
