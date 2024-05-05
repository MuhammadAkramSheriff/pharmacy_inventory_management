<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $fillable = [
        'name',
        'description',
        'category',
        'manufactorer',
        'expiry_date',
        'unit_price',
        'available_quantity',
        'minimum_quantity'
    ];
}
