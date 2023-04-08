<?php

namespace App\Models;

use App\Validators\FileRequestValidator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;
    use FileRequestValidator;

    protected $guarded = ['id'];

    protected $hidden = ['id'];
}
