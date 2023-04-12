<?php

namespace App\Models;

use App\Validators\CategoryRequestValidator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    use CategoryRequestValidator;

    protected $guarded = ['id'];

    protected $hidden = ['id'];
}
