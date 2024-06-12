<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleModel extends Model
{
    use HasFactory;
    protected $table = "article";
    protected $guard = "*";
    protected $casts = [
        'created_at' => 'datetime:d M Y',
    ];
}
