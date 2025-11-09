<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'description',
        'amount',
        'type',
        'category',
        'receipt_image',
        // PERBAIKAN 1: Mengubah 'date' menjadi 'transaction_date'
        'transaction_date' 
    ];

    protected $casts = [
        // PERBAIKAN 2: Mengubah 'date' menjadi 'transaction_date'
        'transaction_date' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}