<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = "products";

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price',
        'stock',
        'image',
   ];

   public function category()
   {
        return $this->belongsTo(Category::class, 'category_id');
   }

   public function orderDetails()
   {
        return $this->hasMany(OrderDetail::class, 'product_id');
   }

   public function cartDetails()
   {
        return $this->hasMany(CartDetail::class, 'product_id');
   }
}
