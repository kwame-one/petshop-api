<?php

namespace App\Models;

use App\Validators\ProductRequestValidator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    use ProductRequestValidator;
    use HasJsonRelationships;

    protected $guarded = ['id'];

    protected $hidden = ['id'];

    protected $with = ['category', 'brand'];

    protected $casts = [
        'metadata' => 'json',
    ];


    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_uuid', 'uuid');
    }
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'metadata->brand', 'uuid');
    }
}
