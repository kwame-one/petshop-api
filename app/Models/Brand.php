<?php

namespace App\Models;

use App\Validators\BrandRequestValidator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    use BrandRequestValidator;

    protected $guarded = ['id'];

    protected $hidden = ['id'];
}
