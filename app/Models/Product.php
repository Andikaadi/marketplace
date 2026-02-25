<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'price',
        'location',
        'image',
        'condition',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    /**
     * Get the user that owns the product
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the category that belongs to the product
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get formatted price
     */
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format((float)$this->price, 0, ',', '.');
    }
}
