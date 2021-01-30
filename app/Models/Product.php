<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Category;
use App\Models\Seller;
use App\Models\Transaction;

class Product extends Model
{
    use HasFactory, SoftDeletes;

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
    
    protected $hidden = [
        'pivot'
    ];
    
    protected $dates  = ['deleted_at'];

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
