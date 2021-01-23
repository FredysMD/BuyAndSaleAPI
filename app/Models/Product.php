<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Category;
use App\Models\Seller;
use App\Models\Transaction;

class Product extends Model
{
    use HasFactory;

    const ENABLE_PRODUCT = 'enable product';
    const DISABLE_PRODUCT = 'disable product';

    protected $fillable = [

    	'name',
    	'description',
    	'quantity',
    	'status',
    	'image',
    	'seller_id',

    ];

    public function isEnable()
    {
    	return $this->status == Product::ENABLE_PRODUCT;
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
