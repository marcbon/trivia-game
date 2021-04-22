<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'question',
        'answer',
        'difficulty',
        'category_id'
    ];
    
    protected $casts = [
        'difficulty' => 'integer',
        'category_id' => 'integer'
    ];
}
